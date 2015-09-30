<?php

namespace Laraerp\Http\Services;

use Carbon\Carbon;
use Exception;
use JansenFelipe\NFePHPSerialize\NFePHPSerialize;
use JansenFelipe\NFePHPSerialize\NotaFiscal\NfeProc;
use Laraerp\Contracts\Repositories\ClienteRepository;
use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Contracts\Repositories\FaturaRepository;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Contracts\Repositories\NotaFiscalItemRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImportarNFeService {

    /**
     * Empresa
     *
     * @var EmpresaEntity
     */
    private $empresa;

    /**
     * Path XML
     *
     * @var string
     */
    private $pathXml;

    /**
     * Nota fiscal
     *
     * @var NfeProc
     */
    private $nfeProc;

    /**
     * Repositorio de notas fiscais
     *
     * @var NotaFiscalRepository
     */
    private $notaFiscalRepository;

    /**
     * Repositorio de itens de notas fiscais
     *
     * @var NotaFiscalItemRepository
     */
    private $notaFiscalItemRepository;

    /**
     * Repositorio de clientes
     *
     * @var ClienteRepository
     */
    private $clienteRepository;

    /**
     * Repositorio de fornecedores
     *
     * @var FornecedorRepository
     */
    private $fornecedorRepository;

    /**
     * Repositorio de endereços
     *
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * Repositorio de contato
     *
     * @var ContatoRepository
     */
    private $contatoRepository;

    /**
     * Repositorio de fatura
     *
     * @var FaturaRepository
     */
    private $faturaRepository;

    /**
     * Construtor
     *
     * @return null
     */
    public function __construct() {
        $this->empresa = app('empresa');

        $this->notaFiscalRepository = app(NotaFiscalRepository::class);
        $this->notaFiscalItemRepository = app(NotaFiscalItemRepository::class);
        $this->clienteRepository = app(ClienteRepository::class);
        $this->fornecedorRepository = app(FornecedorRepository::class);
        $this->enderecoRepository = app(EnderecoRepository::class);
        $this->contatoRepository = app(ContatoRepository::class);
        $this->faturaRepository = app(FaturaRepository::class);
    }

    /**
     * Lê o XML
     *
     * @params UploadedFile $file
     * @throws Exception
     * @return ImportarNFeService
     */
    public function setXml(UploadedFile $file) {

        $this->nfeProc = NFePHPSerialize::xmlToObject(file_get_contents($file->getRealPath()));

        /*
         * Verifica se é uma Nota Fiscal Eletronica
         */
        if(is_null($this->nfeProc->getNFe()))
            throw new Exception("Não é uma NFe válida");

        /*
         * Verifica se é uma Nota Fiscal Eletronica
         */
        if($this->nfeProc->getVersao() != "3.10")
            throw new Exception("A versão da NFe não é 3.10");

        /*
         * Verificando se a chave nfe ja existe
         */
        $chave = $this->nfeProc->getNFe()->getInfNFe()->getId();

        if(!is_null($this->notaFiscalRepository->getByChaveNFe($chave)))
            throw new Exception("A nota fiscal eletronica $chave ja consta no banco de dados");

        /*
         * Guardando o xml
         */
        $dir  = base_path() . '/storage/nfe/'.date('Y-m').'/';
        $name = $file->getClientOriginalName();

        $file->move($dir, $name);

        $this->pathXml = $dir.$name;

        return $this;
    }

    /**
     * Processa a nota fiscal
     *
     * @return mixed
     */
    public function processar() {

        /*
         * Verificando se a nota fiscal é de entrada ou saida.
         *
         * Se o CNPJ do emitente for igual ao CNPJ Empresa, então é SAIDA
         * Se o CNPJ do destinatario for igual ao CNPJ Empresa, então é ENTRADA
         */
        $documentoEmpresa = $this->empresa->pessoa->documento;

        //Buscando CNPJ do emitente
        $cnpjEmitente = $this->nfeProc->getNFe()->getInfNFe()->getEmit()->getCNPJ();

        //Buscando CNPJ do destinatario
        $cnpjDestinatario = $this->nfeProc->getNFe()->getInfNFe()->getDest()->getCNPJ();

        if ($cnpjEmitente == $documentoEmpresa) {

            return $this->saida();

        } elseif ($cnpjDestinatario == $documentoEmpresa) {

            return $this->entrada();

        } else
            throw new Exception("O xml não é uma NFe válida para esta empresa");
    }

    /**
     * Processa a nota fiscal de SAIDA
     *
     * @return mixed
     */
    private function saida() {

        //Buscando destinatario
        $destinatario = $this->nfeProc->getNFe()->getInfNFe()->getDest();

        //Dados do cliente
        $cliente = $this->clienteRepository->save([
            'empresa_id' => $this->empresa->id,
            'documento' => $destinatario->getCNPJ(),
            'nome' => $destinatario->getXNome(),
            'razao_apelido' => $destinatario->getXNome(),
            'inscricao_estadual' => $destinatario->getIE()
        ]);

        //Endereço do cliente
        $enderecoDest = $destinatario->getEnderDest();

        //Salvar endereco
        $this->enderecoRepository->save([
            'pessoa_id' => $cliente->pessoa->id,
            'cep' => $enderecoDest->getCEP(),
            'logradouro' => $enderecoDest->getXLgr(),
            'numero' => $enderecoDest->getNro(),
            'bairro' => $enderecoDest->getXBairro(),
            'cidade' => $enderecoDest->getXMun(),
            'uf' => $enderecoDest->getUF()
        ]);

        //Salvar contato
        $this->contatoRepository->save([
            'pessoa_id' => $cliente->pessoa->id,
            'telefone' => $enderecoDest->getFone(),
            'email' => $destinatario->getEmail()
        ]);

        //Salvando nota fiscal de saida
        $this->salvarNotaFiscal($cliente->id, null);

        return 'Nota fiscal de SAIDA enviada com sucesso!';
    }

    /**
     * Processa a nota fiscal de ENTRADA
     *
     * @return mixed
     */
    private function entrada() {

        //Buscando emitente
        $emitente = $this->nfeProc->getNFe()->getInfNFe()->getEmit();

        //Dados do fornecedor
        $fornecedor = $this->fornecedorRepository->save([
            'empresa_id' => $this->empresa->id,
            'documento' => $emitente->getCNPJ(),
            'nome' => $emitente->getXNome(),
            'razao_apelido' => $emitente->getXNome(),
            'inscricao_estadual' => $emitente->getIE()
        ]);

        //Endereço do fornecedor
        $enderecoEmit = $emitente->getEnderEmit();

        //Salvar endereco
        $this->enderecoRepository->save([
            'pessoa_id' => $fornecedor->pessoa->id,
            'cep' => $enderecoEmit->getCEP(),
            'logradouro' => $enderecoEmit->getXLgr(),
            'numero' => $enderecoEmit->getNro(),
            'bairro' => $enderecoEmit->getXBairro(),
            'cidade' => $enderecoEmit->getXMun(),
            'uf' => $enderecoEmit->getUF()
        ]);

        //Salvar contato
        $this->contatoRepository->save([
            'pessoa_id' => $fornecedor->pessoa->id,
            'telefone' => $enderecoEmit->getFone()
        ]);

        //Salvando nota fiscal de entrada
        $this->salvarNotaFiscal(null, $fornecedor->id);

        return 'Nota fiscal de ENTRADA enviada com sucesso!';
    }

    /**
     * Salva Nota fiscal
     *
     * @return null
     */
    private function salvarNotaFiscal($cliente_id = null, $fornecedor_id = null){

        /*
         * Pegando informações para incluir a nota fiscal
         */
        $infNfe = $this->nfeProc->getNFe()->getInfNFe();
        $ide = $infNfe->getIde();


        //Salvar Nota Fiscal
        $notaFiscal = $this->notaFiscalRepository->save([
            'chave_nfe' => $infNfe->getId(),
            'empresa_id' => $this->empresa->id,
            'cliente_id' => $cliente_id,
            'fornecedor_id' => $fornecedor_id,
            'data' => Carbon::createFromFormat('Y-m-d\TH:i:sP', $ide->getDhEmi()),
            'modelo'=> $ide->getMod(),
            'numero' => $ide->getNNF(),
            'serie' => $ide->getSerie(),
            'valor_frete' => $infNfe->getTotal()->getICMSTot()->getVFrete(),
            'valor_total' => $infNfe->getTotal()->getICMSTot()->getVNF(),
            'path_xml' => $this->pathXml
        ]);


        /*
         * Pegando itens da nota fiscal
         */
        $dets = $this->nfeProc->getNFe()->getInfNFe()->getDet();

        if(is_array($dets) && count($dets)>0){

            try{
                //Percorrendo e salvando itens da nota fiscal
                foreach($dets as $det){

                    $this->notaFiscalItemRepository->save([
                        'nota_fiscal_id' => $notaFiscal->id,
                        'codigo' => $det->getProd()->getCProd(),
                        'descricao' => $det->getProd()->getXProd(),
                        'ncm' => $det->getProd()->getNCM(),
                        'cfop' => $det->getProd()->getCFOP(),
                        'quantidade' => $det->getProd()->getQCom(),
                        'unidade' => $det->getProd()->getUCom(),
                        'valor_unitario' => $det->getProd()->getVUnCom(),
                        'valor_total' => $det->getProd()->getVProd()
                    ]);
                }
            }catch (Exception $e){

                if (preg_match('/nota_fiscal_items_ncm_foreign/', $e->getMessage()))
                    throw new Exception('O NCM "'.$det->getProd()->getNCM().'" não foi encontrado.');

                if (preg_match('/nota_fiscal_items_cfop_foreign/', $e->getMessage()))
                    throw new Exception('O CFOP "'.$det->getProd()->getCFOP().'" não foi encontrado.');

                throw $e;
            }
        }


        /*
         * Salvando faturas
         */
        $cobr = $infNfe->getCobr();

        if(!is_null($cobr)){
            $dups = $cobr->getDup();

            if(is_array($dups) && count($dups)>0){

                //Percorrendo e salvando faturas
                foreach($dups as $dup){
                    $vDup = $dup->getVDup();
                    $data = Carbon::createFromFormat('Y-m-d', $dup->getDVenc());
                    $diff = Carbon::now()->diffInDays($data, false);

                    //Se informado o fornecedor, então é debito
                    if(!is_null($fornecedor_id))
                        $valor = $vDup * -1;

                    //Se informado o cliente, então é credito
                    if(!is_null($cliente_id))
                        $valor = $vDup;

                    $this->faturaRepository->save([
                        'empresa_id' => $this->empresa->id,
                        'nota_fiscal_id' => $notaFiscal->id,
                        'numero' => $dup->getNDup(),
                        'data' => $data,
                        'valor' => $valor,
                        'valor_pago' => ($diff<0)?$vDup:0,
                        'data_pagamento' => ($diff<0)?$data:null
                    ]);
                }
            }
        }

    }

}

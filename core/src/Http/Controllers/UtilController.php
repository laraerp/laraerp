<?php

namespace Laraerp\Http\Controllers;


use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use JansenFelipe\CepGratis\CepGratis;
use JansenFelipe\CnpjGratis\CnpjGratis;
use JansenFelipe\CpfGratis\CpfGratis;
use JansenFelipe\Utils\Utils;
use Laraerp\Contracts\Repositories\CidadeRepository;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Contracts\Repositories\ProdutoRepository;

class UtilController extends Controller
{
    /**
     * Retorna uma lista de UF's
     */
    public function ufs(CidadeRepository $cidadeRepository) {
        return response()->json($cidadeRepository->getUFs());
    }

    /**
     * Retorna uma lista de cidade de uma UF
     */
    public function cidades($uf = null, CidadeRepository $cidadeRepository) {
        return response()->json($cidadeRepository->getByUF($uf));
    }

    /**
     * Efetua consulta no site dos Correios
     */
    public function cep($cep = null) {
        try{
            return response()->json(['code' => 0, 'endereco' => CepGratis::consulta($cep)]);
        }catch(Exception $e){
            return response()->json(['code' => 99, 'message' => $e->getMessage()]);
        }
    }

    /**
     * Retorna os parâmetros necessários para realizar a consulta de CNPJ no site da Receita
     *
     * @return Response
     */
    public function parametrosReceita(Request $request)
    {
        $documento = $request->get('documento');

        /*
         * Parametros CNPJ
         */
        if (Utils::isCnpj($documento))
            return response()->json(array('code' => 0, 'params' => CnpjGratis::getParams()));

        /*
         * Parametros CPF
         */
        if (Utils::isCpf($documento)){
            $params = CpfGratis::getParams();
            unset($params['audio']);

            return response()->json(array('code' => 0, 'params' => $params));
        }

        return response()->json(array('code' => 1, 'message' => 'O documento não é válido'));
    }

    /**
     * Efetua consulta de CNPJ no site da Receita
     *
     * @return Response
     */
    public function consultaReceita(Request $request)
    {
        $documento = $request->get('documento');
        $captcha = $request->get('captcha');
        $cookie = $request->get('cookie');

        try {

            /*
             * Consultando CNPJ
             */
            if (Utils::isCnpj($documento))
                $response = CnpjGratis::consulta($documento, $captcha, $cookie);

            /*
             * Consultando CPF
             */
            if (Utils::isCpf($documento)){
                $nascimento = $request->get('nascimento');
                $response = CpfGratis::consulta($documento, $nascimento, $captcha, $cookie);
            }

            /*
             * Verificando resposta
             */
            if(is_null($response))
                throw new Exception('O documento não é válido');

            else{
                if(count($response)==0)
                    throw new Exception('Nenhum dado foi retornado. Tente novamente');
                else
                    return response()->json(array('code' => 0, 'params' => $response));
            }

        } catch (Exception $e) {
            return response()->json(array('code' => 1, 'message' => $e->getMessage()));
        }
    }

    /**
     * Retorna uma lista filtrada de fornecedores no formato json
     *
     * @return JsonResponse
     */
    public function fornecedores(Request $request, FornecedorRepository $fornecedorRepository)
    {
        $like = $request->get('like');

        $result = [];

        //Buscando fornecedores
        $fornecedores = $fornecedorRepository->whereLike($like)->all();

        foreach($fornecedores as $fornecedor){
            $result[] = [
                'id' => $fornecedor->id,
                'documento' => $fornecedor->pessoa->documento,
                'nome' =>  $fornecedor->pessoa->nome
            ];
        }

        return response()->json($result);
    }

    /**
     * Retorna uma lista filtrada de produtos no formato json
     *
     * @return JsonResponse
     */
    public function produtos(Request $request, ProdutoRepository $produtoRepository)
    {
        $like = $request->get('like');

        $result = [];

        //Buscando produtos
        $produtos = $produtoRepository->whereLike($like)->all();

        foreach($produtos as $produto){
            $result[] = [
                'id' => $produto->id,
                'descricao' => $produto->descricao
            ];
        }

        return response()->json($result);
    }

}

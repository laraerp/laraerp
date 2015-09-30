<?php

namespace Laraerp\Http\Controllers;

use Illuminate\Http\Request;
use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Http\Requests\FornecedorSalvarRequest;
use Laraerp\Http\Requests\PessoaSalvarRequest;

class FornecedorController extends Controller
{
    /**
     * Repositorio de fornecedors
     *
     * @var FornecedorRepository
     */
    private $fornecedorRepository;

    /**
     * FornecedorController constructor.
     *
     * @param $fornecedorRepository
     */
    public function __construct(FornecedorRepository $fornecedorRepository)
    {
        $this->fornecedorRepository = $fornecedorRepository;
    }

    /**
     * Exibe uma lista de fornecedors cadastrados
     *
     * @return View
     */
    public function index(Request $request) {

        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'ASC');
        $by = $request->get('by', 'pessoa.nome');

        //Buscando todos os fornecedors
        $fornecedores = $this->fornecedorRepository
            ->order($by, $order)
            ->whereLike($like)
            ->paginate($limit);

        return view('fornecedor.index', compact('fornecedores'));
    }

    /**
     * Exibe formulário para criação de fornecedor
     *
     * @return Response
     */
    public function form() {
        return view('fornecedor.form');
    }

    /**
     * Salva um fornecedor
     */
    public function salvar(PessoaSalvarRequest $request, EnderecoRepository $enderecoRepository, ContatoRepository $contatoRepository) {

        /*
         * Parametros
         */
        $params = $request->all();
        $params['empresa_id'] = app('empresa')->id;

        /*
         * Salvando dados do fornecedor
         */
        $fornecedor = $this->fornecedorRepository->save($params);

        /*
         * Salvando endereço
         */
        if($request->enderecoPreenchido()) {
            $endereco = $request->get('endereco');
            $endereco['pessoa_id'] = $fornecedor->pessoa_id;

            $enderecoRepository->save($endereco);
        }

        /*
         * Salvando contato
         */
        if($request->contatoPreenchido()) {
            $contato = $request->get('contato');
            $contato['pessoa_id'] = $fornecedor->pessoa_id;

            $contatoRepository->save($contato);
        }

        /*
         * Redirecionando
         */
        return redirect(route('fornecedores.ver', $fornecedor->id))->with('alert', 'O fornecedor foi salvo com sucesso!');
    }

    /**
     * Visualiza um fornecedor
     *
     * @return Response
     */
    public function ver($id) {

        /*
         * Buscando fornecedor pelo ID
         */
        $fornecedor = $this->fornecedorRepository->getById($id);

        if(is_null($fornecedor))
            return redirect()->back()->with('erro', 'Fornecedor não encontrado');

        return view('fornecedor.ver')->with(compact('fornecedor'));
    }

    /**
     * Exclui um fornecedor
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->fornecedorRepository->remove($id))
            return redirect()->back()->with('erro', 'O fornecedor não pode ser removido. Verifique se existe algum dado relacionado a ele.');

        return redirect()->back()->with('alert', 'O fornecedor foi removido com sucesso');
    }
}

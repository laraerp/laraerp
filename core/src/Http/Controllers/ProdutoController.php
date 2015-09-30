<?php

namespace Laraerp\Http\Controllers;

use Illuminate\Http\Request;
use Laraerp\Contracts\Repositories\ProdutoRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaFatorRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaRepository;
use Laraerp\Http\Requests\ProdutoSalvarRequest;

class ProdutoController extends Controller
{
    /**
     * Repositorio de produtos
     *
     * @var ProdutoRepository
     */
    private $produtoRepository;

    /**
     * ProdutoController constructor.
     *
     * @param $produtoRepository
     */
    public function __construct(ProdutoRepository $produtoRepository)
    {
        $this->produtoRepository = $produtoRepository;
    }

    /**
     * Exibe uma lista de produtos cadastrados
     *
     * @return View
     */
    public function index(Request $request) {

        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'ASC');
        $by = $request->get('by', 'descricao');

        //Buscando todos os produtos
        $produtos = $this->produtoRepository
            ->order($by, $order)
            ->whereLike($like)
            ->paginate($limit);

        return view('produto.index', compact('produtos'));
    }

    /**
     * Exibe formulário para criação de produto
     *
     * @return Response
     */
    public function form(UnidadeMedidaRepository $unidadeMedidaRepository) {

        //Buscando todas as unidade de medida
        $unidadeMedidas = $unidadeMedidaRepository->all();

        return view('produto.form', compact('unidadeMedidas'));
    }

    /**
     * Salva um produto
     */
    public function salvar(ProdutoSalvarRequest $request) {

        /*
         * Parametros
         */
        $params = $request->all();
        $params['empresa_id'] = app('empresa')->id;
        $params['cfop'] = empty($params['cfop'])?null:$params['ncm'];
        $params['ncm'] = empty($params['ncm'])?null:$params['ncm'];

        /*
         * Salvando dados do produto
         */
        $produto = $this->produtoRepository->save($params);

        /*
         * Redirecionando
         */
        return redirect(route('produtos.ver', $produto->id))->with('alert', 'O produto foi salvo com sucesso!');
    }

    /**
     * Visualiza um produto
     *
     * @return Response
     */
    public function ver($id, UnidadeMedidaFatorRepository $unidadeMedidaFatorRepository) {

        /*
         * Buscando produto pelo ID
         */
        $produto = $this->produtoRepository->getById($id);

        if(is_null($produto))
            return redirect()->back()->with('erro', 'Produto não encontrado');

        /*
         * Buscando todas os fatores de unidade de medida
         * de acordo com a unidade de medida do produto
         */
        $unidadeMedidaFatores = $unidadeMedidaFatorRepository->whereUnidadeMedida($produto->unidade_medida_id)->all();

        return view('produto.ver')->with(compact('produto', 'unidadeMedidaFatores'));
    }

    /**
     * Exclui um produto
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->produtoRepository->remove($id))
            return redirect()->back()->with('erro', 'O produto não pode ser removido. Verifique se existe algum dado relacionado a ele.');

        return redirect()->back()->with('alert', 'O produto foi removido com sucesso');
    }
}

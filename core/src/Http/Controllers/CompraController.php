<?php

namespace Laraerp\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Contracts\Repositories\NotaFiscalItemRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Laraerp\Contracts\Repositories\ProdutoRepository;
use Laraerp\Eloquent\Models\Produto;
use Laraerp\Http\Requests\CompraRelacionarProdutoItemRequest;
use Laraerp\Http\Requests\CompraSalvarRequest;

class CompraController extends Controller
{
    /**
     * Repositorio de notas fiscais
     *
     * @var NotaFiscalRepository
     */
    private $notaFiscalRepository;

    /**
     * ClienteController constructor.
     *
     * @param $clienteRepository
     */
    public function __construct(NotaFiscalRepository $notaFiscalRepository)
    {
        $this->notaFiscalRepository = $notaFiscalRepository;
    }

    /**
     * Exibe uma lista de notas fiscais de entrada (Compra)
     *
     * @return View
     */
    public function index(Request $request) {

        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'DESC');
        $by = $request->get('by', 'data');

        //Buscando todos as compras
        $compras = $this->notaFiscalRepository
            ->order($by, $order)
            ->whereTipo('entrada')
            ->whereLike($like)
            ->paginate($limit);

        return view('compra.index', compact('compras'));
    }

    /**
     * Exibe uma lista de itens das notas fiscais de entrada (Compra)
     *
     * @return Response
     */
    public function itens(Request $request, NotaFiscalItemRepository $notaFiscalItemRepository) {

        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'DESC');
        $by = $request->get('by', 'notaFiscal.data');

        //Buscando todos itens das compras
        $itens = $notaFiscalItemRepository
            ->order($by, $order)
            ->whereTipo('entrada')
            ->whereLike($like)
            ->paginate($limit);

        return view('compra.itens', compact('itens'));
    }

    /**
     * Salva uma compra
     */
    public function salvar(CompraSalvarRequest $request, FornecedorRepository $fornecedorRepository) {

        //Buscando fornecedor selecionado
        $fornecedor_id = $request->get('fornecedor_id');

        //Se não foi informado um fornecedor, cria um.
        if(empty($fornecedor_id) || $fornecedor_id <= 0){

            //Parametros
            $params = $request->all();
            $params['empresa_id'] = app('empresa')->id;

            //Salvando fornecedor
            $fornecedor = $fornecedorRepository->save($params);

            //Set fornecedor_id
            $fornecedor_id = $fornecedor->id;
        }

        //Salvando compra
        $compra = $this->notaFiscalRepository->save([
            'fornecedor_id' => $fornecedor_id,
            'empresa_id' => app('empresa')->id,
            'data' => Carbon::now()
        ]);

        /*
         * Redirecionando
         */
        return redirect(route('compras.ver', $compra->id))->with('alert', 'A compra foi salva com sucesso!');
    }

    /**
     * Visualiza uma compra
     *
     * @return Response
     */
    public function ver($id)
    {
        $notafiscal = $this->notaFiscalRepository->getById($id);

        if(is_null($notafiscal))
            return redirect()->back()->with('erro', 'Nota fiscal não encontrada')->withInput();

        if(is_null($notafiscal->fornecedor))
            return redirect()->back()->with('erro', 'Nota fiscal não é de entrada')->withInput();

        return view('compra.ver')->with(compact('notafiscal'));
    }

    /**
     * Exclui uma compra
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->notaFiscalRepository->remove($id))
            return redirect()->back()->with('erro', 'A compra não pode ser removida. Verifique se existe algum dado relacionado a ela.');

        return redirect()->back()->with('alert', 'A compra foi removida com sucesso');
    }

    /**
     * Relaciona um item com o produto
     *
     * @return JsonResponse
     */
    public function relacionarProdutoItem(CompraRelacionarProdutoItemRequest $request, ProdutoRepository $produtoRepository, NotaFiscalItemRepository $notaFiscalItemRepository) {

        $params = [
            'id' => $request->get('nota_fiscal_item_id'),
            'produto_id' => $request->get('produto_id')
        ];

        if($request->exists('produto_nome')){
            $produto = $produtoRepository->save(['empresa_id' => app('empresa')->id, 'tipo'=> 'ENTRADA', 'descricao' => $request->get('produto_nome')]);
            $params['produto_id'] = $produto->id;
        }

        $notaFiscalItemRepository->save($params);

        return response()->json(['code' => 0, 'mmessage' => 'O relacionamento de produto/item foi realizado com sucesso']);
    }
}
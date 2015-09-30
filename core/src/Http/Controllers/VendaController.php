<?php

namespace Laraerp\Http\Controllers;

use Illuminate\Http\Request;
use Laraerp\Contracts\Repositories\NotaFiscalItemRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;

class VendaController extends Controller
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
     * Exibe uma lista de notas fiscais de saida (Venda)
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

        //Buscando todos as vendas
        $vendas = $this->notaFiscalRepository
            ->order($by, $order)
            ->whereTipo('saida')
            ->whereLike($like)
            ->paginate($limit);

        return view('venda.index', compact('vendas'));
    }

    /**
     * Exibe uma lista de itens das notas fiscais de saida (Venda)
     *
     * @return Response
     */
    public function itens(Request $request, NotaFiscalItemRepository $notaFiscalItemRepository) {

        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Buscando todos itens das vendas
        $itens = $notaFiscalItemRepository->whereTipo('saida')->whereLike($like)->paginate($limit);

        return view('venda.itens', compact('itens'));
    }

    /**
     * Visualiza uma venda
     *
     * @return Response
     */
    public function ver($id)
    {
        $notaFiscal = $this->notaFiscalRepository->getById($id);

        if(is_null($notaFiscal))
            return redirect()->back()->with('erro', 'Nota fiscal não encontrada')->withInput();

        if(is_null($notaFiscal->cliente))
            return redirect()->back()->with('erro', 'Nota fiscal não é de entrada')->withInput();

        return view('venda.ver')->with(compact('notaFiscal'));
    }

    /**
     * Exclui uma venda
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->notaFiscalRepository->remove($id))
            return redirect()->back()->with('erro', 'A venda não pode ser removida. Verifique se existe algum dado relacionado a ela.');

        return redirect()->back()->with('alert', 'A venda foi removida com sucesso');
    }
}

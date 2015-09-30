<?php

namespace Laraerp\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Laraerp\Contracts\Repositories\FaturaRepository;

class FinanceiroController extends Controller
{

    /**
     * Repositorio de faturas
     *
     * @var FaturaRepository
     */
    private $faturaRepository;

    /**
     * FinanceiroController constructor.
     *
     * @param $faturaRepository
     */
    public function __construct(FaturaRepository $faturaRepository)
    {
        $this->faturaRepository = $faturaRepository;
    }

    /**
     * Lista de faturas em formato de extrato
     *
     * @return Response
     */
    public function extrato(Request $request)
    {
        $dias = $request->get('dias', 30);

        $extrato = $this->faturaRepository->extrato($dias);

        return view('financeiro.extrato', compact('extrato', 'dias'));
    }

    /**
     * Lista de contas a pagar
     *
     * @return Response
     */
    public function contasPagar(Request $request)
    {
        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'DESC');
        $by = $request->get('by', 'data');

        $faturas = $this->faturaRepository
            ->order($by, $order)
            ->contasPagar()
            ->whereLike($like)
            ->paginate($limit);

        return view('financeiro.contasPagar', compact('faturas'));
    }

    /**
     * Lista de contas a receber
     *
     * @return Response
     */
    public function contasReceber(Request $request)
    {
        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'DESC');
        $by = $request->get('by', 'data');

        $faturas = $this->faturaRepository
            ->order($by, $order)
            ->contasReceber()
            ->whereLike($like)
            ->paginate($limit);

        return view('financeiro.contasReceber', compact('faturas'));
    }

}
<?php

namespace Laraerp\Http\Controllers;

use Carbon\Carbon;
use Laraerp\Contracts\Repositories\FaturaRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;

class DashboardController extends Controller
{
    /**
     * Mostra o dashboard
     *
     * @return Response
     */
    public function index(FaturaRepository $faturaRepository, NotaFiscalRepository $notaFiscalRepository)
    {
        /*
         * Gráfico de Receixa x Despesa
         */

        //Periodo
        $de =  Carbon::now()->subMonth(6)->startOfMonth();
        $ate = Carbon::now()->endOfMonth();

        //Buscando compras
        $compras = $notaFiscalRepository
            ->whereTipo('entrada')
            ->totalPorMes($de, $ate);

        //Buscando vendas
        $vendas = $notaFiscalRepository
            ->whereTipo('saida')
            ->totalPorMes($de, $ate);

        //Buscando despesas
        $despesas = $faturaRepository
            ->contasPagar()
            ->totalPorMes($de, $ate);

        //Buscando receitas
        $receitas = $faturaRepository
            ->contasReceber()
            ->totalPorMes($de, $ate);

        /*
         * Contas a pagar
         */
        $contasPagar = $faturaRepository
            ->order('data', 'ASC')
            ->limit(5)
            ->contasPagar()
            ->naoPago()
            ->all();

        /*
         * Contas a receber
         */
        $contasReceber = $faturaRepository
            ->order('data', 'ASC')
            ->limit(5)
            ->contasReceber()
            ->naoPago()
            ->all();

        return view('dashboard.index', compact('compras', 'vendas', 'despesas', 'receitas', 'contasPagar', 'contasReceber'));
    }

}

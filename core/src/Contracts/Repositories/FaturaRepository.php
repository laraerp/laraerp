<?php

namespace Laraerp\Contracts\Repositories;

use Carbon\Carbon;
use Laraerp\Contracts\RepositoryInterface;

interface FaturaRepository extends RepositoryInterface
{
    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ClienteRepository
     */
    public function whereLike($like = null);

    /**
     * Retorna faturas em forma de extrato
     *
     * @param int $dias
     * @return array
     */
    public function extrato($dias);

    /**
     * Aplica condição para retornar faturas com valor negativo
     *
     * @return FaturaRepository
     */
    public function contasPagar();

    /**
     * Aplica condição para retornar faturas com valor positivo
     *
     * @return FaturaRepository
     */
    public function contasReceber();

    /**
     * Aplica condição para retornar faturas com valor pago > 0
     *
     * @return FaturaRepository
     */
    public function pago();

    /**
     * Aplica condição para retornar faturas com valor pago == 0
     *
     * @return FaturaRepository
     */
    public function naoPago();

    /**
     * Aplica condição ($de - $ate) na data
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return FaturaRepository
     */
    public function entre(Carbon $de, Carbon $ate = null);

    /**
     * Retorna total de faturas por mês dentro de um periodo
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return array
     */
    public function totalPorMes(Carbon $de, Carbon $ate);

}
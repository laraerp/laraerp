<?php

namespace Laraerp\Contracts\Repositories;

use Carbon\Carbon;
use Laraerp\Contracts\RepositoryInterface;

interface NotaFiscalRepository extends RepositoryInterface
{

    /**
     * Retorna uma Nota Fiscal Eletronica pela Chave
     *
     * @param string $chaveNFe
     * @return mixed
     */
    public function getByChaveNFe($chaveNFe);

    /**
     * Aplica condição $like
     *
     * @param null $like
     * @return NotaFiscalRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição $tipo
     *
     * @param null $tipo
     * @return NotaFiscalRepository
     */
    public function whereTipo($tipo = null);

    /**
     * Aplica condição ($de - $ate) na data
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return NotaFiscalRepository
     */
    public function entre(Carbon $de, Carbon $ate = null);

    /**
     * Retorna total de notas fiscais por mês dentro de um periodo
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return array
     */
    public function totalPorMes(Carbon $de, Carbon $ate);

}
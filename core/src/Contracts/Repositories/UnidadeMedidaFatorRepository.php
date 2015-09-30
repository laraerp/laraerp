<?php

namespace Laraerp\Contracts\Repositories;

use Laraerp\Contracts\RepositoryInterface;

interface UnidadeMedidaFatorRepository extends RepositoryInterface
{
    /**
     * Aplica condição $idUnidadeMedida no repositório
     *
     * @param null $idUnidadeMedida
     * @return UnidadeMedidaFatorRepository
     */
    public function whereUnidadeMedida($idUnidadeMedida = null);

    /**
     * Retorna uma fator de unidade de medida pelo simbolo
     *
     * @param string $simbolo
     * @return mixed
     */
    public function getBySimbolo($simbolo);
}
<?php

namespace Laraerp\Eloquent\Repositories;

use Laraerp\Contracts\Repositories\UnidadeMedidaFatorSinonimoRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\UnidadeMedidaFatorSinonimo;

class UnidadeMedidaFatorSinonimoEloquentRepository extends BaseRepository implements UnidadeMedidaFatorSinonimoRepository
{

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new UnidadeMedidaFatorSinonimo();
    }
    
    /**
     * Retorna uma fator de unidade de medida pelo simbolo
     *
     * @param string $simbolo
     * @return mixed
     */
    public function getBySimbolo($simbolo)
    {
        return $this->model()->where('simbolo', strtoupper($simbolo))->orWhere('simbolo', strtolower($simbolo))->first();
    }
}
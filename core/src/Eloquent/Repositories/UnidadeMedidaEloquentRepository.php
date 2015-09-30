<?php

namespace Laraerp\Eloquent\Repositories;


use Laraerp\Contracts\Repositories\UnidadeMedidaRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\UnidadeMedida;

class UnidadeMedidaEloquentRepository extends BaseRepository implements UnidadeMedidaRepository
{

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new UnidadeMedida();
    }
}
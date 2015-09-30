<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Models\Contato;

class ContatoEloquentRepository extends BaseRepository implements ContatoRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Contato();
    }
}
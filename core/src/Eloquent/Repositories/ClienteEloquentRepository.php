<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Contracts\Repositories\ClienteRepository;
use Laraerp\Eloquent\BasePessoaRepository;
use Laraerp\Eloquent\Models\Cliente;

class ClienteEloquentRepository extends BasePessoaRepository implements ClienteRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Cliente();
    }

}
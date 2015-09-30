<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Contracts\Repositories\EmpresaEntity;
use Laraerp\Contracts\Repositories\EmpresaRepository;
use Laraerp\Eloquent\BasePessoaRepository;
use Laraerp\Eloquent\Models\Empresa;

class EmpresaEloquentRepository extends BasePessoaRepository implements EmpresaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Empresa();
    }

    /**
     * Retorna o primeira empresa do repositorio
     *
     * @return mixed
     */
    public function getFirst()
    {
        return $this->model()->first();
    }
}
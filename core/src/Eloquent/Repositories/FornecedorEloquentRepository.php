<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Eloquent\BasePessoaRepository;
use Laraerp\Eloquent\Models\Fornecedor;

class FornecedorEloquentRepository extends BasePessoaRepository implements FornecedorRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Fornecedor();
    }

}
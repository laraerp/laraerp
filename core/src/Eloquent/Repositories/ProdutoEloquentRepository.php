<?php

namespace Laraerp\Eloquent\Repositories;

use Laraerp\Contracts\Repositories\ProdutoRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\Produto;

class ProdutoEloquentRepository extends BaseRepository implements ProdutoRepository
{

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Produto();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ProdutoRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like))
            $this->model = $this->model
                ->where('id', $like)
                ->orWhere('codigo', 'like', '%' . $like . '%')
                ->orWhere('descricao', 'like', '%' . $like . '%');

        return $this;
    }

    /**
     * Aplica condição $tipo no repositório
     *
     * @param null $tipo
     * @return ProdutoRepository
     */
    public function whereTipo($tipo = null)
    {
        if(!is_null($tipo))
            $this->model = $this->model->where('tipo', $tipo);

        return $this;
    }
}
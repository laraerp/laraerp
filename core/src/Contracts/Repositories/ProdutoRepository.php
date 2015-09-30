<?php

namespace Laraerp\Contracts\Repositories;

use Laraerp\Contracts\RepositoryInterface;

interface ProdutoRepository extends RepositoryInterface
{

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ProdutoRepository
     */
    public function whereLike($like = null);

    /**
     * Aplica condição $tipo no repositório
     *
     * @param null $tipo
     * @return ProdutoRepository
     */
    public function whereTipo($tipo = null);
}
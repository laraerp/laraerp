<?php

namespace Laraerp\Eloquent;

use Laraerp\Contracts\RepositoryInterface;

abstract class BaseRepository
{
    /**
     * Model eloquent
     *
     * @var Model
     */
    protected $model;

    /**
     * BaseRepository constructor.
     */
    public function __construct()
    {
        $this->model = $this->model();
    }

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    abstract public function model();

    /**
     * Retorna todos os dados do repositório
     *
     * @param array $columns
     * @return Collection
     */
    public function all($columns = array('*'))
    {
        $result = $this->model->get($columns);

        //restart model
        $this->model = $this->model();

        return $result;
    }

    /**
     * Retorna todos os dados do repositório com paginação
     *
     * @param null $limit
     * @param array $columns
     * @return LengthAwarePaginator
     */
    public function paginate($limit = null, array $columns = array('*'))
    {
        //Nome da tabela
        $table = $this->model()->getTable();

        //Pesquisando
        $result = $this->model->select("$table.*")->paginate($limit, $columns);

        //restart model
        $this->model = $this->model();

        return $result;
    }

    /**
     * Aplica ordenação
     *
     * @param null $by
     * @param null $order
     * @return RepositoryInterface
     */
    public function order($by = null, $order = null)
    {
        if(!is_null($by))
            $this->model = $this->model->orderBy($by, $order);

        return $this;
    }

    /**
     * Aplica limite
     *
     * @param int $limit
     * @return RepositoryInterface
     */
    public function limit($limit){

        $this->model = $this->model->limit($limit);

        return $this;
    }

    /**
     * Retorna um dado
     *
     * @param int $id
     * @return mixed
     */
    public function getById($id, $columns = array('*'))
    {
        return $this->model()->find($id, $columns);
    }

    /**
     * Salva um dado no repositório
     *
     * @param array $params
     * @return mixed
     */
    public function save(array $params)
    {
        if (isset($params['id']) && $params['id']>0)
            $model = $this->getById($params['id']);
        else
            $model = $this->model();

        /*
         * Preenchendo..
         */
        $model->fill($params);

        /*
         * Salvando
         */
        $model->save();

        return $model;
    }

    /**
     * Remove um dado do repositório
     *
     * @param int $id
     * @return boolean
     */
    public function remove($id)
    {
        return $this->getById($id)->delete();
    }
}
<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use JansenFelipe\Utils\Utils;
use Laraerp\Contracts\Repositories\PessoaRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Models\Pessoa;

class PessoaEloquentRepository extends BaseRepository implements PessoaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Pessoa();
    }

    /**
     * Retorna uma Pessoa pelo documento
     *
     * @param int $documento
     * @return mixed
     */
    public function getByDocumento($documento)
    {
        return $this->model()->where('documento', Utils::unmask($documento))->first();
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

        elseif (isset($params['documento']))
            $model = $this->getByDocumento($params['documento']);

        if(is_null($model))
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


}
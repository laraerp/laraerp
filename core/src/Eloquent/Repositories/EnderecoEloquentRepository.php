<?php

namespace Laraerp\Eloquent\Repositories;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Contracts\Repositories\CidadeRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Models\Endereco;

class EnderecoEloquentRepository extends BaseRepository implements EnderecoRepository
{
    /**
     * Repositorio de cidades
     *
     * @var CidadeRepository
     */
    private $cidadeRepository;

    /**
     * EnderecoEloquentRepository constructor.
     */
    public function __construct(CidadeRepository $cidadeRepository)
    {
        parent::__construct();

        $this->cidadeRepository = $cidadeRepository;
    }

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Endereco();
    }

    /**
     * Salva um dado no repositório
     *
     * @param array $params
     * @return mixed
     */
    public function save(array $params)
    {
        /*
         * Tentar descobrir cidade_id se informar cidade/UF
         */
        if (isset($params['cidade']) && isset($params['uf'])){
            $cidade = $this->cidadeRepository->getByCidadeUF($params['cidade'], $params['uf']);

            if(!is_null($cidade))
                $params['cidade_id'] = $cidade->id;
        }

        /*
         * Verifica se possui pessoa_id e se já existe um endereço com os parametros informados
         */
        if(isset($params['pessoa_id'])){

            foreach($this->model()->getFillable() as $column)
                if(isset($params[$column]))
                    $where[$column] = $params[$column];

            $endereco = $this->model()->where($where)->first();

            if(!is_null($endereco))
                return $endereco;
        }

        return parent::save($params);
    }


}
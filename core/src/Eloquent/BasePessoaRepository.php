<?php

namespace Laraerp\Eloquent;

use Laraerp\Contracts\Repositories\PessoaRepository;

abstract class BasePessoaRepository extends  BaseRepository
{
    /**
     * Repositório de pessoas
     *
     * @var PessoaRepository
     */
    private $pessoaRepository;

    /**
     * BasePessoaRepository constructor.
     */
    public function __construct(PessoaRepository $pessoaRepository)
    {
        parent::__construct();

        $this->pessoaRepository = $pessoaRepository;
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
         * Salvando dados da pessoa
         */
        $paramsPessoa = $params;

        //Se informar o id do cliente, removê-lo antes de enviar os dados para salvar a pessoa
        if(isset($paramsPessoa['id']) && $paramsPessoa['id'] > 0)
            unset($paramsPessoa['id']);

        //Salvando pessoa
        $pessoa = $this->pessoaRepository->save($paramsPessoa);

        /*
         * Salvando dados
         */

        //Verificando se já existe cliente para a pessoa
        $dados = $this->getByPessoaId($pessoa->id);

        //Se não existir, adiciona no params o id da pessoa
        if(is_null($dados))
            $params['pessoa_id'] = $pessoa->id;

        //Se existir, adiciona no params o id do cliente
        else
            $params['id'] = $dados->id;

        return parent::save($params);
    }

    /**
     * Retorna um dado pelo ID da Pessoa
     *
     * @param int $id
     * @return mixed
     */
    public function getByPessoaId($id)
    {
        return $this->model()->where('pessoa_id', $id)->first();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return BasePessoaRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like)){

            $this->model = $this->model
                ->where('id', $like)
                ->orWhere(function($q) use ($like) {

                    $q->whereHas('pessoa', function ($query) use ($like) {
                        $query->where(function($query) use ($like){
                            $query->where('nome', 'like', '%' . $like . '%');
                            $query->orWhere('razao_apelido', 'like', '%' . $like . '%');
                            $query->orWhere('documento', 'like', '%' . $like . '%');
                        });
                    });

                });
        }

        return $this;
    }
}
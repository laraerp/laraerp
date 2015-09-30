<?php

namespace Laraerp\Eloquent\Repositories;


use Exception;
use Laraerp\Contracts\Repositories\NotaFiscalItemEntity;
use Laraerp\Contracts\Repositories\NotaFiscalItemRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaFatorRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\NotaFiscalItem;

class NotaFiscalItemEloquentRepository extends BaseRepository implements NotaFiscalItemRepository
{
    /**
     * Repositorio de cidades
     *
     * @var UnidadeMedidaFatorRepository
     */
    private $unidadeMedidaFatorRepository;

    /**
     * NotaFiscalItemEloquentRepository constructor.
     */
    public function __construct(UnidadeMedidaFatorRepository $unidadeMedidaFatorRepository)
    {
        parent::__construct();

        $this->unidadeMedidaFatorRepository = $unidadeMedidaFatorRepository;
    }

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new NotaFiscalItem();
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
         * Tentar descobrir unidade_medida_fator_id se informar $params['unidade']
         */
        if (isset($params['unidade'])){
            $fator = $this->unidadeMedidaFatorRepository->getBySimbolo($params['unidade']);

            if(!is_null($fator))
                $params['unidade_medida_fator_id'] = $fator->id;
        }

        return parent::save($params);
    }

    /**
     * Aplica condição $like
     *
     * @param null $like
     * @return NotaFiscalItemRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like))
            $this->model = $this->model->where(function ($query) use ($like){

                $query->where('codigo', 'like', '%' . $like . '%')
                    ->orWhere('descricao', 'like', '%' . $like . '%');

            });

        return $this;
    }

    /**
     * Aplica condição $tipo
     *
     * @param null $tipo
     * @return NotaFiscalItemRepository
     */
    public function whereTipo($tipo = null)
    {
        $this->model = $this->model->whereHas('notaFiscal', function ($query) use ($tipo){

            if(strtoupper($tipo) == 'ENTRADA')
                $query->whereNotNull('fornecedor_id');

            if(strtoupper($tipo) == 'SAIDA')
                $query->whereNotNull('cliente_id');
        });

        return $this;
    }
}
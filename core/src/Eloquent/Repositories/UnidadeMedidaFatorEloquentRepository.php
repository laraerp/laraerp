<?php

namespace Laraerp\Eloquent\Repositories;


use Laraerp\Contracts\Repositories\UnidadeMedidaFatorRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaFatorSinonimoRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\UnidadeMedidaFator;

class UnidadeMedidaFatorEloquentRepository extends BaseRepository implements UnidadeMedidaFatorRepository
{

    /**
     * Repositorio de sinonimos de fator de unidade de medida
     *
     * @var UnidadeMedidaFatorSinonimoRepository
     */
    private $unidadeMedidaFatorSinonimoRepository;

    /**
     * NotaFiscalItemEloquentRepository constructor.
     */
    public function __construct(UnidadeMedidaFatorSinonimoRepository $unidadeMedidaFatorSinonimoRepository)
    {
        parent::__construct();

        $this->unidadeMedidaFatorSinonimoRepository = $unidadeMedidaFatorSinonimoRepository;
    }

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new UnidadeMedidaFator();
    }

    /**
     * Aplica condição $idUnidadeMedida no repositório
     *
     * @param null $idUnidadeMedida
     * @return UnidadeMedidaFatorRepository
     */
    public function whereUnidadeMedida($idUnidadeMedida = null)
    {
        if(!is_null($idUnidadeMedida))
            $this->model = $this->model->where('unidade_medida_id', $idUnidadeMedida);

        return $this;
    }

    /**
     * Retorna uma fator de unidade de medida pelo simbolo
     *
     * @param string $simbolo
     * @return mixed
     */
    public function getBySimbolo($simbolo)
    {
        $fator = $this->model()
            ->where('simbolo', strtoupper($simbolo))
            ->orWhere('simbolo', strtolower($simbolo))->first();

        if(is_null($fator)) {
            $sinonimo = $this->unidadeMedidaFatorSinonimoRepository->getBySimbolo($simbolo);

            if(!is_null($sinonimo))
                $fator = $sinonimo->unidadeMedidaFator;
        }

        return $fator;
    }
}
<?php

namespace Laraerp\Eloquent\Repositories;


use Carbon\Carbon;
use Laraerp\Contracts\Repositories\Collection;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Model;
use Laraerp\Eloquent\Models\NotaFiscal;

class NotaFiscalEloquentRepository extends BaseRepository implements NotaFiscalRepository
{

    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new NotaFiscal();
    }

    /**
     * Retorna uma Nota Fiscal Eletronica pela Chave
     *
     * @param string $chaveNFe
     * @return mixed
     */
    public function getByChaveNFe($chaveNFe)
    {
        return $this->model()->where('chave_nfe', $chaveNFe)->first();
    }

    /**
     * Aplica condição $like
     *
     * @param null $like
     * @return NotaFiscalRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like))
            $this->model = $this->model->where(function ($query) use ($like){

                $query->where('numero', 'like', '%' . $like . '%')
                    ->orWhere('id', $like)
                    ->orWhere(function($q) use ($like) {

                        $q->orWhereHas('cliente', function ($query) use ($like) {
                            $query->whereHas('pessoa', function ($query) use ($like) {
                                $query->where(function($query) use ($like){
                                    $query->where('nome', 'like', '%' . $like . '%');
                                    $query->orWhere('razao_apelido', 'like', '%' . $like . '%');
                                });
                            });
                        });

                        $q->orWhereHas('fornecedor', function ($query) use ($like) {
                            $query->whereHas('pessoa', function ($query) use ($like) {
                                $query->where(function($query) use ($like){
                                    $query->where('nome', 'like', '%' . $like . '%');
                                    $query->orWhere('razao_apelido', 'like', '%' . $like . '%');
                                });
                            });
                        });

                    });
            });

        return $this;
    }

    /**
     * Aplica condição $tipo
     *
     * @param null $tipo
     * @return NotaFiscalRepository
     */
    public function whereTipo($tipo = null)
    {
        if(strtoupper($tipo) == 'ENTRADA')
            $this->model = $this->model->whereNotNull('fornecedor_id');

        if(strtoupper($tipo) == 'SAIDA')
            $this->model = $this->model->whereNotNull('cliente_id');

        return $this;
    }

    /**
     * Aplica condição ($de - $ate) na data
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return NotaFiscalRepository
     */
    public function entre(Carbon $de, Carbon $ate = null)
    {
        //Se não informar $ate, considerar data atual
        if(is_null($ate))
            $ate = Carbon::now();

        $this->model = $this->model->whereBetween('data', [$de, $ate]);

        return $this;
    }



    /**
     * Retorna total de faturas por mês dentro de um periodo
     *
     * @param Carbon $de
     * @param Carbon $ate
     * @return array
     */
    public function totalPorMes(Carbon $de, Carbon $ate){

        //Recreate dates
        $de = Carbon::createFromTimestamp($de->getTimestamp());
        $ate = Carbon::createFromTimestamp($ate->getTimestamp());

        //Aplicando filtro filtro
        $this->entre($de, $ate);

        $result = [];

        //Consultando
        $notas = $this->model
            ->orderBy('data', 'ASC')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->data)->format('Y-m');
            });

        //restart model
        $this->model = $this->model();

        //organizando resposta
        while($de <= $ate){

            //format
            $anoMes = $de->format('Y-m');

            if(in_array($anoMes, $notas->keys()->toArray()))
                $result[$anoMes] = $notas->get($anoMes)->sum('valor_total');
            else
                $result[$anoMes] = 0;

            $de->addMonth(1)->format('Y-m');
        }

        return $result;
    }


}
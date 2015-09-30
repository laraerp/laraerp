<?php

namespace Laraerp\Eloquent\Repositories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laraerp\Contracts\Repositories\FaturaRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Laraerp\Eloquent\BaseRepository;
use Laraerp\Eloquent\Models\Fatura;

class FaturaEloquentRepository extends BaseRepository implements FaturaRepository
{
    /**
     * Cria o model eloquent
     *
     * @return Model
     */
    public function model()
    {
        return new Fatura();
    }

    /**
     * Aplica condição $like no repositório
     *
     * @param null $like
     * @return ClienteRepository
     */
    public function whereLike($like = null)
    {
        if(!is_null($like)){
            $this->model = $this->model->where(function($q) use ($like) {
                $q->orWhere('numero', 'like', '%' . $like . '%');
                $q->orWhere('descricao', 'like', '%' . $like . '%');
            });
        }
        return $this;
    }

    /**
     * Retorna faturas em forma de extrato
     *
     * @param int $dias
     * @return array
     */
    public function extrato($dias)
    {
        if(!ctype_digit(strval($dias)))
            $dias = 30;

        $extrato = ['saldo_anterior' => [], 'total' => 0, 'ultimos_lancamentos' => [], 'lancamentos_futuros' => []];
        $data_corte = Carbon::now()->subDay($dias);
        $total_corte = $this->model()->where('data_pagamento', '<', $data_corte)->sum('valor');

        /*
         * Saldo até a data de corte
         */
        $extrato['saldo_anterior'] = [
            'data_corte' => $data_corte,
            'total' => $total_corte
        ];

        /*
         * Ultimos lancamentos
         */
        $faturas = $this->model()
            ->where('data_pagamento', '>=', $data_corte)
            ->where('data_pagamento', '<=', Carbon::now())
            ->orderBy('data', 'ASC')
            ->get();

        foreach($faturas as $fatura){
            $mesAno = $fatura->data->format('F/Y');
            $extrato['ultimos_lancamentos'][$mesAno]['faturas'][] = $fatura;
            $extrato['total'] += $fatura->valor;

            //Somando total do mes
            if(!isset($extrato['ultimos_lancamentos'][$mesAno]['total']))
                $extrato['ultimos_lancamentos'][$mesAno]['total'] = $fatura->valor;
            else
                $extrato['ultimos_lancamentos'][$mesAno]['total'] += $fatura->valor;
        }

        /*
         * Lancamentos futuros
         */
        $faturas = $this->model()
            ->where('data', '>=', Carbon::now())
            ->whereNull('data_pagamento')
            ->orderBy('data', 'ASC')
            ->get();

        foreach($faturas as $fatura)
            $extrato['lancamentos_futuros'][] = $fatura;

        return $extrato;
    }

    /**
     * Aplica condição para retornar faturas com valor negativo
     *
     * @return FaturaRepository
     */
    public function contasPagar()
    {
        $this->model = $this->model->where('valor', '<', 0);

        return $this;
    }

    /**
     * Aplica condição para retornar faturas com valor positivo
     *
     * @return FaturaRepository
     */
    public function contasReceber()
    {
        $this->model = $this->model->where('valor', '>', 0);

        return $this;
    }

    /**
     * Salva um dado no repositório
     *
     * @param array $params
     * @return mixed
     */
    public function save(array $params)
    {
        $fatura = parent::save($params);

        /*
         * Atualizando valor pago da NotaFiscal (caso exista)
         */
        $notaFiscal = $fatura->notaFiscal;

        if(!is_null($notaFiscal)){
            $soma = 0;

            foreach ($notaFiscal->faturas as $fatura)
                $soma += $fatura->valor_pago;

            $notaFiscalRepositroy = app()->make(NotaFiscalRepository::class);
            $notaFiscalRepositroy->save(['id' => $notaFiscal->id, 'valor_pago' => $soma]);
        }
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
        $faturas = $this->model
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

            if(in_array($anoMes, $faturas->keys()->toArray()))
                $result[$anoMes] = $faturas->get($anoMes)->sum('valor');
            else
                $result[$anoMes] = 0;

            //Convertendo valor negativo
            if($result[$anoMes]<0)
                $result[$anoMes] = $result[$anoMes] * -1;

            $de->addMonth(1)->format('Y-m');
        }

        return $result;
    }

    /**
     * Aplica condição para retornar faturas com valor pago > 0
     *
     * @return FaturaRepository
     */
    public function pago()
    {
        $this->model = $this->model->where('valor_pago', '>', 0);

        return $this;
    }

    /**
     * Aplica condição para retornar faturas com valor pago == 0
     *
     * @return FaturaRepository
     */
    public function naoPago()
    {
        $this->model = $this->model->where('valor_pago', '=', 0);

        return $this;
    }
}
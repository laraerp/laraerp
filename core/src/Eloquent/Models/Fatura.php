<?php

namespace Laraerp\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Fatura extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'empresa_id', 'nota_fiscal_id', 'descricao', 'tipo', 'numero', 'data', 'valor', 'data_pagamento', 'valor_pago'];

    /*
     * Mutators
     */
    protected function getDataAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value);
    }


    protected function getDataPagamentoAttribute($value)
    {
        if(!is_null($value))
            return Carbon::createFromFormat('Y-m-d', $value);
    }

    /*
     * Belong To Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /*
     * Belong To NotaFiscal
     */
    public function notaFiscal()
    {
        return $this->belongsTo(NotaFiscal::class);
    }

}

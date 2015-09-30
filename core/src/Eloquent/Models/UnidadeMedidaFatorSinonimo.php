<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class UnidadeMedidaFatorSinonimo extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'unidade_medida_fator_id', 'simbolo'];

    /*
     * Belong To UnidadeMedidaFator
     */
    public function unidadeMedidaFator(){
        return $this->belongsTo(UnidadeMedidaFator::class);
    }
}

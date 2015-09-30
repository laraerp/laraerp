<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class UnidadeMedidaFator extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'unidade_medida_id', 'simbolo', 'fator'];

    /*
     * Belong To UnidadeMedida
     */
    public function unidadeMedida(){
        return $this->belongsTo(UnidadeMedida::class);
    }
}

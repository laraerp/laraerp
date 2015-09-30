<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Produto extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'empresa_id', 'ncm', 'cfop', 'unidade_medida_id', 'tipo', 'codigo', 'codigo_ean', 'descricao', 'valor_unitario', 'unidade_medida_fator_id'];

    /*
     * Belong To Empresa
     */
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    /*
     * Belong To NCM
     */
    public function ncm(){
        return $this->belongsTo(Ncm::class, 'ncm');
    }

    /*
     * Belong To CFOP
     */
    public function cfop(){
        return $this->belongsTo(Cfop::class, 'cfop');
    }

    /*
     * Belong To UnidadeMedida
     */
    public function unidadeMedida(){
        return $this->belongsTo(UnidadeMedida::class);
    }

    /*
     * Belong To UnidadeMedidaFator
     */
    public function unidadeMedidaFator(){
        return $this->belongsTo(UnidadeMedidaFator::class);
    }
}

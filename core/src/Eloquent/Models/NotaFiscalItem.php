<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class NotaFiscalItem extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'nota_fiscal_id', 'produto_id', 'codigo', 'descricao', 'ncm', 'cfop', 'unidade_medida_fator_id', 'quantidade', 'unidade', 'valor_unitario', 'valor_total'];

    /*
     * Belongs to Nota fiscal
     */
    public function notaFiscal() {
        return $this->belongsTo(NotaFiscal::class);
    }

    /*
     * Belongs to Produto
     */
    public function produto() {
        return $this->belongsTo(Produto::class);
    }

    /*
     * Belong To NCM
     */
    public function ncmDetalhe(){
        return $this->belongsTo(Ncm::class, 'ncm');
    }

    /*
     * Belong To CFOP
     */
    public function cfopDetalhe(){
        return $this->belongsTo(Cfop::class, 'cfop');
    }

    /*
     * Belong To UnidadeMedidaFator
     */
    public function unidadeMedidaFator(){
        return $this->belongsTo(UnidadeMedidaFator::class);
    }
}

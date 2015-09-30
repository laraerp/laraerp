<?php

namespace Laraerp\Eloquent\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class NotaFiscal extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'chave_nfe', 'empresa_id', 'fornecedor_id', 'cliente_id', 'endereco_entrega_id', 'data', 'data_entrega', 'modelo', 'numero', 'serie', 'valor_frete', 'valor_total', 'valor_pago', 'path_xml', 'path_pdf', 'observacoes'];

    /*
     * Mutators
     */
    protected function getDataAttribute($value)
    {
        return Carbon::createFromFormat('Y-m-d', $value);
    }

    /*
     * Belongs to Empresa
     */
    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    /*
     * Belongs to Fornecedor
     */
    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }

    /*
     * Belongs to Cliente
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    /*
     * Belongs to Endereço de entrega
     */
    public function enderecoEntrega()
    {
        return $this->belongsTo(Endereco::class);
    }

    /*
     * HasMany to NotaFiscalItem
     */
    public function itens()
    {
        return $this->hasMany(NotaFiscalItem::class);
    }

    /*
     * HasMany to Fatura
     */
    public function faturas()
    {
        return $this->hasMany(Fatura::class);
    }
}

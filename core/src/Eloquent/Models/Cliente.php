<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Cliente extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'pessoa_id', 'empresa_id', 'inscricao_estadual', 'inscricao_municipal'];

    /*
     * Belong To Empresa
     */
    public function empresa(){
        return $this->belongsTo(Empresa::class);
    }

    /*
     * Belong To Pessoa
     */
    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
}

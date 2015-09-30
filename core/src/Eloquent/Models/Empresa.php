<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use Laraerp\Ordination\OrdinationTrait;

class Empresa extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'pessoa_id', 'inscricao_estadual', 'inscricao_municipal'];

    /*
     * Belong To Pessoa
     */
    public function pessoa(){
        return $this->belongsTo(Pessoa::class);
    }
}

<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use JansenFelipe\Utils\Utils;
use Laraerp\Ordination\OrdinationTrait;

class Contato extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'pessoa_id', 'responsavel', 'email', 'telefone', 'celular'];

    /**
     * Mutators
     */
    protected function setTelefoneAttribute($value){
        $this->attributes['telefone'] = Utils::unmask($value);
    }

    protected function setCelularAttribute($value){
        $this->attributes['celular'] = Utils::unmask($value);
    }
}

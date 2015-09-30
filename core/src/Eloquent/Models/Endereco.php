<?php

namespace Laraerp\Eloquent\Models;

use Illuminate\Database\Eloquent\Model;
use JansenFelipe\Utils\Utils;
use Laraerp\Ordination\OrdinationTrait;

class Endereco extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'pessoa_id', 'cep', 'logradouro', 'numero', 'complemento', 'bairro', 'cidade_id'];

    /*
     * BelongsTo Cidade
     */
    public function cidade(){
        return $this->belongsTo(Cidade::class);
    }

    /**
     * Mutators
     */
    protected function setCepAttribute($value){
        $this->attributes['cep'] = Utils::unmask($value);
    }
}

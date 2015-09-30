<?php

namespace Laraerp\Eloquent\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use JansenFelipe\Utils\Utils;
use Laraerp\Ordination\OrdinationTrait;

class Pessoa extends Model
{
    use OrdinationTrait;

    protected $fillable = ['id', 'nome', 'razao_apelido', 'documento', 'nascimento_fundacao'];

    /*
     * HasMany Endereços
     */
    public function enderecos(){
        return $this->hasMany(Endereco::class);
    }

   /*
    * HasMany Contatos
    */
    public function contatos(){
        return $this->hasMany(Contato::class);
    }

    /**
     * Mutators
     */
    protected function setNascimentoFundacaoAttribute($value){

        //Verificando se data foi informada e se está no formato brasileiro
        if(!is_null($value)){
            $d = DateTime::createFromFormat('d/m/Y', $value);

            if($d && $d->format('d/m/Y') == $value)
                $this->attributes['nascimento_fundacao'] = $d;
        }
    }

    protected function setDocumentoAttribute($value){
        $this->attributes['documento'] = Utils::unmask($value);
    }
}

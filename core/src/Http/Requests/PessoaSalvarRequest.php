<?php

namespace Laraerp\Http\Requests;

class PessoaSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'nome' => 'required',
            'documento' => 'required',
        ];

        /*
         * Se preencheu algum campo do endereço..
         */
        if($this->enderecoPreenchido()){
            $rules = array_merge($rules, [
                'endereco.cep' => 'required',
                'endereco.logradouro' => 'required',
                'endereco.numero' => 'required',
                'endereco.bairro' => 'required',
                'endereco.cidade_id' => 'required|exists:cidades,id',
            ]);
        }

        /*
         * Se preencheu algum campo de contato..
         */
        if($this->contatoPreenchido()){
            $rules = array_merge($rules, [
                'contato.responsavel' => 'required',
                'contato.email' => 'email'
            ]);
        }
        return $rules;
    }

    /**
     * Verifica se algum campo de endereço foi preenchido
     *
     * @return boolean
     */
    public function enderecoPreenchido(){
        $endereco = $this->get('endereco');

        unset($endereco['uf']);

        return $this->checkFilled($endereco);
    }

    /**
     * Verifica se algum campo de contato foi preenchido
     *
     * @return boolean
     */
    public function contatoPreenchido(){
        return $this->checkFilled($this->get('contato'));
    }

    /**
     * Check array is filled
     *
     * @return bool
     */
    private function checkFilled($array){
        if(is_array($array))
            return in_array(true, array_map(function($x){return strlen($x)>0;}, $array));
        else
            return false;
    }
}

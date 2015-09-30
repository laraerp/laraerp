<?php

namespace Laraerp\Http\Requests;

class SetupSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nome' => 'required',
            'documento' => 'required',
            'endereco.cep' => 'required',
            'endereco.logradouro' => 'required',
            'endereco.numero' => 'required',
            'endereco.bairro' => 'required',
            'contato.responsavel' => 'required',
            'contato.email' => 'email'
        ];
    }
}

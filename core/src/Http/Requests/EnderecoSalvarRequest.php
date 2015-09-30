<?php

namespace Laraerp\Http\Requests;

class EnderecoSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'endereco.pessoa_id' => 'required',
            'endereco.cep' => 'required',
            'endereco.logradouro' => 'required',
            'endereco.numero' => 'required',
            'endereco.bairro' => 'required',
            'endereco.cidade_id' => 'required|exists:cidades,id'
        ];
    }

}

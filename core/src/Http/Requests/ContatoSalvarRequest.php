<?php

namespace Laraerp\Http\Requests;

class ContatoSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'contato.pessoa_id' => 'required',
            'contato.responsavel' => 'required',
            'contato.email' => 'email'
        ];
    }

}

<?php

namespace Laraerp\Http\Requests;

class ProdutoSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'codigo' => 'required',
            'descricao' => 'required',
            'unidade_medida_id' => 'required'
        ];
    }

}

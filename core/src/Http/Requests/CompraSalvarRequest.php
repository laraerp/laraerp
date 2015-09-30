<?php

namespace Laraerp\Http\Requests;

class CompraSalvarRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        if($this->get('fornecedor_id') > 0)

            return [
                'fornecedor_id' =>  'required'
            ];

        else

            return [
                'nome' => 'required',
                'documento' => 'required',
            ];
    }
}

<?php

namespace Laraerp\Http\Requests;

class CompraRelacionarProdutoItemRequest extends Request
{

    /**
     * Get the validation rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nota_fiscal_item_id' => 'required',
            'produto_nome' => 'required_without:produto_id',
            'produto_id' => 'required_without:produto_nome',
        ];
    }
}

<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\View;

class NotaFiscalController extends BaseController {

    /**
     * Configuracoes
     *
     * @return Response
     */
    public function getIndex() {

        // ORDENAÇÃO
        $sort = in_array(Input::get('sort'), array('nome', 'id')) ? Input::get('sort') : 'nome';
        $order = Input::get('order') != 'desc' ? 'asc' : 'desc';
        $limit = !(Input::get('limit') > 0) ? 15 : Input::get('limit');

        $clientes = Cliente::with('Pessoa')
                ->join('tb_pessoa', 'tb_cliente.fk_pessoa', '=', 'tb_pessoa.id')
                ->orderBy($sort, $order);

        // FILTRO
        $nome_like = null;

        if (Input::has('nome_like')) {
            $like = '%' . Input::get('nome_like') . '%';
            $clientes = $clientes->where('nome', 'LIKE', $like);
            $nome_like = '&nome_like=' . $like;
        }

        // PAGINAÇÃO
        $clientes = $clientes->paginate($limit);

        $pagination = $clientes->appends(array(
                    'nome_like' => Input::get('nome_like'),
                    'sort' => $sort,
                    'order' => $order,
                    'limit' => $limit
                ))->links();

        return View::make('notaFiscal.index')->with(array(
                    'clientes' => $clientes,
                    'pagination' => $pagination,
                    'limit' => $limit,
                    'querystr' => '&limit=' . $limit . '&order=' . ($order == 'desc' ? 'asc' : 'desc') . $nome_like
        ));
    }

}

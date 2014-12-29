<?php

use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Laraerp\Endereco\Models\Endereco;
use Laraerp\Pessoa\Models\Pessoa;

class ClienteController extends BaseController {

    /**
     * Lista de clientes
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

        return View::make('cliente.index')->with(array(
                    'clientes' => $clientes,
                    'pagination' => $pagination,
                    'limit' => $limit,
                    'querystr' => '&limit=' . $limit . '&order=' . ($order == 'desc' ? 'asc' : 'desc') . $nome_like
        ));
    }

    /**
     * Exibe formulário para criação de cliente
     *
     * @return Response
     */
    public function getCreate() {
        return View::make('cliente.create');
    }

    /**
     * Salva um cliente
     *
     * @return Response
     */
    public function postCreate() {
        DB::beginTransaction();

        try {

            //Verificação de Pessoa
            if (is_null(Input::get('fk_pessoa'))) {
                $pessoa = new Pessoa(Input::all());
                if (!$pessoa->save())
                    throw new Exception($pessoa->errors()->first());
            } else
                $pessoa = Pessoa::find(Input::get('fk_pessoa'));

            if (!is_null($pessoa->cliente))
                return Redirect::action('ClienteController@getView', $pessoa->cliente->id);

            //Cadastro do cliente
            $cliente = new Cliente(Input::all());
            $cliente->fk_pessoa = $pessoa->id;
            $cliente->nascimento_fundacao = Input::get('nascimento_fundacao');
            $cliente->inscricao_estadual = Input::get('inscricao_estadual');
            $cliente->inscricao_municipal = Input::get('inscricao_municipal');
            $cliente->retem_issqn = Input::get('retem_issqn');

            if (!$cliente->save())
                throw new Exception($cliente->errors()->first());

            //Cadastrar se preencheu algum campo de endereço
            Endereco::createEnderecoWithPessoa(Input::all(), $pessoa);

            DB::commit();
            return Redirect::action('ClienteController@getView', $cliente->id)->with('alert', 'Cliente cadastrado com sucesso!');
        } catch (Exception $e) {
            DB::rollback();
            return Redirect::back()->withInput()->with('erro', $e->getMessage());
        }
    }

    /**
     * Visualiza o cadastro do cliente
     *
     * @param  int $id
     * @param  string $output
     * @return Response
     */
    public function getView($id, $output = 'html') {
        try {
            $cliente = Cliente::find($id);
            $pessoa = $cliente->pessoa;

            return View::make('cliente.view')->with(compact('cliente', 'pessoa'));
        } catch (Exception $e) {
            return Redirect::back()->with('erro', $e->getMessage());
        }
    }

    /**
     * Atualização Cliente
     *
     * @return Response
     */
    public function postUpdate() {
        try {
            $cliente = Cliente::findOrFail(Input::get('pk'));
            $cliente->setAttribute(Input::get('name'), Input::get('value'));

            if (!$cliente->save())
                throw new Exception($cliente->errors()->first());

            return Response::json(array('codigo' => 0, 'mensagem' => 'Atualizado com sucesso!'));
        } catch (Exception $e) {
            return Response::json(array('codigo' => $e->getCode(), 'mensagem' => $e->getMessage()), 400);
        }
    }

    /**
     * Exclusão de Cliente
     *
     * @param  int  $id
     * @return Response
     */
    public function getDelete($id) {
        try {
            Cliente::destroy($id);
            return Redirect::back()->with('alert', 'Cliente excluido com sucesso!');
        } catch (Exception $e) {
            return Redirect::back()->with('erro', $e->getMessage());
        }
    }

}

<?php

namespace Laraerp\Http\Controllers;

use Illuminate\Http\Request;
use Laraerp\Contracts\Repositories\ClienteRepository;
use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Http\Requests\PessoaSalvarRequest;

class ClienteController extends Controller
{
    /**
     * Repositorio de clientes
     *
     * @var ClienteRepository
     */
    private $clienteRepository;

    /**
     * ClienteController constructor.
     *
     * @param $clienteRepository
     */
    public function __construct(ClienteRepository $clienteRepository)
    {
        $this->clienteRepository = $clienteRepository;
    }

    /**
     * Exibe uma lista de clientes cadastrados
     *
     * @return View
     */
    public function index(Request $request) {

        //Filtro
        $like = $request->get('like');
        $limit = $request->get('limit', 15);

        //Order
        $order = $request->get('order', 'ASC');
        $by = $request->get('by', 'pessoa.nome');

        //Buscando todos os clientes
        $clientes = $this->clienteRepository
            ->order($by, $order)
            ->whereLike($like)
            ->paginate($limit);

        return view('cliente.index', compact('clientes'));
    }

    /**
     * Exibe formulário para criação de cliente
     *
     * @return Response
     */
    public function form() {
        return view('cliente.form');
    }

    /**
     * Salva um cliente
     */
    public function salvar(PessoaSalvarRequest $request, EnderecoRepository $enderecoRepository, ContatoRepository $contatoRepository) {

        /*
         * Parametros
         */
        $params = $request->all();
        $params['empresa_id'] = app('empresa')->id;

        /*
         * Salvando dados do cliente
         */
        $cliente = $this->clienteRepository->save($params);

        /*
         * Salvando endereço
         */
        if($request->enderecoPreenchido()) {
            $endereco = $request->get('endereco');
            $endereco['pessoa_id'] = $cliente->pessoa_id;

            $enderecoRepository->save($endereco);
        }

        /*
         * Salvando contato
         */
        if($request->contatoPreenchido()) {
            $contato = $request->get('contato');
            $contato['pessoa_id'] = $cliente->pessoa_id;

            $contatoRepository->save($contato);
        }

        /*
         * Redirecionando
         */
        return redirect(route('clientes.ver', $cliente->id))->with('alert', 'O cliente foi salvo com sucesso!');
    }

    /**
     * Visualiza um cliente
     *
     * @return Response
     */
    public function ver($id) {

        /*
         * Buscando cliente pelo ID
         */
        $cliente = $this->clienteRepository->getById($id);

        if(is_null($cliente))
            return redirect()->back()->with('erro', 'Cliente não encontrado');

        return view('cliente.ver')->with(compact('cliente'));
    }

    /**
     * Exclui um cliente
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->clienteRepository->remove($id))
            return redirect()->back()->with('erro', 'O cliente não pode ser removido. Verifique se existe algum dado relacionado a ele.');

        return redirect()->back()->with('alert', 'O cliente foi removido com sucesso');
    }
}

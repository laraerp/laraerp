<?php

namespace Laraerp\Http\Controllers;

use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Http\Requests\EnderecoSalvarRequest;

class EnderecoController extends Controller
{
    /**
     * Repositorio de endereço
     *
     * @var EnderecoRepository
     */
    private $enderecoRepository;

    /**
     * EnderecoController constructor.
     *
     * @param $enderecoRepository
     */
    public function __construct(EnderecoRepository $enderecoRepository)
    {
        $this->enderecoRepository = $enderecoRepository;
    }

    /**
     * Salva um endereco
     */
    public function salvar(EnderecoSalvarRequest $request) {

        $this->enderecoRepository->save($request->get('endereco'));

        return redirect()->back()->with('alert', 'O endereço foi salvo com sucesso!');
    }

    /**
     * Exclui um endereco
     *
     * @return Response
     */
    public function excluir($id) {

        if(!$this->enderecoRepository->remove($id))
            return redirect()->back()->with('erro', 'O endereço não pode ser removido. Verifique se existe algum dado relacionado a ele.');

        return redirect()->back()->with('alert', 'O endereço foi removido com sucesso');
    }
}

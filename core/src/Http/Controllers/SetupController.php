<?php

namespace Laraerp\Http\Controllers;

use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Contracts\Repositories\EmpresaRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Http\Requests;
use Laraerp\Http\Requests\SetupSalvarRequest;


class SetupController extends Controller
{
    /**
     * Exibe formulario para cadastrar uma empresa inicial
     *
     * @return  View
     */
    public function index() {
        return view('setup.index');
    }

    /**
     * Salva as dados da empresa
     *
     * @return Response
     */
    public function salvar(SetupSalvarRequest $setupSalvarRequest, EmpresaRepository $empresaRepository, EnderecoRepository $enderecoRepository, ContatoRepository $contatoRepository) {

        /*
         * Salvando dados da empresa
         */
        $empresa = $empresaRepository->save($setupSalvarRequest->all());

        /*
         * Salvando endereço
         */
        $endereco = $setupSalvarRequest->get('endereco');
        $endereco['pessoa_id'] = $empresa->pessoa_id;

        $enderecoRepository->save($endereco);

        /*
         * Salvando contato
         */
        $contato = $setupSalvarRequest->get('contato');
        $contato['pessoa_id'] = $empresa->pessoa_id;

        $contatoRepository->save($contato);

        return redirect()->route('dashboard.index');
    }
}

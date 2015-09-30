<?php

namespace Laraerp\Http\Middleware;

use Closure;
use Laraerp\Contracts\Repositories\EmpresaRepository;

class SetupMiddleware
{
    /**
     * Repositório de empresa
     *
     * @var EmpresaRepository
     */
    private $empresaRepository;

    /**
     * SetupMiddleware constructor.
     * @param $empresaRepository
     */
    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //Buscando empresa_id gravado na sessão
        $empresa_id = $request->session()->get('empresa_id');

        //Se não existir, verifica se possui alguma empresa cadastrada
        if (is_null($empresa_id))
            $empresa = $this->empresaRepository->getFirst();
        else
            $empresa = $this->empresaRepository->getById($empresa_id);

        //Se não encontrou empresa, redireciona para setup
        if(is_null($empresa))
            return redirect(route('setup.index'));

        //Gravando a instância da empresa no escopo da aplicação.
        app()->instance('empresa', $empresa);

        return $next($request);
    }
}

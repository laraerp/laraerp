<?php

namespace Laraerp\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\ServiceProvider;
use JansenFelipe\Utils\Mask;
use JansenFelipe\Utils\Utils;
use Laraerp\Contracts\Repositories\CidadeRepository;
use Laraerp\Contracts\Repositories\ClienteRepository;
use Laraerp\Contracts\Repositories\ContatoRepository;
use Laraerp\Contracts\Repositories\EmpresaRepository;
use Laraerp\Contracts\Repositories\EnderecoRepository;
use Laraerp\Contracts\Repositories\FaturaRepository;
use Laraerp\Contracts\Repositories\FornecedorRepository;
use Laraerp\Contracts\Repositories\NotaFiscalItemRepository;
use Laraerp\Contracts\Repositories\NotaFiscalRepository;
use Laraerp\Contracts\Repositories\PessoaRepository;
use Laraerp\Contracts\Repositories\ProdutoRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaFatorRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaFatorSinonimoRepository;
use Laraerp\Contracts\Repositories\UnidadeMedidaRepository;
use Laraerp\Exceptions\Handler;
use Laraerp\Exceptions\WhoopsHandler;
use Laraerp\Http\Middleware\SetupMiddleware;
use Laraerp\Ordination\Facade;
use Laraerp\Ordination\OrdinationServiceProvider;

class LaraerpServiceProvider extends ServiceProvider
{

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

        /*
         * Publish migration's
         */
        $this->publishes([__DIR__.'/../../database/migrations/' => base_path('database/migrations')], 'migrations');

        /*
         * Publish seed's
         */
        $this->publishes([__DIR__.'/../../database/seeds/' => base_path('database/seeds')], 'migrations');

        /*
         * Publish config
         */
        $this->publishes([__DIR__.'/../../config/laraerp.php' => config_path('laraerp.php')], 'laraerp');

        /*
         * Merge config
         */
        $this->mergeConfigFrom(__DIR__.'/../../config/laraerp.php', 'laraerp');

        /*
         * Laraerp Middlewares...
         */
        $this->app->router->middleware('setup', SetupMiddleware::class);

        /*
         * Bind Repositories
         */
        $this->app->bind(CidadeRepository::class, config('laraerp.repositories.CidadeRepository'));
        $this->app->bind(ClienteRepository::class, config('laraerp.repositories.ClienteRepository'));
        $this->app->bind(ContatoRepository::class, config('laraerp.repositories.ContatoRepository'));
        $this->app->bind(EmpresaRepository::class, config('laraerp.repositories.EmpresaRepository'));
        $this->app->bind(EnderecoRepository::class, config('laraerp.repositories.EnderecoRepository'));
        $this->app->bind(FornecedorRepository::class, config('laraerp.repositories.FornecedorRepository'));
        $this->app->bind(PessoaRepository::class, config('laraerp.repositories.PessoaRepository'));
        $this->app->bind(ProdutoRepository::class, config('laraerp.repositories.ProdutoRepository'));
        $this->app->bind(UnidadeMedidaRepository::class, config('laraerp.repositories.UnidadeMedidaRepository'));
        $this->app->bind(UnidadeMedidaFatorRepository::class, config('laraerp.repositories.UnidadeMedidaFatorRepository'));
        $this->app->bind(UnidadeMedidaFatorSinonimoRepository::class, config('laraerp.repositories.UnidadeMedidaFatorSinonimoRepository'));
        $this->app->bind(NotaFiscalRepository::class, config('laraerp.repositories.NotaFiscalRepository'));
        $this->app->bind(NotaFiscalItemRepository::class, config('laraerp.repositories.NotaFiscalItemRepository'));
        $this->app->bind(FaturaRepository::class, config('laraerp.repositories.FaturaRepository'));

        /*
         * Service Providers...
         */
        $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
        $this->app->register(OrdinationServiceProvider::class);

        /*
         * Singletons
         */
        $this->app->singleton(ExceptionHandler::class, WhoopsHandler::class, Handler::class);

        /*
         * Removendo empresa_id da sessão caso efetue logout
         */
        Event::listen('auth.logout', function($user){
            Request::session()->forget('empresa_id');
        });

        /*
         * Register Aliases
         */
        $loader = AliasLoader::getInstance();
        $loader->alias('Utils', Utils::class);
        $loader->alias('Mask', Mask::class);
        $loader->alias('Order', Facade::class);

        /*
         * Laraerp Routes...
         */
        include __DIR__ . '/../Http/routes.php';
    }

}

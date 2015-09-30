<?php

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
use Laraerp\Ordination\Facade;
use Laraerp\Providers\LaraerpServiceProvider;
use Orchestra\Testbench\TestCase;

class LaraerpServiceProviderTest extends TestCase
{

    /**
     * Registrando ServiceProvider
     */
    protected function getPackageProviders($app)
    {
        return [LaraerpServiceProvider::class];
    }

    /**
     * Verificando se construiu os repositórios
     */
    public function testConstrucaoRepositorios()
    {
        $this->assertInstanceOf(CidadeRepository::class, $this->app[config('laraerp.repositories.CidadeRepository')]);
        $this->assertInstanceOf(ClienteRepository::class, $this->app[config('laraerp.repositories.ClienteRepository')]);
        $this->assertInstanceOf(ContatoRepository::class, $this->app[config('laraerp.repositories.ContatoRepository')]);
        $this->assertInstanceOf(EmpresaRepository::class, $this->app[config('laraerp.repositories.EmpresaRepository')]);
        $this->assertInstanceOf(EnderecoRepository::class, $this->app[config('laraerp.repositories.EnderecoRepository')]);
        $this->assertInstanceOf(FornecedorRepository::class, $this->app[config('laraerp.repositories.FornecedorRepository')]);
        $this->assertInstanceOf(PessoaRepository::class, $this->app[config('laraerp.repositories.PessoaRepository')]);
        $this->assertInstanceOf(ProdutoRepository::class, $this->app[config('laraerp.repositories.ProdutoRepository')]);
        $this->assertInstanceOf(UnidadeMedidaRepository::class, $this->app[config('laraerp.repositories.UnidadeMedidaRepository')]);
        $this->assertInstanceOf(UnidadeMedidaFatorRepository::class, $this->app[config('laraerp.repositories.UnidadeMedidaFatorRepository')]);
        $this->assertInstanceOf(UnidadeMedidaFatorSinonimoRepository::class, $this->app[config('laraerp.repositories.UnidadeMedidaFatorSinonimoRepository')]);
        $this->assertInstanceOf(NotaFiscalRepository::class, $this->app[config('laraerp.repositories.NotaFiscalRepository')]);
        $this->assertInstanceOf(NotaFiscalItemRepository::class, $this->app[config('laraerp.repositories.NotaFiscalItemRepository')]);
        $this->assertInstanceOf(FaturaRepository::class, $this->app[config('laraerp.repositories.FaturaRepository')]);
    }

    /**
     * Verificando contrução dos alias
     */
    public function testConstrucaoAlias()
    {
        $this->assertInstanceOf(Utils::class, $this->app['Utils']);
        $this->assertInstanceOf(Facade::class, $this->app['Order']);
    }

}
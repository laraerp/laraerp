<?php

/**
 * Laraerp - Configuração
 * Author: Jansen Felipe
 */

return [

    'repositories' => [

        'CidadeRepository' => \Laraerp\Eloquent\Repositories\CidadeEloquentRepository::class,
        'ClienteRepository' => \Laraerp\Eloquent\Repositories\ClienteEloquentRepository::class,
        'ContatoRepository' => \Laraerp\Eloquent\Repositories\ContatoEloquentRepository::class,
        'EmpresaRepository' => \Laraerp\Eloquent\Repositories\EmpresaEloquentRepository::class,
        'EnderecoRepository' => \Laraerp\Eloquent\Repositories\EnderecoEloquentRepository::class,
        'FornecedorRepository' => \Laraerp\Eloquent\Repositories\FornecedorEloquentRepository::class,
        'PessoaRepository' => \Laraerp\Eloquent\Repositories\PessoaEloquentRepository::class,
        'ProdutoRepository' => \Laraerp\Eloquent\Repositories\ProdutoEloquentRepository::class,
        'UnidadeMedidaRepository' => \Laraerp\Eloquent\Repositories\UnidadeMedidaEloquentRepository::class,
        'UnidadeMedidaFatorRepository' => \Laraerp\Eloquent\Repositories\UnidadeMedidaFatorEloquentRepository::class,
        'UnidadeMedidaFatorSinonimoRepository' => \Laraerp\Eloquent\Repositories\UnidadeMedidaFatorSinonimoEloquentRepository::class,
        'NotaFiscalRepository' => \Laraerp\Eloquent\Repositories\NotaFiscalEloquentRepository::class,
        'NotaFiscalItemRepository' => \Laraerp\Eloquent\Repositories\NotaFiscalItemEloquentRepository::class,
        'FaturaRepository' => \Laraerp\Eloquent\Repositories\FaturaEloquentRepository::class,
    ]
];
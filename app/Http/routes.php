<?php

Route::group(['middleware' => ['auth', 'setup']], function() {

    /*
     * Endereço
     */
    Route::post('endereco/salvar', ['as' => 'endereco.salvar', 'uses' => '\Laraerp\Http\Controllers\EnderecoController@salvar']);
    Route::get('endereco/remover/{id}', ['as' => 'endereco.remover', 'uses' => '\Laraerp\Http\Controllers\EnderecoController@remover']);

    /*
     * Endereço
     */
    Route::post('contato/salvar', ['as' => 'contato.salvar', 'uses' => '\Laraerp\Http\Controllers\ContatoController@salvar']);
    Route::get('contato/remover/{id}', ['as' => 'contato.remover', 'uses' => '\Laraerp\Http\Controllers\ContatoController@remover']);

    /*
     * Cliente
     */
    Route::get('cliente', ['as' => 'cliente.index', 'uses' => '\Laraerp\Http\Controllers\ClienteController@index']);
    Route::get('cliente/form', ['as' => 'cliente.form', 'uses' => '\Laraerp\Http\Controllers\ClienteController@form']);
    Route::get('cliente/ver/{id}', ['as' => 'cliente.ver', 'uses' => '\Laraerp\Http\Controllers\ClienteController@ver']);
    Route::post('cliente/salvar', ['as' => 'cliente.salvar', 'uses' => '\Laraerp\Http\Controllers\ClienteController@salvar']);
    Route::get('cliente/deletar/{id}', ['as' => 'cliente.deletar', 'uses' => '\Laraerp\Http\Controllers\ClienteController@deletar']);

    /*
     * Produto
     */
    Route::get('produto', ['as' => 'produto.index', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@index']);
    Route::get('produto/form', ['as' => 'produto.form', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@form']);
    Route::post('produto/salvar', ['as' => 'produto.salvar', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@salvar']);
    Route::get('produto/ver/{id}', ['as' => 'produto.ver', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@ver']);
    Route::get('produto/deletar/{id}', ['as' => 'produto.deletar', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@deletar']);

    /*
     * Venda
     */
    Route::get('venda', ['as' => 'venda.index', 'uses' => '\Laraerp\Http\Controllers\VendaController@index']);
    Route::get('venda/form', ['as' => 'venda.form', 'uses' => '\Laraerp\Http\Controllers\VendaController@form']);
    Route::get('venda/cadastrar/{cliente}', ['as' => 'venda.cadastrar', 'uses' => '\Laraerp\Http\Controllers\VendaController@cadastrar']);
    Route::get('venda/ver/{idVenda}', ['as' => 'venda.ver', 'uses' => '\Laraerp\Http\Controllers\VendaController@ver']);
    Route::get('venda/deletar/{idVenda}', ['as' => 'venda.deletar', 'uses' => '\Laraerp\Http\Controllers\VendaController@deletar']);
    Route::get('venda/formAdicionarItem/{idVenda}', ['as' => 'venda.adicionarItem', 'uses' => '\Laraerp\Http\Controllers\VendaController@formAdicionarItem']);

    /*
     * Venda Item
     */
    Route::post('vendaItem/adicionar', ['as' => 'vendaItem.adicionar', 'uses' => '\Laraerp\Http\Controllers\VendaItemController@adicionar']);
    Route::get('vendaItem/deletar/{idVendaItem}', ['as' => 'vendaItem.deletar', 'uses' => '\Laraerp\Http\Controllers\VendaItemController@deletar']);

    /*
     * Tags
     */
    Route::post('tag/adicionar', ['as' => 'tag.adicionar', 'uses' => '\Laraerp\Http\Controllers\TagController@adicionar']);
    Route::post('tag/remover', ['as' => 'tag.remover', 'uses' => '\Laraerp\Http\Controllers\TagController@remover']);

    /*
     * Nota Fiscal
     */
    Route::post('notaFiscal/upload', ['as' => 'notaFiscal.upload', 'uses' => '\Laraerp\Http\Controllers\NotaFiscalController@upload']);

    /*
     * Dashboard
     */
    Route::get('/', '\Laraerp\Http\Controllers\DashboardController@index');

});

Route::group(['middleware' => ['auth']], function() {
    /*
     * Pessoa
     */
    Route::post('pessoa/receitaParams', ['as' => 'pessoa.receitaParams', 'uses' => '\Laraerp\Http\Controllers\PessoaController@receitaParams']);
    Route::post('pessoa/receitaConsulta', ['as' => 'pessoa.receitaConsulta', 'uses' => '\Laraerp\Http\Controllers\PessoaController@receitaConsulta']);

    /*
     * Setup
     */
    Route::get('/setup', ['as' => 'setup.index', 'uses' => '\Laraerp\Http\Controllers\SetupController@index']);
    Route::post('/setup/salvar', ['as' => 'setup.salvar', 'uses' => '\Laraerp\Http\Controllers\SetupController@salvar']);
});



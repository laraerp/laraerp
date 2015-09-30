<?php

/*
 * Auth
 */
Route::group(['namespace' => '\App\Http\Controllers\Auth'], function() {
    Route::get('auth/login', ['as' => 'auth.form', 'uses' => 'AuthController@getLogin']);
    Route::post('auth/login', ['as' => 'auth.login', 'uses' => 'AuthController@postLogin']);
    Route::get('auth/logout', ['as' => 'auth.logout', 'uses' => 'AuthController@getLogout']);
});

/*
 * Autenticado e não configurado
 */
Route::group(['middleware' => ['auth'], 'namespace' => '\Laraerp\Http\Controllers'], function() {

    //Setup
    Route::get('setup', ['as' => 'setup.index', 'uses' => 'SetupController@index']);
    Route::post('setup/salvar', ['as' => 'setup.salvar', 'uses' => 'SetupController@salvar']);

    //Util
    Route::get('util/ufs', ['as' => 'util.ufs', 'uses' => 'UtilController@ufs']);
    Route::get('util/cidades/{uf}', ['as' => 'util.ufs', 'uses' => 'UtilController@cidades']);
    Route::get('util/cep/{cep}', ['as' => 'util.cep', 'uses' => 'UtilController@cep']);
    Route::post('util/parametrosReceita', ['as' => 'util.parametrosReceita', 'uses' => 'UtilController@parametrosReceita']);
    Route::post('util/consultaReceita', ['as' => 'util.consultaReceita', 'uses' => 'UtilController@consultaReceita']);
});

/*
 * Autenticado e configurado
 */
Route::group(['middleware' => ['auth', 'setup'], 'namespace' => '\Laraerp\Http\Controllers'], function() {

    //Compra
    Route::get('compras', ['as' => 'compras.index', 'uses' => 'CompraController@index']);
    Route::get('compras/itens', ['as' => 'compras.itens', 'uses' => 'CompraController@itens']);
    Route::post('compras/salvar', ['as' => 'compras.salvar', 'uses' => 'CompraController@salvar']);
    Route::get('compras/ver/{id}', ['as' => 'compras.ver', 'uses' => 'CompraController@ver']);
    Route::get('compras/excluir/{id}', ['as' => 'compras.excluir', 'uses' => 'CompraController@excluir']);
    Route::post('compras/relacionarProdutoItem', ['as' => 'compras.relacionarProdutoItem', 'uses' => 'CompraController@relacionarProdutoItem']);

    //Venda
    Route::get('vendas', ['as' => 'vendas.index', 'uses' => 'VendaController@index']);
    Route::get('vendas/itens', ['as' => 'vendas.itens', 'uses' => 'VendaController@itens']);
    Route::get('vendas/ver/{id}', ['as' => 'vendas.ver', 'uses' => 'VendaController@ver']);
    Route::get('vendas/excluir/{id}', ['as' => 'vendas.excluir', 'uses' => 'VendaController@excluir']);

    //Endereço
    Route::post('contatos/salvar', ['as' => 'contatos.salvar', 'uses' => 'ContatoController@salvar']);
    Route::get('contatos/excluir/{id}', ['as' => 'contatos.excluir', 'uses' => 'ContatoController@excluir']);

    //Endereço
    Route::post('enderecos/salvar', ['as' => 'enderecos.salvar', 'uses' => 'EnderecoController@salvar']);
    Route::get('enderecos/excluir/{id}', ['as' => 'enderecos.excluir', 'uses' => 'EnderecoController@excluir']);

    //Cliente
    Route::get('clientes', ['as' => 'clientes.index', 'uses' => 'ClienteController@index']);
    Route::get('clientes/form', ['as' => 'clientes.form', 'uses' => 'ClienteController@form']);
    Route::post('clientes/salvar', ['as' => 'clientes.salvar', 'uses' => 'ClienteController@salvar']);
    Route::get('clientes/ver/{id}', ['as' => 'clientes.ver', 'uses' => 'ClienteController@ver']);
    Route::get('clientes/excluir/{id}', ['as' => 'clientes.excluir', 'uses' => 'ClienteController@excluir']);

    //Fornecedor
    Route::get('fornecedores', ['as' => 'fornecedores.index', 'uses' => 'FornecedorController@index']);
    Route::get('fornecedores/form', ['as' => 'fornecedores.form', 'uses' => 'FornecedorController@form']);
    Route::post('fornecedores/salvar', ['as' => 'fornecedores.salvar', 'uses' => 'FornecedorController@salvar']);
    Route::get('fornecedores/ver/{id}', ['as' => 'fornecedores.ver', 'uses' => 'FornecedorController@ver']);
    Route::get('fornecedores/excluir/{id}', ['as' => 'fornecedores.excluir', 'uses' => 'FornecedorController@excluir']);

    //Produto
    Route::get('produtos', ['as' => 'produtos.index', 'uses' => 'ProdutoController@index']);
    Route::get('produtos/form', ['as' => 'produtos.form', 'uses' => 'ProdutoController@form']);
    Route::post('produtos/salvar', ['as' => 'produtos.salvar', 'uses' => 'ProdutoController@salvar']);
    Route::get('produtos/ver/{id}', ['as' => 'produtos.ver', 'uses' => 'ProdutoController@ver']);
    Route::get('produtos/excluir/{id}', ['as' => 'produtos.excluir', 'uses' => 'ProdutoController@excluir']);

    //Notas fiscais
    Route::get('notafiscal/importar', ['as' => 'notafiscal.importar', 'uses' => 'NotaFiscalController@importar']);
    Route::post('notafiscal/upload', ['as' => 'notafiscal.upload', 'uses' => 'NotaFiscalController@upload']);
    Route::get('notaFiscal/danfe/{id}', ['as' => 'notafiscal.danfe', 'uses' => 'NotaFiscalController@danfe']);
    Route::get('notaFiscal/xml/{id}', ['as' => 'notafiscal.xml', 'uses' => 'NotaFiscalController@xml']);

    //Financeiro
    Route::get('financeiro/extrato', ['as' => 'financeiro.extrato', 'uses' => 'FinanceiroController@extrato']);
    Route::get('financeiro/contasPagar', ['as' => 'financeiro.contasPagar', 'uses' => 'FinanceiroController@contasPagar']);
    Route::get('financeiro/contasReceber', ['as' => 'financeiro.contasReceber', 'uses' => 'FinanceiroController@contasReceber']);

    //Dashboard
    Route::get('dashboard', ['as' => 'dashboard.index', 'uses' => 'DashboardController@index']);

    //Configuracoes
    Route::get('configuracoes', ['as' => 'configuracoes.index', 'uses' => 'ConfiguracoesController@index']);

    //Util
    Route::get('util/fornecedores', ['as' => 'util.fornecedores', 'uses' => 'UtilController@fornecedores']);
    Route::get('util/produtos', ['as' => 'util.produtos', 'uses' => 'UtilController@produtos']);

    //Home
    Route::get('/', ['as' => 'home', function () {
        return redirect()->route('dashboard.index');
    }]);

});
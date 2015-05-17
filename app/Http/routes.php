<?php

/*
 * Models
 */
Route::model('cliente', 'Laraerp\Cliente');
Route::model('venda', 'Laraerp\Venda');

Route::group(['middleware' => ['auth']], function() {

    /*
     * Pessoa
     */
    Route::post('pessoa/receitaParams', ['as' => 'pessoa.receitaParams', 'uses' => '\Laraerp\Http\Controllers\PessoaController@receitaParams']);
    Route::post('pessoa/receitaConsulta', ['as' => 'pessoa.receitaConsulta', 'uses' => '\Laraerp\Http\Controllers\PessoaController@receitaConsulta']);

    /*
     * Cliente
     */
    Route::get('cliente', ['as' => 'cliente.index', 'uses' => '\Laraerp\Http\Controllers\ClienteController@index']);
    Route::get('cliente/form', ['as' => 'cliente.form', 'uses' => '\Laraerp\Http\Controllers\ClienteController@form']);
    Route::post('cliente/cadastrar', ['as' => 'cliente.cadastrar', 'uses' => '\Laraerp\Http\Controllers\ClienteController@cadastrar']);
    Route::get('cliente/ver/{cliente}', ['as' => 'cliente.ver', 'uses' => '\Laraerp\Http\Controllers\ClienteController@ver']);
    Route::post('cliente/editar/{cliente}', ['as' => 'cliente.editar', 'uses' => '\Laraerp\Http\Controllers\ClienteController@editar']);
    Route::get('cliente/deletar/{cliente}', ['as' => 'cliente.deletar', 'uses' => '\Laraerp\Http\Controllers\ClienteController@deletar']);

    /*
     * Produto
     */
    Route::get('produto', ['as' => 'produto.index', 'uses' => '\Laraerp\Http\Controllers\ProdutoController@index']);


    /*
     * Venda
     */
    Route::get('venda', ['as' => 'venda.index', 'uses' => '\Laraerp\Http\Controllers\VendaController@index']);
    Route::get('venda/ver/{venda}', ['as' => 'venda.ver', 'uses' => '\Laraerp\Http\Controllers\VendaController@ver']);
    Route::get('venda/deletar/{venda}', ['as' => 'venda.deletar', 'uses' => '\Laraerp\Http\Controllers\VendaController@deletar']);

    /*
     * Dashboard
     */
    Route::get('/', '\Laraerp\Http\Controllers\DashboardController@index');
});



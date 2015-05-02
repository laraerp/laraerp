<?php

/*
 * Models
 */
Route::model('cliente', 'Laraerp\Cliente');

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


    /*
     * Dashboard
     */
    Route::get('/', '\Laraerp\Http\Controllers\DashboardController@index');
});



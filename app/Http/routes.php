<?php

/*
 * Models
 */
Route::model('cliente', 'Laraerp\Cliente');

Route::group(['middleware' => ['auth']], function() {

    /*
     * Cliente
     */
    Route::get('cliente', ['as' => 'cliente.index', 'uses' => '\Laraerp\Http\Controllers\ClienteController@index']);


    /*
     * Dashboard
     */
    Route::get('/', '\Laraerp\Http\Controllers\DashboardController@index');
});



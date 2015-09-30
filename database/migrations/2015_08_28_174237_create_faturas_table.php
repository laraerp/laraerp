<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('faturas', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->integer('nota_fiscal_id')->unsigned()->nullable();
            $table->foreign('nota_fiscal_id')->references('id')->on('nota_fiscals')->onDelete('cascade')->onUpdate('cascade');

            $table->text('descricao')->nullable();

            $table->string('tipo')->nullable();
            $table->text('numero');
            $table->date('data');
            $table->float('valor')->default(0);
            $table->date('data_pagamento')->nullable();
            $table->float('valor_pago')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('faturas');
    }
}

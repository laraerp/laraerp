<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->bigInteger('ncm')->nullable();
            $table->foreign('ncm')->references('codigo')->on('ncms');

            $table->bigInteger('cfop')->nullable();
            $table->foreign('cfop')->references('codigo')->on('cfops');

            $table->integer('unidade_medida_id')->unsigned()->nullable();
            $table->foreign('unidade_medida_id')->references('id')->on('unidade_medidas');

            $table->enum('tipo', ['ENTRADA', 'SAIDA'])->nullable();

            $table->string('codigo')->nullable();
            $table->string('codigo_ean')->nullable();
            $table->string('descricao')->unique();

            $table->decimal('valor_unitario')->nullable();

            $table->integer('unidade_medida_fator_id')->unsigned()->nullable();
            $table->foreign('unidade_medida_fator_id')->references('id')->on('unidade_medida_fators');

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
        Schema::drop('produtos');
    }
}

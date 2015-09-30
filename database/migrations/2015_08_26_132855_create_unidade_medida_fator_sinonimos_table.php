<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeMedidaFatorSinonimosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade_medida_fator_sinonimos', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('unidade_medida_fator_id')->unsigned();
            $table->foreign('unidade_medida_fator_id')->references('id')->on('unidade_medida_fators')->onDelete('cascade');

            $table->string('simbolo')->unique();

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
        Schema::drop('unidade_medida_fator_sinonimos');
    }
}

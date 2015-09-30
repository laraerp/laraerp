<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadeMedidaFatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unidade_medida_fators', function (Blueprint $table) {

            $table->increments('id');

            $table->integer('unidade_medida_id')->unsigned();
            $table->foreign('unidade_medida_id')->references('id')->on('unidade_medidas')->onDelete('cascade');

            $table->string('simbolo');
            $table->decimal('fator', 8, 6);

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
        Schema::drop('unidade_medida_fators');
    }
}

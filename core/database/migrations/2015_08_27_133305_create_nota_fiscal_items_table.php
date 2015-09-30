<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaFiscalItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_fiscal_items', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('nota_fiscal_id')->unsigned();
            $table->foreign('nota_fiscal_id')->references('id')->on('nota_fiscals')->onDelete('cascade')->onUpdate('cascade');

            $table->integer('produto_id')->nullable()->unsigned();
            $table->foreign('produto_id')->references('id')->on('produtos');

            $table->bigInteger('ncm')->nullable();
            $table->foreign('ncm')->references('codigo')->on('ncms');

            $table->bigInteger('cfop')->nullable();
            $table->foreign('cfop')->references('codigo')->on('cfops');

            $table->integer('unidade_medida_fator_id')->nullable()->unsigned();
            $table->foreign('unidade_medida_fator_id')->references('id')->on('unidade_medida_fators');

            $table->string('codigo');
            $table->text('descricao');

            $table->float('quantidade')->default(0);
            $table->string('unidade');
            $table->float('valor_unitario')->default(0);
            $table->float('valor_total')->default(0);

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
        Schema::drop('nota_fiscal_items');
    }
}

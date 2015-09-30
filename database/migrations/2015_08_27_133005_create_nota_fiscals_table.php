<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotaFiscalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nota_fiscals', function (Blueprint $table) {
            $table->increments('id');

            $table->string('chave_nfe')->nullable()->unique();

            $table->integer('empresa_id')->unsigned();
            $table->foreign('empresa_id')->references('id')->on('empresas');

            $table->integer('fornecedor_id')->unsigned()->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedors');

            $table->integer('cliente_id')->unsigned()->nullable();
            $table->foreign('cliente_id')->references('id')->on('clientes');

            $table->integer('endereco_entrega_id')->nullable()->unsigned();
            $table->foreign('endereco_entrega_id')->references('id')->on('enderecos');

            $table->date('data');
            $table->date('data_entrega')->nullable();

            $table->string('modelo')->nullable();
            $table->string('numero')->nullable();
            $table->string('serie')->nullable();
            $table->float('valor_frete')->default(0);
            $table->float('valor_total')->default(0);
            $table->float('valor_pago')->default(0);

            $table->string('path_xml')->nullable();
            $table->string('path_pdf')->nullable();
            $table->text('observacoes')->nullable();

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
        Schema::drop('nota_fiscals');
    }
}

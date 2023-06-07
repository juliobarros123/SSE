<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipoPagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('pagamento');
            $table->string('tipo');
            $table->string('valor');
            $table->string('dias_multa')->nullable();
            $table->string('multa_valor')->nullable();
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->timestamps();
            $table->string('slug')->unique();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipo_pagamentos');
    }
}
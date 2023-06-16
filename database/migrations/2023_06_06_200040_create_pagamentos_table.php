<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagamentosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagamentos', function (Blueprint $table) {
            $table->id();
            $table->string('mes')->nullable();
            $table->unsignedBigInteger('id_tipo_pagamento');
            $table->foreign('id_tipo_pagamento')->references('id')->on('tipo_pagamentos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_aluno');
            $table->foreign('id_aluno')->references('id')->on('alunnos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_ano_lectivo');
            $table->foreign('id_ano_lectivo')->references('id')->on('anoslectivos')->onDelete('cascade');
            $table->string('slug')->unique();
            $table->string('valor_final')->nullable();

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
        Schema::dropIfExists('pagamentos');
    }
}
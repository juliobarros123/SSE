<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInicioTerminoAnoLectivosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inicio_termino_ano_lectivos', function (Blueprint $table) {
            $table->id();
            $table->string('mes_inicio');
            $table->string('mes_termino');
            $table->unsignedBigInteger('id_ano_lectivo');
            $table->foreign('id_ano_lectivo')->references('id')->on('anoslectivos')->onDelete('cascade');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('inicio_termino_ano_lectivos');
    }
}
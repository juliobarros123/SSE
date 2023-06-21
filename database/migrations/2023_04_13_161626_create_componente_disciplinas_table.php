<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponenteDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componente_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_disciplina");
            $table->unsignedBigInteger("id_componente");
            $table->foreign('id_componente')->references('id')->on('componentes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreign('id_disciplina')->references('id')->on('disciplinas')->onDelete('CASCADE')->onUpgrade('CASCADE');
          
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
        Schema::dropIfExists('componente_disciplinas');
    }
}
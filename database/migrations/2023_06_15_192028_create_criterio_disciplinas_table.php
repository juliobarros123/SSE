<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCriterioDisciplinasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('criterio_disciplinas', function (Blueprint $table) {
            $table->id();
            $table->string('resultado')->nullable();
            $table->string('valor_inicial')->nullable();
            $table->string('valor_final')->nullable();
            $table->foreignId('id_disciplina')->constrained('disciplinas')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('id_curso')->constrained('cursos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('id_classe')->constrained('classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
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
        Schema::dropIfExists('criterio_disciplinas');
    }
}
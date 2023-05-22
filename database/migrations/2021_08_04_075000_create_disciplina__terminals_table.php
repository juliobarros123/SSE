<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinaTerminalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplina__terminals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
 $table->string('slug')->unique();
            $table->unsignedBigInteger("id_disciplina");
            $table->unsignedBigInteger("id_classe");
            $table->unsignedBigInteger('it_idCurso');
            $table->integer("it_estado");
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreign('id_disciplina')->references('id')->on('disciplinas')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreign('it_idCurso')->references('id')->on('cursos')->onDelete('cascade');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('disciplina__terminals');
    }
}

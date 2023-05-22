<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Turmas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas', function (Blueprint $table) {
            $table->id();
            $table->string('vc_nomedaTurma');
            $table->unsignedBigInteger('it_idClasse');
            $table->unsignedBigInteger('it_idCurso');
            $table->unsignedBigInteger('it_idAnoLectivo');
            $table->foreign('it_idAnoLectivo')->references('id')->on('anoslectivos')->onDelete('cascade');
            $table->foreign('it_idClasse')->references('id')->on('classes')->onDelete('cascade');
            $table->foreign('it_idCurso')->references('id')->on('cursos')->onDelete('cascade');
            $table->string('vc_turnoTurma');
            $table->integer('it_qtdeAlunos');
            $table->integer('it_qtMatriculados')->default(0);
            $table->string('vc_salaTurma')->nullable();
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
        Schema::dropIfExists('turmas');
    }
}

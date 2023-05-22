<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Notas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notas', function (Blueprint $table) {
            $table->id();
            $table->float('fl_nota1')->nullable()->default('0');
            $table->float('fl_nota2')->nullable()->default('0');
            $table->float('fl_mac')->nullable()->default('0');
            $table->unsignedBigInteger('id_aluno');
            $table->foreign('id_aluno')->references('id')->on('alunnos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('it_disciplina')->constrained('disciplinas_cursos_classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_classe');
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_turma');
            $table->foreign('id_turma')->references('id')->on('turmas')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('vc_tipodaNota');
            $table->float('fl_media')->default('0');
            $table->unsignedBigInteger('id_ano_lectivo');
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
        Schema::dropIfExists('notas');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDisciplinasCursosClassesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disciplinas_cursos_classes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('it_disciplina')->constrained('disciplinas')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('it_curso')->constrained('cursos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('it_classe')->constrained('classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->integer('terminal')->default(0);
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
        Schema::dropIfExists('disciplinas_cursos_classes');
    }
}

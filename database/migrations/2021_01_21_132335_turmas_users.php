<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TurmasUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turmas_users', function (Blueprint $table) {
            $table->id();
            $table->foreignId('it_idTurma')->constrained('turmas')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('it_idUser')->constrained('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('it_idClasse')->constrained('classes')->onDelete('CASCADE')->onUpdate('CASCADE')->nullable();
            $table->foreignId('it_idDisciplina')->constrained('disciplinas')->onDelete('CASCADE')->onUpdate('CASCADE');
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
        Schema::dropIfExists('turmas_users');
    }
}

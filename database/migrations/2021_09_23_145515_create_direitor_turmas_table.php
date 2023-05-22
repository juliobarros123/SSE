<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDireitorTurmasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('direitor_turmas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_turma');
            $table->unsignedBigInteger('id_user');
            $table->unsignedBigInteger('id_anoLectivo');
      
            $table->foreign('id_user')->references('id')->on('users')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_turma')->references('id')->on('turmas')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreign('id_anoLectivo')->references('id')->on('anoslectivos');
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
        Schema::dropIfExists('direitor_turmas');
    }
}

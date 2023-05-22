<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoordenadorTurnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coordenador_turnos', function (Blueprint $table) {
            $table->id();
            $table->string('turno', 50)->nullable();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_ano_lectivo');
            $table->foreign('id_ano_lectivo')->references('id')->on('anoslectivos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->integer('estado_coordenador_turno')->default(1);
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
        Schema::dropIfExists('coordenador_turnos');
    }
}

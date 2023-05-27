<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIdadesdecandidaturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('idadesdecandidaturas', function (Blueprint $table) {
            $table->id();
            $table->date('dt_limiteaesquerda');
            $table->date('dt_limitemaxima');
            $table->unsignedBigInteger('id_ano_lectivo');
            $table->foreign('id_ano_lectivo')->references('id')->on('anoslectivos')->onDelete('cascade');
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
        Schema::dropIfExists('idadesdecandidaturas');
    }
}

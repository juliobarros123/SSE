<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotaRecursosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
     
        Schema::create('nota_recursos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_aluno');
            $table->unsignedBigInteger('id_disciplina');
            $table->foreign('id_aluno')->references('id')->on('alunnos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreign('id_disciplina')->references('id')->on('disciplinas')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->float('nota')->default('0');
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
        Schema::dropIfExists('nota_recursos');
    }
}

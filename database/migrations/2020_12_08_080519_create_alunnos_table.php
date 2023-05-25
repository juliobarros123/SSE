<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alunnos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('processo');
            $table->string('tipo_aluno');
            $table->string('vc_imagem')->nullable();
            $table->foreignId('id_candidato')->constrained('candidatos')->onDelete('CASCADE')->onUpgrade('CASCADE');
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
        Schema::dropIfExists('alunnos');
    }
}
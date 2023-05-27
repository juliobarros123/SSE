<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnoLectivoPublicadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ano_lectivo_publicados', function (Blueprint $table) {
            $table->id();
        
            $table->year('ya_inicio');
            $table->year('ya_fim');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->foreignId('id_anoLectivo')->constrained('anoslectivos')->onDelete('CASCADE')->onUpgrade('CASCADE');

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
        Schema::dropIfExists('ano_lectivo_publicados');
    }
}
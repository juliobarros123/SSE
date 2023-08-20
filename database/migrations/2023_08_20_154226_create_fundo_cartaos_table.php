<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundoCartaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fundo_cartaos', function (Blueprint $table) {
            $table->id();
            $table->string('entidade');
            $table->string('fundo');
            $table->string('slug')->unique();
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fundo_cartaos');
    }
}
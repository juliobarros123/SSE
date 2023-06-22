<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfoCerficadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('info_cerficados', function (Blueprint $table) {
            $table->id();
           
            $table->string('decreto')->nullable();
            $table->string('artigo')->nullable();

            $table->string('LBSEE')->nullable();
            $table->string('lei')->nullable();
            $table->string('ensino')->nullable();
            $table->foreignId('id_classe')->constrained('classes')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('alinea')->nullable();

            $table->timestamps();
            $table->string('slug')->unique();
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('info_cerficados');
    }
}
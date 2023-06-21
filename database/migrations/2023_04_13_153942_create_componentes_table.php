<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComponentesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('componentes', function (Blueprint $table) {
            $table->id();
            $table->string('vc_componente')->nullable();
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('id_curso')->nullable();
            $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('cascade')->onUpdate('cascade');
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
        Schema::dropIfExists('componentes');
    }
}
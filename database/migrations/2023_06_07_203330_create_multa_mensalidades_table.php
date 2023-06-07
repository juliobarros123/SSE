<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultaMensalidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('multa_mensalidades', function (Blueprint $table) {
            $table->id();
            $table->string('dias_multa')->nullable();
            $table->string('multa_valor')->nullable();
            $table->string('tipo_multa')->nullable();
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');

            $table->string('slug')->unique();
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
        Schema::dropIfExists('multa_mensalidades');
    }
}
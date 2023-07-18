<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCadeadoPautasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cadeado_pautas', function (Blueprint $table) {
            $table->string('estado')->nullable();
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
        Schema::dropIfExists('cadeado_pautas');
    }
}

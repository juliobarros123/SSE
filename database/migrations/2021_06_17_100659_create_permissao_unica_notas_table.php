<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermissaoUnicaNotasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissao_unica_notas', function (Blueprint $table) {
            $table->id();
            $table->string('vc_tipo_nota');
            $table->foreignID('id_permissao_notas');
            $table->foreign('id_permissao_notas')->references('id')->on('permissao_notas')->onDelete('CASCADE');
            $table->unsignedBigInteger('estado')->enum('0','1')->default('1');
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
        Schema::dropIfExists('permissao_unica_notas');
    }
}

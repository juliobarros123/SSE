<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCabecalhosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cabecalhos', function (Blueprint $table) {
            $table->id();
            $table->string('vc_ensignia', 255)->nullable();
            $table->string('vc_logo', 255)->nullable();
            $table->string('vc_logo_vectorizado', 255)->default('images\vectorizado\logo.png');
            $table->string('vc_escola', 255)->nullable();
            ;
            $table->string('vc_acronimo', 255);
            $table->string('vc_nif', 255)->nullable();
            ;
            $table->string('vc_republica', 255)->nullable();
            ;
            $table->string('vc_ministerio', 255)->nullable();
            ;
            $table->string('vc_endereco', 255)->nullable();
            ;
            $table->integer('it_telefone')->nullable();
            $table->string('vc_email', 255)->nullable();
            $table->string('vc_nomeDirector', 255)->nullable();
            ;
            $table->string('vc_nomeSubdirectorPedagogico', 255)->nullable();
            $table->string('vc_nomeSubdirectorAdminFinanceiro', 255)->nullable();
            $table->string('vc_numero_escola')->nullable()->nullable();
            $table->string('vc_tipo_escola')->nullable()->nullable();
            $table->unsignedBigInteger("it_id_municipio")->nullable();
            $table->foreign('it_id_municipio')->references('id')->on('municipios')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->string('assinatura_director', 255)->nullable();
            $table->string('director_municipal', 255)->nullable();
            $table->string('estado_cabecalho', 255)->default('Activado');
          
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
        Schema::dropIfExists('cabecalhos');
    }
}
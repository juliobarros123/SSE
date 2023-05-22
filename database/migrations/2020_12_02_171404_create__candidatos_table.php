<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidatosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidatos', function (Blueprint $table) {

            $table->id();
            //dados pessoais
            $table->string('vc_primeiroNome', 255);
            $table->string('vc_nomedoMeio', 255)->nullable();
            $table->string('vc_apelido', 255);
            $table->date('dt_dataNascimento');
            $table->string('vc_nomePai', 255)->nullable();
            $table->string('vc_nomeMae', 255)->nullable();
            $table->string('vc_genero', 10);
            $table->string('vc_dificiencia', 3)->nullable();
            ;
            $table->string('vc_estadoCivil', 20)->nullable();
            ;
            $table->string('it_telefone', 14)->nullable();
            ;
            $table->string('vc_email', 255)->nullable();
            $table->string('vc_residencia', 255)->nullable();
            ;
            $table->string('vc_naturalidade', 255)->nullable();
            ;
            $table->string('vc_provincia', 100)->nullable();
            ;
            $table->string('vc_bi', 14)->nullable();
            $table->date('dt_emissao')->nullable();
            $table->string('vc_localEmissao', 100)->nullable();
            ;


            //dados academicos
            $table->string('vc_EscolaAnterior', 255)->nullable();
            ;
            $table->string('ya_anoConclusao', 20)->nullable();
            ;

            //dados da nova escola
            $table->string('vc_nomeCurso', 255)->nullable();
            ;
            $table->string('vc_classe', 3)->nullable();
            ;
            $table->string('vc_anoLectivo', 20)->nullable();
            ;
            //estado de candidado
            $table->unsignedBigInteger('it_estado_candidato')->enum('0', '1')->default('1');
            $table->integer('vc_vezesdCandidatura')->nullable();
            $table->string('tokenKey');
            $table->timestamps();
            $table->string('slug')->unique();

            //Notas do Candidato
            $table->integer('LP_S')->nullable();
            $table->integer('LP_O')->nullable();
            $table->integer('LP_N')->nullable();
            $table->integer('MAT_S')->nullable();
            $table->integer('MAT_O')->nullable();
            $table->integer('MAT_N')->nullable();
            $table->integer('FIS_S')->nullable();
            $table->integer('FIS_O')->nullable();
            $table->integer('FIS_N')->nullable();
            $table->integer('QUIM_S')->nullable();
            $table->integer('QUIM_O')->nullable();
            $table->integer('QUIM_N')->nullable();
            $table->integer('estado_de_pagamento')->nullable();
            $table->integer('media')->nullable();
            $table->integer('state')->default(1);
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('id_curso');
            $table->foreign('id_curso')->references('id')->on('cursos')->onDelete('cascade');
            $table->unsignedBigInteger('id_classe')->nullable();
            $table->foreign('id_classe')->references('id')->on('classes')->onDelete('cascade');
            $table->unsignedBigInteger('id_ano_lectivo');
            $table->foreign('id_ano_lectivo')->references('id')->on('anoslectivos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('candidatos');
    }
}
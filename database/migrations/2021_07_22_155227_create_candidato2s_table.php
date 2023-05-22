<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCandidato2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('candidato2s', function (Blueprint $table) {
            $table->id();
            $table->string('vc_primeiroNome', 50)->nullable();
            $table->string('vc_nomedoMeio', 50)->nullable();
            $table->string('vc_ultimoaNome', 50)->nullable();
            $table->integer('it_classe')->nullable();
            $table->date('dt_dataNascimento')->nullable();
            $table->string('vc_naturalidade', 50)->nullable();
            $table->string('vc_provincia', 45)->nullable();
            $table->string('vc_namePai', 90)->nullable();
            $table->string('vc_nameMae', 90)->nullable();
            $table->string('vc_dificiencia', 30)->nullable();
            $table->string('vc_estadoCivil', 20)->nullable();
            $table->string('vc_genero', 15)->nullable();
            $table->integer('it_telefone')->nullable();
            $table->string('vc_email')->nullable();
            $table->string('vc_residencia', 75)->nullable();
            $table->string('vc_bi', 14)->nullable();
            $table->date('dt_emissao', 14)->nullable();
            $table->string('vc_localEmissao', 50)->nullable();
            $table->string('vc_EscolaAnterior', 255)->nullable();
            $table->year('ya_anoConclusao', 20)->nullable();
            $table->string('vc_nomeCurso', 255)->nullable();
            $table->date('dt_anoCandidatura', 20)->nullable();
            $table->integer('it_media')->nullable();
            $table->integer('idade')->nullable();
            $table->string('vc_anoLectivo')->nullable();
            $table->string('tokenKey')->nullable();
            $table->string('foto')->nullable();
           
            //foreign key
            /*$table->foreignId('id_turma')->constrained('turmas')->onDelete('cascade')->onUpdate('cascade');
            $table->foreignId('id_classe')->constrained('classes')->onDelete('casacde')->onUpdate('cascade');*/
            $table->unsignedBigInteger('it_estado_aluno')->enum('0','1')->default('1');
            $table->unsignedBigInteger('it_processo')->nullable();
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
        Schema::dropIfExists('candidato2s');
    }
}

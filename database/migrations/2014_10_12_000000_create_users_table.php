<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::create('users', function (Blueprint $table) {
        //     $table->id();
        //     $table->string('name');
        //     $table->string('email')->unique();
        //     $table->timestamp('email_verified_at')->nullable();
        //     $table->string('password');
        //     $table->rememberToken();
        //     $table->foreignId('current_team_id')->nullable();
        //     $table->text('profile_photo_path')->nullable();
        //     $table->timestamps();

        // });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('vc_nomeUtilizador');
            $table->string('vc_email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('vc_tipoUtilizador')->default('aluno');
            $table->string('vc_telefone');
            $table->string('vc_primemiroNome');
            $table->string('vc_apelido');
            $table->string('vc_genero');
            $table->integer('it_n_agente')->nullable();
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->text('profile_photo_path')->nullable();
            $table->unsignedBigInteger('it_estado_user')->enum('0','1')->default('1');
            $table->foreignId('id_cabecalho')->constrained('cabecalhos')->onDelete('CASCADE')->onUpgrade('CASCADE');
            $table->unsignedBigInteger('desenvolvedor')->enum('0','1')->default('0');
            $table->timestamps();
 $table->string('slug')->unique();
        });
    }

/* ALTER TABLE users add it_n_agente integer(11) unique null AFTER vc_genero; */


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}

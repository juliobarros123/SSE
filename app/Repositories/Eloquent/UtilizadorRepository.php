<?php

namespace App\Repositories\Eloquent;

use App\Models\User;

use App\Models\Team;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UtilizadorRepository implements UtilizadorInterface
    // interface UtilizadorRepository extends UtilizadorInterface
{

    // use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     * @param mixed $id
     */


    // public function get($id){

    // }

    // public function get($id){

    // }

    public function store(array $input)
    {


        User::create([
            'vc_nomeUtilizador' => $input['vc_nomeUtilizador'],
            'vc_email' => $input['vc_email'],
            'vc_tipoUtilizador' => $input['vc_tipoUtilizador'],
            'vc_telefone' => $input['vc_telefone'],
            'vc_primemiroNome' => $input['vc_primemiroNome'],
            'vc_apelido' => $input['vc_apelido'],
            'vc_genero' => $input['vc_genero'],
            'it_n_agente' => $input['it_n_agente'],
            'password' => Hash::make($input['password']),
            'id_cabecalho' => Auth::User()->id_cabecalho,
        ]);

    }

    /**
     * Create a personal team for the user.
     *
     * @param  \App\Models\User  $user
     * @return void
     */

    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->vc_nome, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }

    public function update(array $input, $slug)
    {

        $dados = $input[0];
        // dd(  $dados,"o");
        User::where('users.slug',$slug)->update([
            'vc_nomeUtilizador' => $dados['vc_nomeUtilizador'],
            'vc_email' => $dados['vc_email'],
            'vc_tipoUtilizador' => $dados['vc_tipoUtilizador'],
            'vc_telefone' => $dados['vc_telefone'],
            'vc_primemiroNome' => $dados['vc_primemiroNome'],
            'vc_apelido' => $dados['vc_apelido'],
            'vc_genero' => $dados['vc_genero'],
            'it_n_agente' => $dados['it_n_agente'],
            'password' => Hash::make($dados['password']),
        ]);


    }
}
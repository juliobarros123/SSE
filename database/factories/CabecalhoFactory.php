<?php

namespace Database\Factories;

use App\Models\Cabecalho;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Municipio;
class CabecalhoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Cabecalho::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $mun = Municipio::first();
        return [

            'vc_ensignia' => "logo",
            'vc_logo' => "images/logotipo/logo.png",
            'vc_escola' => "Plataforma de Administração Escolar",
            'vc_acronimo' => "PAE",
            'vc_nif' => "399393003994940994900",
            'vc_republica' => "República de Angola",
            'vc_ministerio' => "Ministério das telecomunicações",
            'vc_endereco' => "Luanda",
            'it_telefone' => 999555999,
            'vc_email' => "pea@gmail.com",
            'vc_nomeDirector' => "Júlio António Morais Barros",
            'vc_nomeSubdirectorPedagogico' => "Nome do subdirector Pedagógico",
            'vc_nomeSubdirectorAdminFinanceiro' => "Nome do Subdirector Administrativo e Financeiro",
            'it_id_municipio' => $mun->id
        ];
    }
}
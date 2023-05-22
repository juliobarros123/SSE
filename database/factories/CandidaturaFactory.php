<?php

namespace Database\Factories;

use App\Models\Candidatura;
use Illuminate\Database\Eloquent\Factories\Factory;


class CandidaturaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Candidatura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'vc_primeiroNome' => $this->faker->name,
            'vc_nomedoMeio' => $this->faker->name,
            'vc_apelido' => $this->faker->lastName,
            'dt_dataNascimento' => $this->faker->date(),
            'vc_nomePai' => $this->faker->name,
            'vc_nomeMae' => $this->faker->name,
            'vc_genero' => 'Masculino',
            'vc_dificiencia' => 'Não',
            'vc_estadoCivil' => 'Solteiro',
            // 'it_telefone' => $this->faker->phoneNumber,
            'it_telefone' => rand(14, 14),
            'vc_email' => $this->faker->unique()->safeEmail,
            'vc_residencia' => 'Uige',
            'vc_naturalidade' => 'Danda',
            'vc_provincia' => 'Uíge',
            'vc_bi' => rand(10, 100),
            'dt_emissao' => $this->faker->date(),
            'vc_localEmissao' => 'Uíge',
            'vc_EscolaAnterior' => $this->faker->name,
            'ya_anoConclusao' => 2019,
            'vc_nomeCurso' => 'Informática',
            'vc_classe' => 10,
            'vc_anoLectivo' => '2022-2023',

            'id_cabecalho'=>id_first_cabecalho()

        ];
    }
}

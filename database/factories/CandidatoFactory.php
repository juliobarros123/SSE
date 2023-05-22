<?php

namespace Database\Factories;

use App\Models\Model;
use Illuminate\Database\Eloquent\Factories\Factory;

class CandidatoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Model::class;

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
            'dt_dataNascimento' => $this->faker->date()->format('Y-m-d'),
            'vc_nomePai' => $this->faker->name,
            'vc_nomeMae' => $this->faker->name,
            'vc_genero' => $this->faker->name,
            'vc_dificiencia' => 'Não',
            'vc_estadoCivil' => 'Solteiro',
            'it_telefone' => $this->faker->phoneNumber,
            'vc_email' => $this->faker->unique()->safeEmail,
            'email_verified_at' => now(),
            'vc_residencia' => 'Uige',
            'vc_naturalidade' => $this->faker->cityName,
            'vc_provincia' => $this->faker->cityName,
            'vc_bi' => biUnico(1),
            'vc_localEmissao' => $this->faker->cityName,
            'vc_EscolaAnterior' => $this->faker->name,
            'ya_anoConclusao' => '2019',
            'vc_nomeCurso' => Str::random(['Informática','Eletronoca','Multimédia']),
            'vc_classe' => Str::random(['10','11','12','13']),
            'vc_anoLectivo' => '2022-2023',
            'it_estado' => 1,           

            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'id_cabecalho'=>id_first_cabecalho()
        ];
    }

    
    function biUnico($bi)
    {
        $unico = rand(1,5);
        do {
        $unico = rand(1,5);
        }
        while(StepCategory::where('bi', $bi)->andWhere( 'bi', $unico)->exists());

        return $unico;

    }
}

<?php

namespace Database\Factories;

use App\Models\Activador_da_candidatura;
use Illuminate\Database\Eloquent\Factories\Factory;

class Activador_da_candidaturaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Activador_da_candidatura::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [

            'it_estado' => 1,
            'id_cabecalho'=>id_first_cabecalho()

        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\PermissaoNota;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissaoNotaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermissaoNota::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'estado' => 0,
            'id_cabecalho'=>id_first_cabecalho()
        ];
    }
}

<?php

namespace Database\Factories;

use App\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class ProvinciaFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Provincia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
       
        $provincias = array(

            array(

                "vc_nome" =>"Bengo",
            ),
            array(

                "vc_nome" =>"Benguela",

            ),
            array(

                "vc_nome" =>"Bié",
            ),
            array(

                "vc_nome" =>"Cabinda",
            ),
            array(

                "vc_nome" =>"Cuando-Cubango",
            ),
            array(

                "vc_nome" =>"Cuanza Norte",
            ),
            array(

                "vc_nome" =>"Cuanza Sul",
            ),
            array(

                "vc_nome" =>"Cunene",
            ),
            array(

                "vc_nome" =>"Huambo",
            ),
            array(

                "vc_nome" =>"Huíla",
            ),
            array(

                "vc_nome" =>"Luanda",
            ),
            array(

                "vc_nome" =>"Lunda Norte",
            ),
            array(

                "vc_nome" =>"Lunda Sul",
            ),
            array(

                "vc_nome" =>"Malanje",
            ),
            array(

                "vc_nome" =>"Moxico",
            ),
            array(

                "vc_nome" =>"Namibe",
            ),
            array(

                "vc_nome" =>"Uíge",
            ),

        );
       

        foreach ($provincias as $provincia) {
            # code...
            //echo($provincia["vc_nome"]);
            $pprovincia = Provincia::where('vc_nome',$provincia["vc_nome"])->where('it_estado_provincia',1)->count();
            if ($pprovincia == 0) {
                # code...
                Provincia::create([

               
                    'vc_nome' => $provincia["vc_nome"],
                ]);
            }
        }
       
        return [
            'vc_nome' => "Zaire",
        ];
    }
}

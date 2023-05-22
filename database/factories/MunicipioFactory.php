<?php

namespace Database\Factories;

use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MunicipioFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Municipio::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        $municipios = array(

            array(

                "vc_nome" => "Alto Cauale",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Ambuila",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Bembe",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Buengas",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Bungo",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Damba",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Milunga",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Mucaba",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Negage",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Puri",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Kimbele",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Dange Quitexe",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Sanza Pombo",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Songo",
                "it_id_provincia" => 'Uíge'
            ),
            array(

                "vc_nome" => "Uíge",
                "it_id_provincia" => 'Uíge'
            ),
            array(


                "vc_nome" => "Dande",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Ambriz",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Dembos",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Bula Atumba",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Nambuangongo",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Pango Aluquém",
                "it_id_provincia" => 'Bengo'
            ),
            array(


                "vc_nome" => "Balombo",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Benguela",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Bocoio",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Caimbambo",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Catumbela",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Chongorói",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Cubal",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Ganda",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Lobito",
                "it_id_provincia" => 'Benguela'
            ),
            array(


                "vc_nome" => "Baía Farta",
                "it_id_provincia" => 'Benguela'
            ),


            array(


                "vc_nome" => "Andulo",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Camacupa",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Catabola",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Chinguar",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Chitembo",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Cuemba",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Cunhinga",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Cuíto",
                "it_id_provincia" => 'Bié'
            ),
            array(


                "vc_nome" => "Nharea",
                "it_id_provincia" => 'Bié'
            ),



            array(


                "vc_nome" => "Belize",
                "it_id_provincia" => 'Cabinda'
            ),
            array(


                "vc_nome" => "Buco-Zau",
                "it_id_provincia" => 'Cabinda'
            ),
            array(


                "vc_nome" => "Cabinda",
                "it_id_provincia" => 'Cabinda'
            ),
            array(


                "vc_nome" => "Cacongo",
                "it_id_provincia" => 'Cabinda'
            ),




            array(


                "vc_nome" => "Calai",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Cuangar",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Cuchi",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Cuito Cuanavale",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Dirico",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Mavinga",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Menongue",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Nancova",
                "it_id_provincia" => 'Cuando-Cubango'
            ),
            array(


                "vc_nome" => "Rivungo",
                "it_id_provincia" => 'Cuando-Cubango'
            ),

            array(


                "vc_nome" => "Ambaca",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Banga",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Bolongongo",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Cambambe",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Cazengo",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Golungo Alto",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Gonguembo",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Lucala",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Quiculungo",
                "it_id_provincia" => 'Cuanza Norte'
            ),
            array(


                "vc_nome" => "Samba Caju",
                "it_id_provincia" => 'Cuanza Norte'
            ),

            array(


                "vc_nome" => "Amboim",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => " Cassongue",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => " Cela",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => " Conda",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Ebo",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Libolo",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Mussende",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Porto Amboim",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Quibala",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Quilenda",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Seles",
                "it_id_provincia" => 'Cuanza Sul'
            ),
            array(


                "vc_nome" => "Sumbe",
                "it_id_provincia" => 'Cuanza Sul'
            ),



            array(


                "vc_nome" => "Cahama",
                "it_id_provincia" => 'Cunene'
            ),
            array(


                "vc_nome" => "Cuanhama",
                "it_id_provincia" => 'Cunene'
            ),
            array(


                "vc_nome" => " Curoca",
                "it_id_provincia" => 'Cunene'
            ),
            array(


                "vc_nome" => " Cuvelai",
                "it_id_provincia" => 'Cunene'
            ),
            array(


                "vc_nome" => "Namacunde",
                "it_id_provincia" => 'Cunene'
            ),
            array(


                "vc_nome" => "Ombadja",
                "it_id_provincia" => 'Cunene'
            ),


            array(


                "vc_nome" => "Bailundo",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Cachiungo",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Caála",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Ecunha",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Huambo",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Londuimbali",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Longonjo",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Mungo",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Chicala-Choloanga",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Chinjenje",
                "it_id_provincia" => 'Huambo'
            ),
            array(


                "vc_nome" => "Ucuma",
                "it_id_provincia" => 'Huambo'
            ),

            array(


                "vc_nome" => "Caconda",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Cacula",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Caluquembe",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Gambos",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Chibia",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Chicomba",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Chipindo",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Cuvango",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => " Humpata",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Jamba",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Lubango",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Matala",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Quipungo",
                "it_id_provincia" => 'Huíla'
            ),
            array(


                "vc_nome" => "Quilengues",
                "it_id_provincia" => 'Huíla'
            ),

            array(


                "vc_nome" => "Belas",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Cacuaco",
                "it_id_provincia" => 'Luanda'
            ),
            array(

                "vc_nome" => "Cazenga",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Ícolo e Bengo",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Luanda",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Kilamba Kiaxi",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Quiçama",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Talatona",
                "it_id_provincia" => 'Luanda'
            ),
            array(


                "vc_nome" => "Viana",
                "it_id_provincia" => 'Luanda'
            ),

            array(


                "vc_nome" => "Cambulo",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Capenda-Camulemba",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Caungula",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Chitato",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Cuango",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Cuílo",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Lóvua",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Lubalo",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Xá-Muteba",
                "it_id_provincia" => 'Lunda Norte'
            ),
            array(


                "vc_nome" => "Lucapa",
                "it_id_provincia" => 'Lunda Norte'
            ),

            array(


                "vc_nome" => "Cacolo",
                "it_id_provincia" => 'Lunda Sul'
            ),
            array(


                "vc_nome" => "Dala",
                "it_id_provincia" => 'Lunda Sul'
            ),
            array(


                "vc_nome" => "Muconda",
                "it_id_provincia" => 'Lunda Sul'
            ),
            array(


                "vc_nome" => "Saurimo",
                "it_id_provincia" => 'Lunda Sul'
            ),

            array(


                "vc_nome" => "Cacuso",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Calandula",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Cambundi-Catembo",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Cangandala",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Caombo",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Cuaba Nzoji",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Cunda-Dia-Baze",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Luquembo",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Malanje",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Massango",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Marimba",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Mucari",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Quela",
                "it_id_provincia" => 'Malanje'
            ),
            array(


                "vc_nome" => "Quirima",
                "it_id_provincia" => 'Malanje'
            ),

            array(


                "vc_nome" => "Alto Zambeze",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Bundas",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Camanongue",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Léua",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Luau",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Luacano",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Luchazes",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Cameia",
                "it_id_provincia" => 'Moxico'
            ),
            array(


                "vc_nome" => "Moxico",
                "it_id_provincia" => 'Moxico'
            ),

            array(


                "vc_nome" => "Bibala",
                "it_id_provincia" => 'Namibe'
            ),
            array(


                "vc_nome" => "Camucuio",
                "it_id_provincia" => 'Namibe'
            ),
            array(


                "vc_nome" => "Moçâmedes",
                "it_id_provincia" => 'Namibe'
            ),
            array(


                "vc_nome" => "Tômbua",
                "it_id_provincia" => 'Namibe'
            ),
            array(


                "vc_nome" => "Virei",
                "it_id_provincia" => 'Namibe'
            ),


            array(


                "vc_nome" => "Cuimba",
                "it_id_provincia" => 'Zaire'
            ),
            array(


                "vc_nome" => "Mabanza Congo",
                "it_id_provincia" => 'Zaire'
            ),
            array(


                "vc_nome" => "Nóqui",
                "it_id_provincia" => 'Zaire'
            ),
            array(


                "vc_nome" => "Soio",
                "it_id_provincia" => 'Zaire'
            ),
            array(


                "vc_nome" => "Nezeto",
                "it_id_provincia" => 'Zaire'
            ),





        );

        // dd($municipios);

        foreach ($municipios as $municipio) {
            # code...
            //echo($it_id_provincia["vc_nome"]);
            $pmunicipio = Municipio::where('vc_nome',$municipio["vc_nome"])->where('it_estado_municipio',1)->count();
            $provincia =  Provincia::where('vc_nome',$municipio["it_id_provincia"])->where('it_estado_provincia',1)->first();
            if ($pmunicipio == 0 &&  isset($provincia->id)) {

            Municipio::create([


                "vc_nome" => $municipio["vc_nome"],
                "it_id_provincia" => $provincia->id

            ]);
            }
            $provincia = null;
        }
        $pmunicipio = Municipio::where('vc_nome','Tomboco')->where('it_estado_municipio',1)->count();
        $provincia =  Provincia::where('vc_nome','Zaire')->where('it_estado_provincia',1)->first();
        if ($pmunicipio == 0 &&  isset($provincia->id)) {
        return [

            "vc_nome"=> "Tomboco",
            "it_id_provincia"=>  $provincia->id


        ];
    }


    }
}
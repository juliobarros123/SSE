<?php

namespace database\Seeders;

use App\Models\AnoLectivo;
use App\Models\Classe;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Mes;
use App\Models\Provincia;
use App\Models\Municipio;

use App\Models\PermissaoNota;
use App\Models\Curso;
use App\Models\PermissaoUnicaNota;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */

    public function run()
    {
        
        $provincia = Provincia::create(['vc_nome' => 'Luanda']);
        $municipio = Municipio::create([
            'vc_nome' => 'Kilamba Kiaxi',
            'it_id_provincia' => $provincia->id
        ]);

        $cabecalhos = \App\Models\Cabecalho::count();
        if ($cabecalhos == 0) {
            \App\Models\Cabecalho::factory(1)->create();
        }
        $user = \App\Models\User::where('vc_email', 'escolauige@gmail.com')->count();
        if ($user == 0) {
            \App\Models\User::factory(1)->create();
        }
        //\App\Models\Candidatura::factory(150)->create();
        $candidatura = \App\Models\Activador_da_candidatura::count();
        if ($candidatura == 0) {
            \App\Models\Activador_da_candidatura::factory(1)->create();
        }

        $provincia = \App\Models\Provincia::count();
        if ($provincia < 18) {
            \App\Models\Provincia::factory(1)->create();
        }

        $municipio = \App\Models\Municipio::count();
        /*   if($municipio < 0){ */
        \App\Models\Municipio::factory(1)->create();
        /*   } */
        // \App\Models\PermissaoNota::factory(1)->create();
        //  \App\Models\PermissaoNota::factory(1)->create();

        $mes = DB::table('mes')->count();

        if ($mes == 0) {
            foreach (meses() as $mes)
                Mes::create([
                    'vc_nome' => $mes
                ]);
        }


        /*======================== Begin Permissao Nota======================*/
        $permissaoNotas = PermissaoNota::count();
        if ($permissaoNotas == 0) {
            PermissaoNota::create([
                'vc_trimestre' => 'T',
                'id_cabecalho'=>id_first_cabecalho()
            ]);
            PermissaoNota::create([
                'vc_trimestre' => 'I',
                'id_cabecalho'=>id_first_cabecalho()
            ]);
            PermissaoNota::create([
                'vc_trimestre' => 'II',
                'id_cabecalho'=>id_first_cabecalho()
            ]);
            PermissaoNota::create([
                'vc_trimestre' => 'III',
                'id_cabecalho'=>id_first_cabecalho()
            ]);
        }
        /*========================End Permissao Nota======================*/

        /*======================== Begin Permissao Unica Nota======================*/
        $permissaoUnicaNota = PermissaoUnicaNota::count();
        if ($permissaoUnicaNota == 0) {
            for ($cont = 2; $cont <= 4; $cont++) {
                PermissaoUnicaNota::create([
                    'vc_tipo_nota' => 'Professores',
                    'id_permissao_notas' => $cont,
                    'id_cabecalho'=>id_first_cabecalho()
                ]);
                PermissaoUnicaNota::create([
                    'vc_tipo_nota' => 'Escolar',
                    'id_permissao_notas' => $cont,
                    'id_cabecalho'=>id_first_cabecalho()
                ]);

                PermissaoUnicaNota::create([
                    'vc_tipo_nota' => 'Mac',
                    'id_permissao_notas' => $cont,
                    'id_cabecalho'=>id_first_cabecalho()
                ]);
            }

        }
        /*========================End Permissao Unica Nota======================*/


        $curso = DB::table('cursos')->count();
    
        if ($curso == 0) {
           
                Curso::create([
                    'vc_nomeCurso' => 'Nenhum',
                    'vc_descricaodoCurso'=>'Nenhum',
                    'vc_shortName'=>'Nenhum',
                    'id_cabecalho'=>id_first_cabecalho()
                ]);
              
                for($cont=1;$cont<=13;$cont++){
                    Classe::create([
                         'vc_classe'=>$cont,
                         'id_cabecalho'=>id_first_cabecalho()
                    ]);
                }
                
                AnoLectivo::create([
                    'ya_inicio'=>date('Y')-1,
                     'ya_fim'=>date('Y'),
                    'id_cabecalho'=>id_first_cabecalho()
                ]);
                
           
        }
    }
    
}
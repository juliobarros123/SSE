<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
 abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
 dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
 do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Disciplina_Curso_Classe;

class Curso extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash_bcrypt = '';
            $hash_bcrypt = Hash::make(slug_gerar());
            $stringSemBarras = str_replace('/', '', $hash_bcrypt);
            $model->slug = $stringSemBarras;
        });
    }
    protected $fillable = ['id_cabecalho','slug', 
        'vc_nomeCurso',
        'vc_descricaodoCurso',
        'vc_shortName',
        'it_estadodoCurso',
        'it_estado_curso'
    ];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }

    public function updates($data, $uri)
    {

        $post = [
            'vc_curso' => $data->vc_nomeCurso,
            'it_estado' => '1',
        ];
        $uriP = 'http://192.168.1.63:8000/admin/curso/store';

        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        // execute!
        $response = curl_exec($ch);

        // close the connection, release resources used
        curl_close($ch);

        // do anything you want with your response
        //   dd($response);

        ///   dd($response);


    }
    public  function disciplinas($id_curso)
    {

        $DCC = new Disciplina_Curso_Classe;
        return $DCC->fh_disciplinas_cursos_classes()->where('cursos.id',  $id_curso);
    }
}

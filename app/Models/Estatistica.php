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
use Illuminate\Support\Facades\DB;

class Estatistica extends Model
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



    public function Rem($anoLectivo,$dia)
    {
        if($dia!=null){
   
        $matriculados = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where('matriculas.it_estado_matricula', 1)
            ->select('matriculas.*','cursos.*','cursos.id as id_curso','turmas.*','classes.*','alunnos.*')
            ->whereDate('matriculas.created_at', $dia)->get();
          
        }else if($dia==null)  {
       
            $matriculados = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where('matriculas.it_estado_matricula', 1)
            ->select('matriculas.*','cursos.*','cursos.id as id_curso','turmas.*','classes.*','alunnos.*')
            ->get();  
        }

        if ($anoLectivo && $anoLectivo != 'Todos') {
            $matriculados=    $matriculados->where('vc_anoLectivo', $anoLectivo);
        }
      
        return $matriculados;
    }

    public  function Rec($anoLectivo)
    {
     
        $candidatos = DB::table('candidatos')->where([['candidatos.it_estado_candidato', 1]]);

        if ($anoLectivo && $anoLectivo != 'Todos') {
            $candidatos->where([['candidatos.vc_anoLectivo', $anoLectivo]]);
        }

        return $candidatos;
    }
    public  function Res($anoLectivo)
    {
        $seleccionados = DB::table('alunnos')->where([['alunnos.it_estado_aluno', 1]]);

        if ($anoLectivo && $anoLectivo != 'Todos') {
            $seleccionados->where([['alunnos.vc_anoLectivo', $anoLectivo]]);
        }

        return $seleccionados;
    }

    public  function candidatos2($anoLectivo,$vc_curso)
    {
     
        $candidato2s = DB::table('candidato2s')->where([['candidato2s.it_estado_aluno', 1]]);

        if ($anoLectivo && $anoLectivo != 'Todos') {
            $candidato2s= $candidato2s->where([['candidato2s.vc_anoLectivo', $anoLectivo]]);
        }
        if ($vc_curso && $vc_curso != 'Todos') {
            $candidato2s=  $candidato2s->where([['candidato2s.vc_nomeCurso', $vc_curso]]);
        }
      
        return $candidato2s;
    }
}

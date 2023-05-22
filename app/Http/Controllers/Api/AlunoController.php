<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Alunno;
use App\Models\Classe;
use App\Http\Resources\AlunoResource;
class AlunoController extends Controller
{
   //
   public function alunos(Request $request){
  //  return $request;
      $alunos= DB::table('matriculas')
   ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
   ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
   ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
   ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
   ->where([['classes.vc_classe', $request->vc_classe]])
   ->where([['cursos.vc_nomeCurso', $request->vc_curso]])
   ->where([['turmas.vc_nomedaTurma', $request->vc_turma]])
   ->where([['matriculas.vc_anoLectivo',$request->vc_ano_lectivo]])
    ->select('alunnos.vc_nomedoMeio','alunnos.vc_nameMae','alunnos.vc_namePai','alunnos.vc_ultimoaNome','alunnos.id','alunnos.vc_primeiroNome','alunnos.vc_email','cursos.id as id_curso','cursos.vc_nomeCurso','turmas.vc_nomedaTurma','classes.vc_classe')
   ->get();


   return AlunoResource::collection($alunos);

   }


   public function aluno_group($alunos,$ano_lectivo,$curso,$classe,$turma){

     $alunos_disciplinas_grupo=collect();
     $alunos_disciplinas_object=collect();
      foreach($alunos as $aluno){

   $collection = collect( $aluno);
   $merged = $collection->merge(['group'=>['ano_lectivo'=>$ano_lectivo,'curso'=>$curso,'classe'=>$classe,'turma'=>$turma]]);
 //   $merged = $collection->merge(['group'=>$result]);
   $merged->all();
      $alunos_disciplinas_grupo->push($merged);

   }
   return $alunos_disciplinas_grupo;
  }


   public function aluno_disciplinas($alunos, $disciplinas){

         $alunos_disciplinas=collect();
         $alunos_disciplinas_object=collect();

          foreach($alunos as $aluno){
          $result= $disciplinas->where('id_curso',$aluno->id_curso);
       //    dd($result);

       $collection = collect( $aluno);
       $merged = $collection->merge(['disciplinas'=>$result]);
     //   $merged = $collection->merge(['group'=>$result]);
       $merged->all();
          $alunos_disciplinas->push($merged);
     //      $alunos_disciplinas->all();
     //      $alunos_disciplinas->put('disciplinas', $result);
     //   //    dd($alunos_disciplinas);
     //      $alunos_disciplinas->all();
     //       $alunos_disciplinas_object->push($alunos_disciplinas);
     //      $alunos_disciplinas=collect();

       }

       return $alunos_disciplinas;
   }
public function disciplinas($ano_lectivo,$curso,$classe,$turma){

       return collect(DB::table('disciplinas_cursos_classes')
       ->join('classes', 'classes.id', '=', 'disciplinas_cursos_classes.it_classe')
       ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
       ->join('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
       ->where([['classes.vc_classe', $classe]])
       ->where([['cursos.vc_nomeCurso', $curso]])
       ->select( 'cursos.id as id_curso','disciplinas.id  as id_disciplina','disciplinas.vc_nome')
       ->get());
   }

}

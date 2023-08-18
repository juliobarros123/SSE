<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EstatisticaController extends Controller
{
    //
    public function alunos_por_classes()
    {
        $classes = array();
        $matriculados = array();
        foreach (fh_classes()->get() as $classe) {
            $cont_matricula = fh_matriculas()->where('turmas.it_idClasse', $classe->id)->where('turmas.it_idAnoLectivo', fha_ano_lectivo_publicado()->id_anoLectivo)->count();
            array_push($matriculados, $cont_matricula);
            array_push($classes, "$classe->vc_classe"."ª Classe ");
        }
        $response['matriculados']=$matriculados;
        $response['classes']=$classes;

        return response($response);

    }
    public function alunos_por_turmas()
    {
        $turmas = array();
        $matriculados = array();
        foreach (fh_turmas()->get() as $turma) {
            $cont_matricula = fh_matriculas()->where('turmas.id', $turma->id)->where('turmas.it_idAnoLectivo', fha_ano_lectivo_publicado()->id_anoLectivo)->count();
            array_push($matriculados, $cont_matricula);
            array_push($turmas, "($turma->vc_nomedaTurma-$turma->vc_shortName-$turma->vc_turnoTurma-$turma->vc_classe"."ª Classe)");
        }
        $response['matriculados']=$matriculados;
        $response['turmas']=$turmas;

        return response($response);

    }
    public function candidatos_por_ano_lectivo()
    {
        $anos_lectivos = array();
        $candidatos = array();
        ;
        foreach (fh_anos_lectivos()->get() as $ano_lectivo) {
            $cont_candidatos = fh_candidatos()->where('candidatos.tipo_candidato', 'Comum')->where('candidatos.id_ano_lectivo', $ano_lectivo->id)->count();
            array_push($candidatos, $cont_candidatos);
            array_push($anos_lectivos, "$ano_lectivo->ya_inicio/$ano_lectivo->ya_fim");
        }
        $response['candidatos']=$candidatos;
        $response['anos_lectivos']=$anos_lectivos;

        return response($response);

    }
    public function alunos_por_cursos(){
        $cursos = array();
        $alunos = array();
        ;
        foreach (fh_cursos()->get() as $curso) {
            // dd($curso);
            $cont_alunos = fh_alunos()->where('candidatos.id_curso', $curso->id)->count();
            // dd($cont_alunos);
            array_push($alunos, $cont_alunos);
            array_push($cursos, $curso->vc_nomeCurso);
        }
        $response['alunos']=$alunos;
        $response['cursos']=$cursos;

        return response($response);

    }



}
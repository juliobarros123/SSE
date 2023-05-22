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

class Estudante extends Model
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
    protected $table = 'matriculas';


    public  function StudentForAll($anoLectivo, $curso)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select(
                'matriculas.vc_imagem',
                'matriculas.vc_anoLectivo',
                'turmas.vc_nomedaTurma',
                'classes.vc_classe',
                'cursos.vc_nomeCurso',
                'matriculas.it_idAluno',
                'matriculas.id',
                'alunnos.vc_primeiroNome',
                'alunnos.vc_nomedoMeio',
                'alunnos.vc_nomedoMeio',
                'alunnos.vc_ultimoaNome',
                'alunnos.dt_dataNascimento'
            );
        if ($anoLectivo && $anoLectivo != 'Todos') {
            $estudantes->where([['matriculas.vc_anoLectivo', $anoLectivo]]);
        }
        if ($curso && $curso != 'Todos') {
            $estudantes->where([['cursos.vc_nomeCurso', $curso]]);
        }
        return $estudantes;
    }
    public  function StudentForCard($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where([['matriculas.it_estado_matricula', 1]])
            ->where([['alunnos.id', $id]])
            ->orderBy('matriculas.vc_anoLectivo', 'desc')
            ->limit(1)
            ->select('matriculas.vc_imagem', 'matriculas.vc_anoLectivo', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso', 'cursos.vc_shortName', 'alunnos.vc_primeiroNome', 'alunnos.vc_ultimoaNome', 'alunnos.id')
            ->get();
        return $estudantes;
    }

    public function entregando($idAluno, $idClasse)
    {
        $matriculaEscolhida = DB::table('matriculas')->where([['id_aluno', '=', $idAluno], ['it_idClasse', '=', $idClasse]])
            ->join('turmas', 'turmas.id', '=', 'matriculas.it_idTurma')
            ->join('classes', 'classes.id', '=', 'matriculas.it_idClasse')
            ->join('cursos', 'cursos.id', '=', 'matriculas.it_idCurso')
            ->join('alunnos', 'alunnos.id', '=', 'matriculas.it_idAluno')
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select('matriculas.*', 'turmas.vc_nomedaTurma', 'cursos.vc_nomeCurso', 'classes.vc_classe')
            ->get();

        foreach ($matriculaEscolhida as $m) {
            $pegarMatricula['turma'] = $m->vc_nomedaTurma;
            $pegarMatricula['curso'] = $m->vc_nomeCurso;
            $pegarMatricula['classe'] = $m->vc_classe;
            $pegarMatricula['ano'] = $m->vc_anoLectivo;
        }

        return $pegarMatricula;
    }


    public  function StudentForClassroom($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->where([['turmas.id', $id]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->orderby('vc_primeiroNome', 'asc')
            ->orderby('vc_nomedoMeio', 'asc')
            ->orderby('vc_ultimoaNome', 'asc')
            ->select('matriculas.vc_imagem', 'alunnos.vc_primeiroNome', 'alunnos.vc_ultimoaNome', 'alunnos.vc_nomedoMeio', 'alunnos.id', 'alunnos.dt_dataNascimento', 'alunnos.it_telefone', 'alunnos.vc_genero', 'alunnos.vc_email', 'alunnos.vc_namePai', 'alunnos.vc_nameMae')
            ->get();
        return $estudantes;
    }


    public  function StudentForClassroomNotes($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join("notas","matriculas.it_idAluno","notas.it_idAluno")  
            ->where([['turmas.id', $id]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->orderby('vc_primeiroNome', 'asc')
            ->orderby('vc_nomedoMeio', 'asc')
            ->orderby('vc_ultimoaNome', 'asc')
            ->select('notas.vc_tipodaNota','notas.fl_media','matriculas.vc_imagem', 'alunnos.vc_primeiroNome', 'alunnos.vc_ultimoaNome', 'alunnos.vc_nomedoMeio', 'alunnos.id', 'alunnos.dt_dataNascimento', 'alunnos.it_telefone', 'alunnos.vc_genero', 'alunnos.vc_email', 'alunnos.vc_namePai', 'alunnos.vc_nameMae')
            ->get();
        return $estudantes;
    }

    public  function StudentForSearch($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where([['alunnos.id', $id]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select('matriculas.vc_imagem', 'matriculas.vc_anoLectivo', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso')
            ->get();
        return $estudantes;
    }

    public function StudentForNota($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where([['alunnos.id', $id]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->orderBy('matriculas.id', 'desc')
            ->limit(1)
            ->select('alunnos.vc_primeiroNome', 'alunnos.vc_nomedoMeio', 'alunnos.vc_ultimoaNome', 'matriculas.vc_imagem', 'matriculas.it_idAluno', 'matriculas.vc_anoLectivo', 'turmas.vc_nomedaTurma', 'classes.vc_classe')
            ->get();
        return $estudantes;
    }

    public function SubjectForClass($idClasse, $idCurso)
    {
        $estudantes = DB::table('disciplinas_cursos_classes')
            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')

            ->where([['disciplinas_cursos_classes.it_curso', $idCurso], ['disciplinas_cursos_classes.it_classe', $idClasse]])
            ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])
            ->select('disciplinas_cursos_classes.id', 'disciplinas.vc_nome')
            ->get();
        return $estudantes;
    }



    public  function SelecionadosListas($anoLectivo, $curso)
    {
        $Ralunos = DB::table('alunnos')
            ->where([['alunnos.it_estado_aluno', 1]])
            ->orderby('vc_primeiroNome', 'asc')
            ->orderby('vc_nomedoMeio', 'asc')
            ->orderby('vc_ultimoaNome', 'asc');
        if ($anoLectivo && $anoLectivo != 'Todos') {
            $Ralunos->where([['alunnos.vc_anoLectivo', $anoLectivo]]);
        }
        if ($curso && $curso != 'Todos') {
            $Ralunos->where([['alunnos.vc_nomeCurso', $curso]]);
        }
        return $Ralunos;
    }


    public  function Selecionados2Listas($anoLectivo, $curso)
    {
        $Ralunos = DB::table('candidato2s')
            ->where([['candidato2s.it_estado_aluno', 1]])
            ->orderby('vc_primeiroNome', 'asc')
            ->orderby('vc_nomedoMeio', 'asc')
            ->orderby('vc_ultimoaNome', 'asc');
        if ($anoLectivo && $anoLectivo != 'Todos') {
            $Ralunos->where([['candidato2s.vc_anoLectivo', $anoLectivo]]);
        }
        if ($curso && $curso != 'Todos') {
            $Ralunos->where([['candidato2s.vc_nomeCurso', $curso]]);
        }
        return $Ralunos;
    }
}

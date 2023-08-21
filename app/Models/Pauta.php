<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Pauta extends Model
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

    /* Alunos de uma turma */
    public  function AlunosforPauta($anoLectivo, $idTurma)
    {
        $estudantes = DB::table('matriculas')

            ->where([['matriculas.vc_anoLectivo', $anoLectivo]])
            ->where([['matriculas.it_idTurma', $idTurma]])
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->orderby('alunnos.vc_primeiroNome', 'asc')
            ->orderby('alunnos.vc_nomedoMeio', 'asc')
            ->orderby('alunnos.vc_ultimoaNome', 'asc')
            ->select(
                'alunnos.vc_primeiroNome',
                'alunnos.vc_nomedoMeio',
                'alunnos.vc_ultimoaNome',
                'alunnos.id',
                'alunnos.vc_genero',
                'alunnos.dt_dataNascimento',
            );

        return $estudantes;
    }

    /* Cabeçalho com o nome das disciplinas por cada turma para criar a pauta */
    public function HeaderNoteforPauta($vc_cursoTurma, $vc_classeTurma)
    {
        $cabecalhoNotas = DB::table('disciplinas_cursos_classes')

            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')

            //->where([['.vc_anolectivo', $vc_anoLectivo]])
            ->where([['cursos.vc_nomeCurso', $vc_cursoTurma]])
            ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])
            ->where([['classes.vc_classe', $vc_classeTurma]])

            ->orderby('disciplinas.vc_nome', 'asc')
            ->select(
                'disciplinas.vc_nome',
                'disciplinas_cursos_classes.id',
                'disciplinas.vc_acronimo'
            );
        return $cabecalhoNotas;
    }
}

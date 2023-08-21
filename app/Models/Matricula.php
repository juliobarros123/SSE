<?php


namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Matricula extends Model
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

    protected $fillable = [
        'id_cabecalho',
        'slug',
        'id',
        'id_aluno',
        'it_idTurma',
    ];

    public function alunos()
    {
        return $this->belongsTo(Alunno::class);
    }
    public function turmas()
    {
        return $this->belongsTo(Turma::class);
    }
    public function classes()
    {
        return $this->belongsTo(Classe::class);
    }
    public function cursos()
    {
        return $this->belongsTo(Curso::class);
    }


    public function StudentForCard($id)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->where([['alunnos.id', $id]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select('matriculas.vc_anoLectivo', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso', 'alunnos.vc_primeiroNome', 'alunnos.vc_ultimoaNome')
            ->get();
        return $estudantes;
    }
    public function processosAluno($processo)
    {
        $estudantes = DB::table('matriculas')
            ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
            ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
            ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->Join('anoslectivos', 'turmas.it_idAnoLectivo', '=', 'anoslectivos.id')
            ->where([['alunnos.id', $processo]])
            ->where([['matriculas.it_estado_matricula', 1]])
            ->select('matriculas.*', 'matriculas.vc_anoLectivo', 'turmas.vc_nomedaTurma', 'classes.vc_classe', 'cursos.vc_nomeCurso', 'alunnos.vc_primeiroNome', 'alunnos.vc_ultimoaNome', 'anoslectivos.ya_inicio', 'anoslectivos.ya_fim', 'matriculas.it_idTurma')
            ->orderBy('anoslectivos.ya_fim', 'desc')
        ;
        return $estudantes;
    }
}
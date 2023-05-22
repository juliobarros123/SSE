<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Melhor_Aluno extends Model
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
        'classe',
        'anoLectivo',
        'trimestre',
    ];

    public  function AlunoForShow($id_ano_lectivo, $classe, $trimestre)
    {

        $alunos = DB::table('notas')
            ->join('alunnos', 'alunnos.id', '=', 'notas.it_idAluno')
            ->join('matriculas', 'matriculas.it_idAluno', '=', 'alunnos.id')
            ->join('turmas', 'turmas.id', '=', 'matriculas.it_idTurma')
            ->join('cursos', 'cursos.id', 'matriculas.it_idCurso')
            ->join('classes', 'classes.id', '=', 'matriculas.it_idClasse')
            ->select('notas.fl_media', 'matriculas.vc_imagem', 'cursos.vc_nomeCurso', 'classes.vc_classe', 'turmas.vc_nomedaTurma', 'alunnos.vc_primeiroNome', 'alunnos.vc_nomedoMeio', 'alunnos.vc_ultimoaNome', 'alunnos.id','cursos.vc_shortName');

        if ($id_ano_lectivo) {
            $alunos->where([['notas.id_ano_lectivo', $id_ano_lectivo]]);
        }
        if ($classe) {
            $alunos->where([['classes.id', $classe]]);
        }
        if ($trimestre) {
            $alunos->where([['notas.vc_tipodaNota', $trimestre]]);
        }

        return $alunos->get();
    }
}

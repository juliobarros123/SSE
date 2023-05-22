<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TurmaUser extends Model
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
        'it_idTurma',
        'it_idUser',
        'it_idClasse',
        'it_idDisciplina',
        'it_estado_turma_user'
    ];

    protected $table = 'turmas_users';

    public function turmas()
    {
        return $this->belongsTo(Turma::class);
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }
    public function disciplinas()
    {
        return $this->belongsTo(Disciplinas::class);
    }
    public function classes()
    {
        return $this->belongsTo(Classe::class);
    }

    public  function turmasProfessor($curso,$classe)
    {

        $turmas = DB::table('turmas_users')->where([['turmas_users.it_estado_turma_user', 1],['turmas_users.it_idUser',Auth::user()->id]])
            //->distinct('turmas.id')
            ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
            ->join('users', 'turmas_users.it_idUser', '=', 'users.id')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
            //->distinct('turmas.id')
            ->select('users.*', 'turmas.*', 'classes.*', 'disciplinas.*', 'turmas_users.id');

            if ($curso) {
                $turmas->where('cursos.id', $curso);
            }
            if ($classe) {
                $turmas->where('classes.id', $classe);
            }


            //return $result->where('matriculas.it_estado', 1)->get();

            //$matriculas =  $this->matricula->relacaoMatricula(null, null);

        return $turmas->get();
    }
    public  function turmasCoodernador()
    {

        $turmas = DB::table('coordenador_cursos')
        ->join('cursos', 'coordenador_cursos.id_curso', '=', 'cursos.id')
        ->join('turmas', 'turmas.it_idCurso', '=', 'cursos.id')
        ->leftJoin('direitor_turmas','direitor_turmas.id_turma','turmas.id')
        ->leftJoin('users','direitor_turmas.id_user','users.id')
        ->where('coordenador_cursos.id_user',Auth::user()->id)
        ->select('users.*', 'turmas.*','turmas.id as id');

        // ->leftJoin('direitor_turmas','direitor_turmas.id_turma','turmas.id')
        // ->join('users','direitor_turmas.id_user','users.id')
        // ->where('coordenador_cursos.id_user',Auth::user()->id)
        // ->distinct();
            // ->select('users.*', 'turmas.*','coordenador_cursos.id as id');
          
            // ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            // ->leftJoin('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            // ->join('direitor_turmas','direitor_turmas.id_turma','turmas.id')
            // ->join('users','direitor_turmas.id_user','users.id')
            // ->select('users.*', 'turmas.*', 'turmas_users.id')
            
            // if ($curso) {
            //     $turmas->where('cursos.id', $curso);
            // }
            // if ($classe) {
            //     $turmas->where('classes.id', $classe);
            // }


            //return $result->where('matriculas.it_estado', 1)->get();

            //$matriculas =  $this->matricula->relacaoMatricula(null, null);
        return $turmas;
    }


}


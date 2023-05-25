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
use App\Models\Disciplina_Terminal;

class Turma extends Model
{
  protected $fillable = ['id_cabecalho','slug', 
   'vc_nomedaTurma',
    'it_qtdeAlunos',
    'it_qtMatriculados',
    'vc_turnoTurma',
    'it_idClasse',
    'it_idCurso',
    'it_idAnoLectivo',
    'it_estado_turma',
    'vc_salaTurma'
    
  ];
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
  public function cursos()
  {
    return $this->belongsTo('App\Models\Curso', 'cursos');
  }
  public function anos()
  {
    return  $this->belongsTo('App\Models\AnoLectivo', 'anoslectivos');
  }

  public function detalhes_turma($id_turma){
    $resul_set=   DB::table('turmas')
       ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
       ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
       ->Join('anoslectivos', 'turmas.it_idAnoLectivo', '=', 'anoslectivos.id')
       ->where('turmas.id',$id_turma)
       ->first();

       return  $resul_set;

   }
   public function professores($id_turma)
  {
    $response['atribuicoes'] = DB::table('turmas_users')
      ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
      ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
      ->where('users.vc_tipoUtilizador', '=', 'professor')
      ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
      ->distinct()
      ->select(
        'turmas_users.it_idUser',
        'turmas_users.id as ident',
        'users.vc_primemiroNome',
        'users.vc_apelido',
        'turmas.vc_nomedaTurma',
        'turmas.vc_classeTurma',
        'turmas.vc_cursoTurma',
        'turmas.vc_anoLectivo',
        'turmas.it_qtMatriculados',
        'turmas.it_qtdeAlunos',
        'turmas.id as id_turma',
        'disciplinas.id as id_disciplina',

        'disciplinas.vc_nome as disciplina'

      )
      ->where('turmas.id', $id_turma)
      ->where('users.vc_tipoUtilizador', '=', 'professor')->get();
    // dd(   $response['atribuicoes']);

    $response['disciplinas'] = DB::table('turmas_users')
      ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
      ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
      ->where('users.vc_tipoUtilizador', '=', 'professor')
      ->distinct()
      ->select(
        'turmas_users.it_idUser',
        'disciplinas.vc_nome as disciplina'
      )->get();
    return   $response;
  }
   public function alunos($id_turma)
   {

       $alunos = DB::table('matriculas')
           ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
           ->leftJoin('turmas', 'turmas.id', '=', 'matriculas.it_idTurma')
           ->orderby('alunnos.vc_primeiroNome', 'asc')
           ->orderby('alunnos.vc_nomedoMeio', 'asc')
           ->orderby('alunnos.vc_ultimoaNome', 'asc')
          //  ->where([['turmas.it_idAnoLectivo', $turma->it_idAnoLectivo]])
           ->where([['turmas.id', $id_turma]])
           ->distinct()
           ->select('alunnos.id','alunnos.id as id_aluno' ,'alunnos.vc_primeiroNome', 'alunnos.vc_nomedoMeio', 'alunnos.vc_ultimoaNome','alunnos.vc_genero')
           ->get();
       // dd(  $alunos);
       return $alunos;
   }


  public function turmas_users()
  {
    return $this->hasMany(TurmaUser::class);
  }
  public  function turmasDisciplinas($id_turma)
  {

    $turma=Turma::find($id_turma);

      $turmas = DB::table('turmas_users')
          ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
          ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
          ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
          ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
       
          ->where('turmas_users.it_idTurma',$id_turma)
          // ->where('disciplina__terminals.id_classe', $turma->it_idClasse)
          //->distinct('turmas.id')
          ->orderBy('disciplinas.id','asc')
          ->select( 'disciplinas.*','turmas.id as id_turma');
        
     
      return $turmas;
  }
  public function  disciplinas_terminas($id_turma){
    $turma=Turma::find($id_turma);

  $disciplinas_terminas = Disciplina_Terminal::join('classes', 'disciplina__terminals.id_classe', '=', 'classes.id')
    ->join('cursos', 'disciplina__terminals.it_idCurso', '=', 'cursos.id')
    ->join('disciplinas', 'disciplina__terminals.id_disciplina', '=', 'disciplinas.id')
    ->orderBy('disciplinas.id','asc')
    ->where('disciplina__terminals.it_estado',1)
    ->where('disciplina__terminals.id_classe', $turma->it_idClasse)
    ->where('disciplina__terminals.it_idCurso', $turma->it_idCurso)
    ->select( 'disciplinas.*','disciplina__terminals.id as id_disciplina_terminal');
   
  return  $disciplinas_terminas;
  
  }
}

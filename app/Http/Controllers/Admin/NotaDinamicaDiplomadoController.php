<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nota;
use App\Models\Disciplinas;
use App\Models\Classe;
use App\Models\Turma;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\TurmaUser;
use App\Models\Estudante;
use App\Models\PermissaoUnicaNota;
use App\Models\PermissaoNota;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Disciplina_Curso_Classe;


use Exception;
use Illuminate\Support\Facades\Redirect;

class NotaDinamicaDiplomadoController extends Controller
{
    //

    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function buscar_alunos(Estudante $estudantes)
    {
      
    $dados=$this->buscar_alunos_dados();
// dd( $dados);
        return view('admin.nota_em_carga_diplomado.buscar_alunos.index', $dados);
        // if($this->verificar_permissoes())
    // return view('admin.nota_em_carga_diplomado.buscar_alunos.index',$dados);
    // else
    // return redirect()->back()->with('semPermissoes', '1');
    }



    public function buscar_alunos_dados()
    {
        $dados['turmasUser']= $turmaUser=$this->turmasProfessor();
       
        $dados['permissoesNota']=PermissaoNota::all();
        $dados['disciplinas']=Disciplinas::where('it_estado_disciplina', 1)->get();
        $dados['classes']=Classe::where('it_estado_classe', 1)->get();
        $dados['turmas']=Turma::where('it_estado_turma', 1)->get();
        $dados['cursos']=Curso::where('it_estado_curso', 1)->get();
        $dados['anoActual']= AnoLectivo::orderby('id', 'desc')->first();
    
        return $dados;
        // if($this->verificar_permissoes())
    // return view('admin.nota_em_carga_diplomado.buscar_alunos.index',$dados);
    // else
    // return redirect()->back()->with('semPermissoes', '1');
    }

    public function verificar_permissoes()
    {
        $estado_permissoesNota=DB::table('permissao_notas')
    ->where('permissao_notas.vc_trimestre', '!=', 'T')
    ->where('permissao_notas.estado', '=', '1')
    ->count();

        return $estado_permissoesNota;
    }
    public function mostrar_alunos(Request $request)
    {

        

        $dados['turmasUser']= $turmaUser=$this->turmasProfessor();

        $dados['turmasUser'] =  $dados['turmasUser']->where('id_turma_user', $request->id_turma_user);
        $dados['turmasUser']->all();

       
        $turma_user= $dados['turmasUser'];
  
        foreach ($turma_user as $turma_user) {
            $id_turmaUser=$turma_user->id_turma_user;
            $it_idCurso=$turma_user->it_idCurso;
            $it_idClasse=$turma_user->it_idClasse;
            $it_idTurma=$turma_user->id_turma;
            $it_disciplina=$turma_user->id_disciplina;
            $id_anoLectivo=$request->id_anoLectivo;
            $vc_tipodaNota=$request->vc_tipodaNota;


            $detalhes['it_idCurso']=$turma_user->it_idCurso;
            $detalhes['it_idClasse']=$turma_user->it_idClasse;
            $detalhes['it_idTurma']=$turma_user->id_turma;
          
            $detalhes['it_disciplina']=$turma_user->id_disciplina ;
            $detalhes['id_anoLectivo']=$request->id_anoLectivo ;
            $detalhes['vc_tipodaNota']=$request->vc_tipodaNota ;
        }
  
  
        $ano_lectivo=$this->buscar_ano_lectivo($request->id_anoLectivo);
        $alunos3=$this->returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser);

        $alunos= $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);
     
        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);
     
        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }
     
        $alunos=   $this->filtrar_alunos($alunos3, $alunos);
       
//   dd(  $alunos);
        $detalhes['estados_de_notas_unica']= $this->buscar_notas_ativadas($vc_tipodaNota);
//   dd(  $detalhes['estados_de_notas_unica']);
        return view('admin.nota_em_carga_diplomado.mostrar_alunos.index', compact('alunos'), $detalhes);
    }

    public function filtrar_alunos($alunos_filtrado, $alunos)
    {
        $collection = collect();
        $m=collect();
        foreach ($alunos as $aluno) {
            $resultSet=$alunos_filtrado->where('id_aluno', $aluno->id_aluno);
 
            if ($resultSet->count()) {
                $collection->push($resultSet->min());
            } else {
                $collection->push($aluno);
                $collection->all();
            }
        }

        return $collection;
    }

    public function buscar_ano_lectivo($id_anoLectivo)
    {
        $ano_lectivo=AnoLectivo::find($id_anoLectivo);
        return $ano_lectivo->ya_inicio . '-' . $ano_lectivo->ya_fim;
    }

    public function buscar_notas_ativadas($vc_tipodaNota)
    {
        return DB::table('permissao_unica_notas')
    ->join('permissao_notas', 'permissao_unica_notas.id_permissao_notas', '=', 'permissao_notas.id')
   ->where('permissao_notas.vc_trimestre', $vc_tipodaNota)
   ->select('permissao_unica_notas.estado')
   ->get();
    }



    public function inserir(Request $request, $it_idCurso, $it_idClasse, $it_idTurma, $id_anoLectivo, $vc_tipodaNota, $it_disciplina)
    {
  


       $c= DB::table('disciplinas_cursos_classes')
        ->where('disciplinas_cursos_classes.it_disciplina', $it_disciplina)
        ->where('disciplinas_cursos_classes.it_curso', $it_idCurso)
        ->where('disciplinas_cursos_classes.it_classe', $it_idClasse)
        ->select('disciplinas_cursos_classes.id as id_d')->first();
       $it_disciplina=$c?$c->id_d:$it_disciplina;
       
        try{
        $dados=$request->all();
        $ids_alunos=collect();
        $vc_anoLectivo=$this->buscar_ano_lectivo($id_anoLectivo);
        $matriculas=$this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo);
    
        // $matriculas=$matriculas->where()
       
        foreach ($matriculas as $matricula) {
            $notas=   $this->filtrar_nota($dados, $matricula);
    
         
       
            $dados['id_aluno']=$matricula->it_idAluno?$matricula->it_idAluno:$matricula->id_aluno;

            $detalhes['id_aluno']=$dados['id_aluno'];
            $id_aluno=$matricula->it_idAluno;
            $detalhes['id_turma']=$it_idTurma;
            $detalhes['it_disciplina']=$it_disciplina ;
            $detalhes['vc_tipodaNota']=$vc_tipodaNota ;
            $detalhes['id_anoLectivo']=$id_anoLectivo ;
                
                     
            if (isset($notas['fl_nota1'])) {
                $estado_nota1=$this->vrf_valor_nota($notas['fl_nota1'], $detalhes, 1);
         
                if (!$estado_nota1) {
                    $notas2['fl_nota1']=$notas['fl_nota1'];
                } else {
                    $notas2['fl_nota1']=$estado;
                }
            } else {
                $estado_nota1=$this->vrf_valor_nota(null, $detalhes, 1);
         
                if (!$estado_nota1) {
                    $notas2['fl_nota1']=0;
                } else {
                    $notas2['fl_nota1']=$estado;
                }
            }


            if (isset($notas['fl_nota2'])) {
                $estado_nota2=$this->vrf_valor_nota($notas['fl_nota2'], $detalhes, 2);
                if (!$estado_nota2) {
                    $notas2['fl_nota2']=$notas['fl_nota2'];
                } else {
                    $notas2['fl_nota2']=$estado;
                }
            } else {
                $estado_nota2=$this->vrf_valor_nota(null, $detalhes, 2);
                if (!$estado_nota2) {
                    $notas2['fl_nota2']=0;
                } else {
                    $notas2['fl_nota2']=$estado;
                }
            }



            if (isset($notas['fl_mac'])) {
                $estado_mac=$this->vrf_valor_nota_mac($notas['fl_mac'], $detalhes);
                if (!$estado_mac) {
                    $notas2['fl_mac']=$notas['fl_mac'];
                } else {
                    $notas2['fl_mac']=$estado_mac;
                }
            } else {
                $estado_mac=$this->vrf_valor_nota_mac(null, $detalhes);
                if (!$estado_mac) {
                    $notas2['fl_mac']=0;
                } else {
                    $notas2['fl_mac']=$estado_mac;
                }
            }
      
            $turma=Turma::find($it_idTurma);

            $notas=$notas2;
          
            $mediana = (($notas['fl_nota1'] + $notas['fl_nota2'] + $notas['fl_mac']) / 3);

            $linha=Nota::where('id_classe', $it_idClasse)
          ->where('it_disciplina', $it_disciplina)
        ->where('id_turma', $it_idTurma)
          ->where('vc_tipodaNota', $vc_tipodaNota)
          
         ->where('id_aluno', $dados['id_aluno'])
      
          ->where('id_ano_lectivo', $id_anoLectivo)
           ->get();
         
            if (!$linha->count()) {
                Nota::create([
                          'id_classe' => $it_idClasse,
                          'it_disciplina' =>$it_disciplina,
                          'id_turma' => $it_idTurma,
                          'vc_tipodaNota' => $vc_tipodaNota,
                          'fl_nota1' =>round($notas['fl_nota1'], 0, PHP_ROUND_HALF_UP) ,
                          'fl_nota2' => round($notas['fl_nota2'], 0, PHP_ROUND_HALF_UP),
                          'fl_mac' => round($notas['fl_mac'], 0, PHP_ROUND_HALF_UP),
                          'id_aluno' => $dados['id_aluno'],
                          'fl_media' => round($mediana, 0, PHP_ROUND_HALF_UP),
                          'id_ano_lectivo' => $id_anoLectivo,
                            ]);
            } else {
                Nota::where('id', $linha['0']->id)->update([
                                'id_classe' => $it_idClasse,
                                'it_disciplina' =>$it_disciplina,
                                'id_turma' => $it_idTurma,
                                'vc_tipodaNota' => $vc_tipodaNota,
                                'fl_nota1' => round($notas['fl_nota1'], 0, PHP_ROUND_HALF_UP),
                                'fl_nota2' =>  round($notas['fl_nota2'], 0, PHP_ROUND_HALF_UP),
                                'fl_mac' => round($notas['fl_mac'], 0, PHP_ROUND_HALF_UP),
                                'id_aluno' => $dados['id_aluno'],
                                'fl_media' =>round( $mediana, 0, PHP_ROUND_HALF_UP),
                                'id_ano_lectivo' => $id_anoLectivo,
                                ]);
            }
                           
            // } else {
                    //     return redirect('nota_em_carga_diplomado/buscar_alunos/')->with('ExisteNota', '1');
                    // }
        //         } else {
                
        //      // return  redirect('nota_em_carga_diplomado/buscar_alunos/')->with('notaIncompleta', '1');
        //         }
        //     } else {
        //         return redirect('nota_em_carga_diplomado/buscar_alunos/')->with('semNotas', '1');
        //     }
        // } else{
        //  $ids_alunos->add($matricula->it_idAluno);
        //  $ids_alunos->all();
        

     
        // }
       
        //    if($ids_alunos->count()>0){
        //     return  redirect('nota_em_carga_diplomado/buscar_alunos/')->with('notaIncompleta', '1');
        //    }else{
        //     $this->Logger->Log('info', 'Adicionou Nota');
        //     return redirect('nota_em_carga_diplomado/buscar_alunos/')->with('status', '1');
        //    }
        }
        $result=Disciplina_Curso_Classe::find($it_disciplina);
        return redirect('admin/pautas/mini/disciplina/'.$it_idTurma.'/'.$vc_tipodaNota.'/'. $result->it_disciplina);

        $this->Logger->Log('info', 'Adicionou Nota');
        return redirect('nota_em_carga_diplomado/buscar_alunos/')->with('status', '1');
    
      }catch(Exception $ex){
    //       dd($it_disciplina);
    //  dd( $ex);
        return redirect('nota_em_carga_diplomado/buscar_alunos')->with('error', '1');

       }
    }


    public function vrf_valor_nota($nota, $detalhes, $cont)
    {
        $notas= DB::table('notas')
             ->where('id_ano_lectivo', $detalhes['id_anoLectivo'])
             ->where('id_turma', $detalhes['id_turma'])
             ->where('id_aluno', $detalhes['id_aluno'])
             ->where('vc_tipodaNota', $detalhes['vc_tipodaNota'])
             ->where('it_disciplina', $detalhes['it_disciplina'])
             ->where('fl_nota'.$cont, '==', 0.00)
            ->get();
        if ($notas==null) {
            return 0;
        } elseif (isset($notas['fl_nota'.$cont])) {
            return $notas['fl_nota'.$cont];
        }
    }
  

    public function vrf_valor_nota_mac($nota, $detalhes)
    {
        $notas= DB::table('notas')
                 ->where('id_ano_lectivo', $detalhes['id_anoLectivo'])
                 ->where('id_turma', $detalhes['id_turma'])
                 ->where('id_aluno', $detalhes['id_aluno'])
                 ->where('vc_tipodaNota', $detalhes['vc_tipodaNota'])
                 ->where('it_disciplina', $detalhes['it_disciplina'])
                 ->where('fl_mac', '==', 0.00)
                ->get();
        if ($notas==null) {
            return 0;
        } elseif (isset($notas['fl_mac'])) {
            return $notas['fl_mac'];
        }
    }
      
    public function insert($nota, $detalhes)
    {

    }





    public function returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo, $vc_tipodaNota, $id_turmaUser)
    {
    
        $dados['turmasUser']= $turmaUser=$this->turmasProfessor();
        $dados['turmasUser'] =  $dados['turmasUser']->where('id_turma_user', $id_turmaUser)->min();
   
        //  dd(  $dados['turmasUser']);
        $resultSet= DB::table('matriculas')
         ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
         ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
         ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
         ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
         ->join('turmas_users', 'turmas_users.it_idTurma', '=', 'turmas.id')
       
         ->leftJoin('notas', 'notas.it_idAluno', '=', 'alunnos.id')
         ->leftJoin('anoslectivos', 'notas.id_ano_lectivo', '=', 'anoslectivos.id')
         ->join('disciplinas_cursos_classes', 'disciplinas_cursos_classes.id', '=', 'notas.id_disciplina_curso_classe')
         ->join('disciplinas', 'disciplinas.id', '=', 'disciplinas_cursos_classes.it_disciplina')
         ->orderby('alunnos.vc_primeiroNome', 'asc')
         ->orderby('alunnos.vc_nomedoMeio', 'asc')
         ->orderby('alunnos.vc_ultimoaNome', 'asc')
         ->where([['matriculas.it_idCurso', $it_idCurso]])
         ->where([['matriculas.it_idClasse', $it_idClasse]])
         ->where([['matriculas.it_idTurma', $it_idTurma]])
         ->where([['matriculas.vc_anoLectivo', $vc_anoLectivo]])
         ->where([['matriculas.it_estado_matricula', 1]])
         ->where([['notas.vc_tipodaNota',  $vc_tipodaNota]])
         ->where([['turmas_users.id', $id_turmaUser]])
        //  ->where([['disciplinas.vc_nome', $dados['turmasUser']->vc_nome]])
        // ->select('matriculas.*', 'turmas.*', 'classes.*', 'cursos.*', 'alunnos.*', 'matriculas.id as id_matricula', 'matriculas.it_idAluno as id_aluno', 'turmas_users.id as id_tu', 'disciplinas.vc_nome', 'notas.*','anoslectivos.*')
         ->distinct()->get();
        //  dd($resultSet);
        // dd($resultSet);
         return $resultSet;
    }

    public function returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $vc_anoLectivo)
    {
        return DB::table('matriculas')
    ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
    ->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')
    ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
    ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')
    ->orderby('alunnos.vc_primeiroNome', 'asc')
    ->orderby('alunnos.vc_nomedoMeio', 'asc')
    ->orderby('alunnos.vc_ultimoaNome', 'asc')
    ->where([['matriculas.it_idCurso', $it_idCurso]])
    ->where([['matriculas.it_idClasse', $it_idClasse]])
    ->where([['matriculas.it_idTurma', $it_idTurma]])
    ->where([['matriculas.vc_anoLectivo', $vc_anoLectivo]])
    ->where([['matriculas.it_estado_matricula', 1]])
    ->select('matriculas.*', 'turmas.*', 'classes.*', 'cursos.*', 'alunnos.*', 'matriculas.id as id_matricula', 'matriculas.it_idAluno as id_aluno')
    ->get();
    }



public function dados_turma_professor(){
    return DB::table('turmas_users')
    ->join('turmas', 'turmas_users.it_idTurma', '=', 'turmas.id')
    ->join('users', 'turmas_users.it_idUser', '=', 'users.id')
    ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
    ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
    ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id');
}

    public function turmasProfessor()
    {
        $resultSet=collect();
       
     if(Auth::user()->vc_tipoUtilizador!='Administrador' && Auth::user()->vc_tipoUtilizador!='Director Geral'){
    
        $resultSet=   $this->dados_turma_professor()->where([['turmas_users.it_estado_turma_user', 1],['turmas_users.it_idUser',Auth::Id()]])
        ->select('users.*', 'turmas.*', 'classes.*', 'disciplinas.*', 'disciplinas.id as id_disciplina', 'turmas_users.id as id_turma_user', 'cursos.*', 'turmas.id as id_turma')->get();
 
    }else{
     
        $resultSet= $this->dados_turma_professor()->where([['turmas_users.it_estado_turma_user', 1]])
        ->select('users.*', 'turmas.*', 'classes.*', 'disciplinas.*', 'disciplinas.id as id_disciplina', 'turmas_users.id as id_turma_user', 'cursos.*', 'turmas.id as id_turma')->get();
     }
     return $resultSet;
      
    }
 
    public function filtrar_nota($dados, $matricula)
    {
        $notas=array();
   
        if (isset($dados['fl_nota1_'.$matricula->id_aluno])) {
            $notas['fl_nota1'] =$dados['fl_nota1_'.$matricula->id_aluno];
        }
        if (isset($dados['fl_nota2_'.$matricula->id_aluno])) {
            $notas['fl_nota2'] =$dados['fl_nota2_'.$matricula->id_aluno];
        }
        if (isset($dados['fl_mac_'.$matricula->id_aluno])) {
            $notas['fl_mac'] =$dados['fl_mac_'.$matricula->id_aluno];
        }

  
        return $notas;
      
        //   }/ }else if(count($notas)==0 || count($notas)<3){
//     //      return count($notas);
//     // }
    }



    public function pesquisar(Nota $disciplina)
    {

        $dados['turmasUser']= $turmaUser=$this->turmasProfessor();
       
        $dados['permissoesNota']=PermissaoNota::all();
        $dados['disciplinas']=Disciplinas::where('it_estado_disciplina', 1)->get();
        $dados['classes']=Classe::where('it_estado_classe', 1)->get();
        $dados['turmas']=Turma::where('it_estado_turma', 1)->get();
        $dados['cursos']=Curso::where('it_estado_curso', 1)->get();
        $dados['anoActual']= AnoLectivo::orderby('id', 'desc')->first();
       
        // $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        // $response['disciplinas'] = $disciplina->RDisciplinasJoins();
   
        // $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        // $response['trimestres'] = Nota::where([['it_estado_nota', 1]])->get();
        // /* Trás as turmas do ano lectivo actual */
        // $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        // $response['turmas'] = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        return view('admin.nota_em_carga_diplomado.pesquisar.index', $dados);
    }



    public function ver(Request $request)
    {

        
        $dados['turmasUser']= $turmaUser=$this->turmasProfessor();

        $dados['turmasUser'] =  $dados['turmasUser']->where('id_turma_user', $request->id_turma_user);
        $dados['turmasUser']->all();

       
        $turma_user= $dados['turmasUser'];
  
        foreach ($turma_user as $turma_user) {
            $id_turmaUser=$turma_user->id_turma_user;
            $it_idCurso=$turma_user->it_idCurso;
            $it_idClasse=$turma_user->it_idClasse;
            $it_idTurma=$turma_user->id_turma;
            $it_disciplina=$turma_user->id_disciplina;
            $id_anoLectivo=$request->id_anoLectivo;
            $vc_tipodaNota=$request->vc_tipodaNota;


            $detalhes['it_idCurso']=$turma_user->it_idCurso;
            $detalhes['it_idClasse']=$turma_user->it_idClasse;
            $detalhes['it_idTurma']=$turma_user->id_turma;
          
            $detalhes['it_disciplina']=$turma_user->id_disciplina ;
            $detalhes['id_anoLectivo']=$request->id_anoLectivo ;
            $detalhes['vc_tipodaNota']=$request->vc_tipodaNota ;
        }
  
  
        $ano_lectivo=$this->buscar_ano_lectivo($id_anoLectivo);
      
        $detalhes['notas']=$this->notas($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser,$request->id_anoLectivo);

        // $alunos= $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);
      
        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);
     
        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }
     
        

        $detalhes['estados_de_notas_unica']= $this->buscar_notas_ativadas($vc_tipodaNota);
      
        return view('admin.nota_em_carga_diplomado.index',   $detalhes);
    }

    public function notas($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser,$id_anoLectivo){
        $alunos3=$this->returnar_alunos_com_tri($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo, $vc_tipodaNota, $id_turmaUser);

        // $alunos= $this->returnar_alunos($it_idCurso, $it_idClasse, $it_idTurma, $ano_lectivo);
      
        // $alunos1=$alunos->where('vc_tipodaNota', $vc_tipodaNota);
     
        // if ($alunos1->count()) {
        //     $alunos=$alunos1;
        // } else {
        //     $alunos=$alunos3;
        // }
     
        $detalhes['notas']=   $this->filtrar_alunos($alunos3,  $alunos3);
        
        return  $detalhes['notas'];
    }
}

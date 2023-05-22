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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Disciplinas;
use Illuminate\Support\Facades\DB as FacadesDB;
use App\Models\Logger;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class DisciplinasController extends Controller
{
  private $Logger;
  public function __construct()
  {
    $this->Logger = new Logger();
  }
  public function loggerData($mensagem){
    $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
    $this->Logger->Log('info', $dados_Auth.$mensagem);
}
  public function index()
  {

    $response['desd'] = FacadesDB::table('turmas_users')
      ->join('disciplinas', 'disciplinas.id', '=', 'turmas_users.it_idDisciplina')
      ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
      ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
      ->select('disciplinas.id', 'turmas.vc_cursoTurma', 'turmas.vc_classeTurma', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo')
      ->where('turmas_users.it_idUser', Auth::user()->id)->distinct()
      ->get();

    $response['disciplinas'] = Disciplinas::where([['it_estado_disciplina', 1]])->get();
    return view('admin.disciplinas.index', $response);
  }



  public function create()
  {
    return view('admin.disciplinas.cadastrar.index');
  }

  public function store(Request $request)
  {
    $disciplinas = Disciplinas::where('vc_acronimo', '=',  $request->vc_acronimo)->first();

    //if($disciplinas === null){
      try {
        Disciplinas::create([
            'vc_nome' => $request->vc_nome,
            'vc_acronimo' => $request->vc_acronimo

          ]);

          

        }
        catch (QueryException $th) {
            return redirect()->back()->with("disciplina","1");

        }
    //}else{
       // return redirect()->back()->with("disciplina","1");

   // }



    $this->loggerData('Adicionou Uma Disciplina');
    return redirect('/disciplina/ver')->with('status', '1');
  }

  public function edit($id)
  {
    if ($disciplina = Disciplinas::find($id)) :

      return view('admin.disciplinas.editar.index', compact('disciplina'));
    else :
      return redirect('/disciplina')->with('disciplina', '1');

    endif;
  }

  public function update(Request $request, $id)
  {

      try {
        Disciplinas::find($id)->update([
          'vc_nome' => $request->vc_nome,
          'vc_acronimo' => $request->vc_acronimo
        ]);

      }
      catch (QueryException $th) {
          return redirect()->back()->with("disciplina","1");

      }
      $this->loggerData('Actualizou Uma Disciplina');
      return redirect()->route('admin.disciplinas.index');
  }

  public function delete($id)
  {
    $response = Disciplinas::find($id);
    $response->update(['it_estado_disciplina' => 0]);

    $this->loggerData('Eliminou Uma Disciplina');
    return redirect()->back()->with('feedback', ['status'=>'1','sms'=>'Disciplina eliminada com sucesso']);
  }
  public function eliminadas(){
    $response['disciplinas']  = Disciplinas::where('it_estado_disciplina',0)->get();
    $response['eliminadas']="eliminadas";
    
    return view('admin.disciplinas.index', $response);
 
  }
  public function recuperar($id){
    $response = Disciplinas::find($id);
    $response->update(['it_estado_disciplina' => 1]);
    $this->loggerData('Recuperou Uma Disciplina');
    return redirect()->back()->with('feedback', ['status'=>'1','sms'=>'Disciplina recuperada com sucesso']);
    return redirect()->back();
  }
  public function purgar($id){
    // dd($id);
    try{
      $response = Disciplinas::find($id)->delete();
      $this->loggerData('Purgou Uma Disciplina');
      return redirect()->back()->with('feedback', ['status'=>'1','sms'=>'Disciplina purgada com sucesso']);
      // return redirect()->back();
    }catch(Exception $ex){
      return redirect()->back()->with('feedback', ['error'=>'1','sms'=>'Erro,possivelmente essa disciplina está relacionada com curso e classe']);
    }
    
  }
}

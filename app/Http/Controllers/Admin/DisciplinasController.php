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
  public function loggerData($mensagem)
  {
    $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
    $this->Logger->Log('info', $dados_Auth . $mensagem);
  }
  public function index()
  {

    // $response['desd'] = FacadesDB::table('turmas_users')
    //   ->join('disciplinas', 'disciplinas.id', '=', 'turmas_users.it_idDisciplina')
    //   ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
    //   ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
    //   ->select('disciplinas.id', 'turmas.vc_cursoTurma', 'turmas.vc_classeTurma', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo')
    //   ->where('turmas_users.it_idUser', Auth::user()->id)->distinct()
    //   ->get();

    $response['disciplinas'] = fh_disciplinas()->get();
    // dd( $response['disciplinas']);
    return view('admin.disciplinas.index', $response);
  }



  public function create()
  {
    return view('admin.disciplinas.cadastrar.index');
  }

  public function store(Request $request)
  {
 
    try {
      $d = Disciplinas::where('vc_nome', $request->vc_nome)
        ->where('id_cabecalho', Auth::User()->id_cabecalho)->count();
      if ($d) {
        return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Disciplina  já existe']);
      } else {
        Disciplinas::create([
          'vc_nome' => $request->vc_nome,
          'vc_acronimo' => $request->vc_acronimo,
          'id_cabecalho'=>Auth::User()->id_cabecalho

        ]);
        $this->loggerData('Adicionou disciplina com o nome ' . $request->vc_nome);
        return redirect()->route('admin.disciplinas.index')->with('feedback', ['type' => 'success', 'sms' => 'Disciplina cadastrada com sucesso']);

      }

    } catch (QueryException $th) {
      // dd($th);
      return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


    }

  }

  public function edit($slug)
  {
$disciplina=fh_disciplinas()->where('disciplinas.slug',$slug)->first();
// dd($disciplina);
    if ($disciplina):

      return view('admin.disciplinas.editar.index', compact('disciplina'));
    else:
      return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


    endif;
  }

  public function update(Request $request, $slug)
  {

    try {
      Disciplinas::where('disciplinas.slug',$slug)->update([
        'vc_nome' => $request->vc_nome,
        'vc_acronimo' => $request->vc_acronimo
      ]);
      $this->loggerData('Actualizou  disciplina com o nome',$request->vc_nome);
      return redirect()->route('admin.disciplinas.index')->with('feedback', ['type' => 'success', 'sms' => 'Disciplina actualizada com sucesso']);

    } catch (QueryException $th) {
      return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);

    }
  

  }

  public function delete($slug)
  {
    $response = Disciplinas::where('disciplinas.slug',$slug)->first();
    Disciplinas::where('disciplinas.slug',$slug)->delete();
    $this->loggerData('Eliminou  Disciplina com o nome ', $response->vc_nome);
    return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Disciplina eliminada com sucesso']);
  }

  
}
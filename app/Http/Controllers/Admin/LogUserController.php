<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LogUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Auth;

class LogUserController extends Controller
{

  public function loggerData($mensagem)
  {
    $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
    $this->Logger->Log('info', $dados_Auth . $mensagem);
  }
  public function pesquisar()
  {

    $response['anos'] = $response['logs'] = fh_logs_anos()->get();

    $response['utilizadores'] = $response['logs'] = fh_users_logs()->get();
    // dd(  $response['utilizadores']);
    return view('admin/logs/pesquisar/index', $response);
  }
  public function recebelogs(Request $request)
  {
 
    if (session()->get('filtro_logs')) {
      if (!$request->ano) {
        $filtro_logs = session()->get('filtro_logs');
        $request->ano = $filtro_logs['ano'];
      }
      if (!$request->id_user) {
        $filtro_logs = session()->get('filtro_logs');
        $request->id_user = $filtro_logs['id_user'];
      }
    }

    $logs = fh_users_logs()->select('logs.*', 'users.vc_primemiroNome', 'users.vc_apelido');

    if ($request->ano != 'Todos' && $request->ano) {
      $logs = $logs->whereYear('logs.created_at', '=', $request->ano);
    }

    if ($request->id_user != 'Todos' && $request->id_user) {
      // dd(   $logs->get(),$request->id_user);
      $logs = $logs->where('users.id', $request->id_user);
    }
    $data = [
      'id_user' => $request->id_user,
      'ano' => $request->ano
    ];
    storeSession('filtro_logs', $data);
     $response['logs'] = $logs->get();

    return view('admin/logs/visualizar/index', $response);

  }

}
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\CoordenadorTurno;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CoordenadorTurnoController extends Controller
{
    //
    private $coordenador_turno;
    public function __construct()
    {
        $this->coordenador_turno = new CoordenadorTurno();

    }

    public function index()
    {
        $coordenadores_turno = $this->coordenador_turno->todos();
        $coordenadores_turno_filtrado = $this->filtrar_por_utilizador($coordenadores_turno);
        $coordenadores_turno = $coordenadores_turno_filtrado->get();

        // dd( $coordenadores_turno);
        // dd( $coordenadores_turno);
        return view('admin.coordenador_turno.index', compact('coordenadores_turno'));
    }
    public function criar()
{
        $usuarios = User::orderby('vc_primemiroNome', 'asc')->orderby('vc_apelido', 'asc')->get();
        $anoslectivos = AnoLectivo::where('it_estado_anoLectivo', 1)->get();
        return view('admin.coordenador_turno.criar.index', compact('usuarios'), compact('anoslectivos'));
    }
    public function cadastrar(Request $dados)
    {
        $registro = $this->coordenador_turno->tem_registro($dados);
   
        if (!$registro) {
            CoordenadorTurno::create($dados->all());
            return redirect()->route('coordernadores_turno')->with('cadastrado', '1');
        } else {
            return redirect()->route('coordernadores_turno')->with('error', '1');
        }

    }
    public function editar($id)
    {
        $response['coordenador_turno'] = $this->coordenador_turno->todos()->where('coordenador_turnos.id', $id)->first();

        $response['usuarios'] = User::all();
        $response['anoslectivos'] = AnoLectivo::where('it_estado_anoLectivo', 1)->get();
        return view('admin.coordenador_turno.editar.index', $response);
    }
    public function actualizar(Request $dados, $id)
    {
        CoordenadorTurno::find($id)->update($dados->all());
        return redirect()->route('coordernadores_turno')->with('actualizado', '1');
    }
    public function eliminar($id)
    {
        CoordenadorTurno::find($id)->update([
            'estado_coordenador_turno' => 0,
        ]);
        return redirect()->route('coordernadores_turno')->with('eliminado', '1');
    }
    public function filtrar_por_utilizador($coordenadores_turno)
    {
  
     if( Auth::user()->vc_tipoUtilizador == 'Professor'){
      $coordenadores_turno=$coordenadores_turno->join('turmas', 'turmas.vc_turnoTurma', '=', 'coordenador_turnos.turno')
      ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
      ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
      ->join('turmas_users', 'turmas_users.it_idTurma', '=', 'turmas.id')
      ->where('turmas_users.it_idUser',Auth::user()->id)
      ->distinct()
      ->select(
        'coordenador_turnos.*',
        'users.vc_primemiroNome',
        'users.vc_apelido',
        'anoslectivos.ya_inicio',
        'anoslectivos.ya_fim');
     }
    
      return $coordenadores_turno->distinct();
     
      
          
       
    }

}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Componente;

use function GuzzleHttp\Promise\all;

class ComponenteController extends Controller
{
    //
    private $componente;
    public function __construct()
    {
        $this->componente = new Componente();
    }

    public function index()
    {
        $response['componentes'] = Componente::all();
        return view('admin.documentos.componente.index',  $response);
    }
    public function criar()
    {

        return view('admin.documentos.componente.criar.index');
    }
    public function cadastrar(Request $dados)
    {
        $registro = $this->componente->tem_registro($dados);

        if (!$registro) {
            Componente::create($dados->all());
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Componente cadastrada com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Componente já existe!']);

        }
    }
    public function editar($id)
    {
        $response['componente'] = Componente::find($id);
        return view('admin.documentos.componente.editar.index', $response);
    }
    public function actualizar(Request $dados, $id)
    {
        $registro = $this->componente->tem_registro($dados);
      
        if (!$registro) {
            Componente::find($id)->update($dados->all());
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Componente actualizado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Componente já existe!']);

        }
       

    }
    public function eliminar($id)
    {
        Componente::find($id)->delete();
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Componente eliminado com sucesso!']);

    }








    //
}

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
        $response['componentes'] = fh_componentes()->get();
        return view('admin.documentos.componente.index', $response);
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
            return redirect()->route('admin.documentos.componentes')->with('feedback', ['type' => 'success', 'sms' => 'Componente cadastrada com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Componente já existe!']);

        }
    }
    public function editar($slug)
    {
        $response['componente'] = fh_componentes()->where('componentes.slug', $slug)->first();

        if ($response['componente']):
            return view('admin.documentos.componente.editar.index', $response);

        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);



        endif;
    }
    public function actualizar(Request $dados, $slug)
    {
        $registro = $this->componente->tem_registro($dados);
        // dd("ola");
        if (!$registro) {
            $dados = $dados->except(['_token', '_method']);
            Componente::where('componentes.slug', $slug)->update($dados);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Componente actualizado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Componente já existe!']);

        }


    }
    public function eliminar($slug)
    {
        $response['componente'] = fh_componentes()->where('componentes.slug', $slug)->first();
        if ( $response['componente']) {
            Componente::where('componentes.slug', $slug)->delete();
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Componente eliminado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Componente já existe!']);



        }
    }







    //
}
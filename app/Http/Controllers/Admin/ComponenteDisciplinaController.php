<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ComponenteDisciplina;
class ComponenteDisciplinaController extends Controller
{
    //
    //
    private $componente_disciplina;
    public function __construct()
    {
        $this->componente_disciplina = new ComponenteDisciplina();
    }

    public function index()
    {
        $response['componente_disciplinas'] = componentes_disciplinas()->get();
        return view('admin.documentos.componente-disciplina.index',  $response);
    }
    public function criar()
    {
        return view('admin.documentos.componente-disciplina.criar.index');
    }
    public function cadastrar(Request $dados)
    {
        $registro = $this->componente_disciplina->tem_registro($dados);
        if (!$registro) {
            ComponenteDisciplina::create($dados->all());
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Vínculo cadastrada com sucesso!']);
        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Vínculo já existe!']);

        }
    }
    public function editar($id)
    {
        $response['componente_disciplina'] = componentes_disciplinas()->find($id);
        return view('admin.documentos.componente-disciplina.editar.index', $response);
    }
    public function actualizar(Request $dados, $id)
    {
        // dd("ola");
        $registro = $this->componente_disciplina->tem_registro($dados);
      
        if (!$registro) {
            ComponenteDisciplina::find($id)->update($dados->all());
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Vínculo actualizado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Vínculo já existe!']);

        }
       

    }
    public function eliminar($id)
    {
        ComponenteDisciplina::find($id)->delete();
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Vínculo eliminado com sucesso!']);

    }


}

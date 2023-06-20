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
        $response['componente_disciplinas'] = fh_componentes_disciplinas()->get();
        return view('admin.documentos.componente-disciplina.index', $response);
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
            return redirect()->route('admin.documentos.componentes-disciplinas')->with('feedback', ['type' => 'success', 'sms' => 'Vínculo cadastrada com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Vínculo já existe!']);

        }
    }
    public function editar($slug)
    {
        $response['componente_disciplina'] = fh_componentes_disciplinas()->where('componente_disciplinas.slug', $slug)->first();

        if ($response['componente_disciplina']):
            return view('admin.documentos.componente-disciplina.editar.index', $response);


        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);



        endif;
    }
    public function actualizar(Request $dados, $slug)
    {
        // dd("ola");
        $registro = $this->componente_disciplina->tem_registro($dados);

        if (!$registro) {
            $dados = $dados->except(['_token', '_method']);
            ComponenteDisciplina::where('componente_disciplinas.slug', $slug)->update($dados);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Vínculo actualizado com sucesso!']);

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Vínculo já existe!']);

        }


    }
    public function eliminar($slug)
    {
        $response['componente_disciplina'] = fh_componentes_disciplinas()->where('componente_disciplinas.slug', $slug)->first();
        if ($response['componente_disciplina']):
            ComponenteDisciplina::where('componente_disciplinas.slug', $slug)->delete();
            return view('admin.documentos.componente-disciplina.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);
        endif;
    }


}
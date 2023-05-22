<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CaminhoFicheiro;
class CaminhoFicheiroController extends Controller
{
    //

    public function criar()
    {
    
      return  view('admin.caminho-ficheiro.cadastrar.index');
    }
    public function cadastrar(request $req)
    {
      try {
        CaminhoFicheiro::create($req->all());
  
        return redirect()->route('caminho-files')->with("cadastrada", '1');
      } catch (\Throwable $th) {
      
        return redirect()->back()->with("erro_geral", '1');
      }
    }
    
    public function index()
    {
    
      $dados['caminhos'] = CaminhoFicheiro::all();
      return view('admin.caminho-ficheiro.index', $dados);
    }
  
    public function actualizar(Request $req,$id)
    {
      try {
        // dd($req->all());
        CaminhoFicheiro::find($id)->update([
          "vc_caminho" => $req->vc_caminho,
        ]);
  
        return redirect()->route('caminho-files')->with("editada", '1');
      } catch (\Throwable $th) {
        return redirect()->back()->with("classe.editar.false", '1');
      }
    }
    public function editar($id)
    {

      $dados['caminho'] = CaminhoFicheiro::find($id);
     
      $dados['id']=$id;
      return view('admin.caminho-ficheiro.editar.index', $dados);
    }
    public function eliminar($id)
    {
  
   /*    Classe::where('id', $id)->update(
        [
          'it_estado' => 0
        ]
      ); */

      CaminhoFicheiro::find($id)->delete();
      return redirect()->route('caminho-files')->with("eliminado", '1');
    }
  
    public function purgar($id)
    {

        CaminhoFicheiro::find($id)->forceDelete();
      return redirect()->route('caminho-files')->with("url.eliminar.true", '1');
    }
}

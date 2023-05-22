<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\URLEstatistica;

class URLEstatisticaController extends Controller
{
 
    public function criar()
    {
        
      return  view('admin.url_estatistica.cadastrar.index');
    }
    public function cadastrar(request $req)
    {
      try {
        URLEstatistica::create($req->all());
  
        return redirect()->route('api.url_estatistica.url')->with("cadastrada", '1');
      } catch (\Throwable $th) {
      
        return redirect()->back()->with("erro_geral", '1');
      }
    }
    
    public function index()
    {

      $dados['URLs'] = URLEstatistica::all();
      return view('admin.url_estatistica.index', $dados);
    }
  
    public function actualizar(Request $req,$id)
    {
      try {
        URLEstatistica::find($id)->update([
          "url" => $req->url,
        ]);
  
        return redirect()->route('api.url_estatistica.url')->with("editada", '1');
      } catch (\Throwable $th) {
        return redirect()->back()->with("classe.editar.false", '1');
      }
    }
    public function editar($id)
    {

      $dados['url'] = URLEstatistica::find($id);
      $dados['id']=$id;
      return view('admin.url_estatistica.editar.index', $dados);
    }
    public function eliminar($id)
    {
  
   /*    Classe::where('id', $id)->update(
        [
          'it_estado' => 0
        ]
      ); */

      URLEstatistica::find($id)->delete();
      return redirect()->route('api.url_estatistica.url')->with("eliminado", '1');
    }
  
    public function purgar($id)
    {

        URLEstatistica::find($id)->forceDelete();
      return redirect()->route('api.url_estatistica.url')->with("url.eliminar.true", '1');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoValidadeCartao;
class AnoValidadeCartaoController extends Controller
{
    //
    public function criar(){
        
        return view('admin.anoValidadeCartao.criar.index');
     }
     public function cadastrar(Request $req){
        // dd($req);
        AnoValidadeCartao::create($req->all());
        return redirect()->route('anos-validade-cartao')->with('status',1);
     }
    public function index(){
       $response['anos']= AnoValidadeCartao::all();
       return view('admin.anoValidadeCartao.index',  $response);
    }
    public function eliminar($id){
        AnoValidadeCartao::find($id)->delete();
        return redirect()->route('anos-validade-cartao')->with('eliminado',1);
    }
}

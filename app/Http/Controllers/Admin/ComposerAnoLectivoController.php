<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;
class ComposerAnoLectivoController extends Controller
{
    //
    public $anoLectivoComposer;
    public  $view;
   
    public function disponibilizar(Request $ano_lectivo,$id){
      $ano_lectivo=  AnoLectivo::find($id);
   $anoLectivoPublicado=   AnoLectivoPublicado::all();
    if($anoLectivoPublicado->count()==0){
        AnoLectivoPublicado::create([
            'id_anoLectivo'=>$ano_lectivo->id,
            'ya_inicio'=>$ano_lectivo->ya_inicio, 
            'ya_fim'=>$ano_lectivo->ya_fim
        ]
        );
    }else{
        AnoLectivoPublicado::find(1)->update([
            'id_anoLectivo'=>$ano_lectivo->id,
            'ya_inicio'=>$ano_lectivo->ya_inicio, 
            'ya_fim'=>$ano_lectivo->ya_fim
        ]
        ); 
    }
       
        return redirect()->back();
    }


    public function ocultar(Request $ano_lectivo,$id){

        AnoLectivoPublicado::truncate();
        // session()->forget('ano_lectivo');
        return redirect()->back();
    }

    public function createSession($ano_lectivo,$id){
        $anoLectivo= AnoLectivo::find($id);
        $ano_lectivo->session()->put('ano_lectivo', [['id'=> $id,'ano_lectivo'=>$anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim]]);
   
    }
}

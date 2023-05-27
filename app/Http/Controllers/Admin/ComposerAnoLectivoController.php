<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;

use Illuminate\Support\Facades\Auth;

class ComposerAnoLectivoController extends Controller
{
    //
    public $anoLectivoComposer;
    public $view;

    public function disponibilizar(Request $ano_lectivo, $slug)
    {
        // dd($slug);
        $ano_lectivo = fh_anos_lectivos()->where('anoslectivos.slug', $slug)->first();
        // dd($ano_lectivo );
        $ano_lectivo_publicado = fha_ano_lectivo_publicado();
        //    dd($ano_lectivo_publicado);
        $anoLectivoPublicado = fh_anos_lectivos_publicado()->get();
        if ($anoLectivoPublicado->count() == 0) {
            AnoLectivoPublicado::create(
                [
                    'id_anoLectivo' => $ano_lectivo->id,
                    'ya_inicio' => $ano_lectivo->ya_inicio,
                    'ya_fim' => $ano_lectivo->ya_fim,
                    'id_cabecalho' => Auth::User()->id_cabecalho
                ]
            );
        } else {

            AnoLectivoPublicado::where('id', $ano_lectivo_publicado->id)->update(
                [
                    'id_anoLectivo' => $ano_lectivo->id,
                    'ya_inicio' => $ano_lectivo->ya_inicio,
                    'ya_fim' => $ano_lectivo->ya_fim,
                    'id_cabecalho' => Auth::User()->id_cabecalho

                ]
            );
        }

        return redirect()->back();
    }


    public function ocultar($slug)
    {

        AnoLectivoPublicado::where('slug', $slug)->delete();
        // session()->forget('ano_lectivo');
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Ano lectivo ocultado com sucesso']);

    }

    public function createSession($ano_lectivo, $id)
    {
        $anoLectivo = AnoLectivo::find($id);
        $ano_lectivo->session()->put('ano_lectivo', [['id' => $id, 'ano_lectivo' => $anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim]]);

    }
}
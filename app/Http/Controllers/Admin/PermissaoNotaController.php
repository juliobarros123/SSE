<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PermissaoNota;
use App\Models\PermissaoUnicaNota;
use Illuminate\Support\Facades\Auth;
class PermissaoNotaController extends Controller
{
    //
    public function editar()
    {
        $permissoesNota =   PermissaoNota::all();
        $permissoesUnicaNota =   PermissaoUnicaNota::all();
        return view('admin.permissao_notas.actualizar.index', compact('permissoesNota'), compact('permissoesUnicaNota'));
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function actualizar(Request $permissao)
    {

        if (isset($permissao->estado_t)) {
            PermissaoNota::find(1)->update(
                ['estado' => $permissao->estado_t]
            );
        }

        if (isset($permissao->estado_trimestreI)) {
            PermissaoNota::find(2)->update(
                ['estado' => $permissao->estado_trimestreI]
            );
        }
        if (isset($permissao->estado_trimestreII)) {
            PermissaoNota::find(3)->update(
                ['estado' => $permissao->estado_trimestreII]
            );
        }

        if (isset($permissao->estado_trimestreIII)) {
            PermissaoNota::find(4)->update(
                ['estado' => $permissao->estado_trimestreIII]
            );
        }







        /*===================================!!===================================*/

        if (isset($permissao->estado_professores_I)) {
            PermissaoUnicaNota::find(1)->update(
                ['estado' => $permissao->estado_professores_I]
            );
        }


        if (isset($permissao->estado_escolar_I)) {
            PermissaoUnicaNota::find(2)->update(
                ['estado' => $permissao->estado_escolar_I]
            );
        }

        if (isset($permissao->estado_mac_I)) {
            PermissaoUnicaNota::find(3)->update(
                ['estado' => $permissao->estado_mac_I]
            );
        }



        if (isset($permissao->estado_professores_II)) {
            PermissaoUnicaNota::find(4)->update(
                ['estado' => $permissao->estado_professores_II]
            );
        }


        if (isset($permissao->estado_escolar_II)) {
            PermissaoUnicaNota::find(5)->update(
                ['estado' => $permissao->estado_escolar_II]
            );
        }

        if (isset($permissao->estado_mac_II)) {
            PermissaoUnicaNota::find(6)->update(
                ['estado' => $permissao->estado_mac_II]
            );
        }

        if (isset($permissao->estado_professores_III)) {
            PermissaoUnicaNota::find(7)->update(
                ['estado' => $permissao->estado_professores_III]
            );
        }


        if (isset($permissao->estado_escolar_III)) {
            PermissaoUnicaNota::find(8)->update(
                ['estado' => $permissao->estado_escolar_III]
            );
        }

        if (isset($permissao->estado_mac_III)) {
            PermissaoUnicaNota::find(9)->update(
                ['estado' => $permissao->estado_mac_III]
            );
        }

        /*===================================!!===================================*/


        return redirect()->route('permissao.editar')->with('status',1);
    }
}

<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Classe;
use App\Models\User;
use DB;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Auth;
use App\Models\Logger;
use Exception;
use Illuminate\Database\QueryException;
use Mpdf\Tag\Input;

class ClasseController extends Controller
{
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function index()
    {

        $response['classes'] = fh_classes()->get();
        return view('admin.classes.index', $response);
    }


    public function create()
    {
        return view('admin.classes.cadastrar.index');
    }


    public function store(Request $request)
    {

        if ($request->vc_classe >= 1 && $request->vc_classe <= 13) {
            try {
                $c = Classe::where('vc_classe', $request->vc_classe)
                    ->where('id_cabecalho', Auth::User()->id_cabecalho)->count();
                if ($c) {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Classe  já existe']);

                } else {
                    Classe::create([
                        'vc_classe' => $request->vc_classe,
                        'id_cabecalho' => Auth::User()->id_cabecalho
                    ]);
                    $this->loggerData('Adicionou a Classe de numero ' . $request->vc_classe);
                }

                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Classe  cadastrada com sucesso']);

            } catch (QueryException $th) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);


            }

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Classe fora dos parâmetros.']);

        }
    }

    public function edit($slug)
    {

        $response['classe'] = fh_classes()->where('classes.slug', $slug)->first();
        if ($response['classe']):
            return view('admin.classes.editar.index', $response);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Classe fora dos parâmetros.']);


        endif;
    }

    public function update(Request $request, $slug)
    {
        if ($request->vc_classe >= 1 && $request->vc_classe <= 13) {
            try {
                $c = Classe::where('vc_classe', $request->vc_classe)
                    ->where('id_cabecalho', Auth::User()->id_cabecalho)->count();
                if ($c) {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Classe  já existe']);

                } else {
                    Classe::where('classes.slug', $slug)->update([
                        'vc_classe' => $request->vc_classe,

                    ]);
                    $this->loggerData('actualizou Classe de numero ' . $request->vc_classe);
                }

                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Classe  actualizada com sucesso']);

            } catch (QueryException $th) {
                // dd($th);
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);


            }

        } else {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Classe fora dos parâmetros.']);

        }
    }

    public function eliminar($slug)
    {
        try {
            // Classe::find($id)->delete();
            $response = Classe::where('classes.slug', $slug)->first();
            // dd($response);
            Classe::where('classes.slug', $slug)->delete();
            $this->loggerData('Eliminou a Classe de numero ' . $response->vc_classe);

            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Classe  eliminada com sucesso']);

        } catch (\Exception $e) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        }
    }


}
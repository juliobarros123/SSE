<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
 abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
 dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
 do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

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
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function index()
    {

        $classes = Classe::where([['it_estado_classe', 1]])->get();
        $class = FacadesDB::table('turmas_users')
            ->leftjoin('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
            ->leftJoin('classes', 'classes.id', '=', 'turmas_users.it_idClasse')
            ->select('turmas.vc_classeTurma', 'classes.*', 'users.vc_email')
            ->where([['it_estado_classe', 1]])
            ->where('turmas_users.it_idUser', Auth::user()->id)->distinct()
            ->get();
        return view('admin.classes.index', compact('classes', 'class'));
    }

    public function show($id)
    {
        //$classes = Classe::where([['it_estado_classe', 1]])->get();
        $classes = Classe::find($id);
        //dd($classes);
        return view('admin.classes.visualizar.index', compact('classes'));
    }

    public function create()
    {
        return view('admin.classes.cadastrar.index');
    }

    public function store(Request $request)
    {

                    if($request->vc_classe >= 1 && $request->vc_classe <=13){
                        try {
                            Classe::create([
                            'vc_classe' => $request->vc_classe,
                            // 'dt_dataCadastro' => $request->dt_date
                            'dt_dataCadasto' => $request->dt_date,
                            'it_estado_classe' => 1
                        ]);
                        }
                        catch (QueryException $th) {
                            return redirect()->back()->with("classe","1");

                        }
                        $this->loggerData('Adicionou a Classe de numero '.$request->vc_classe);
                        $class = new Classe();
                        $uri = 'http://192.168.1.63:8000/admin/classe/store';
                        $class->postClasse($request,$uri);

                        return redirect('/admin/classes')->with('status', '1');
                    }

                    else
                    return redirect()->back()->with("classe","1");


    }

    public function edit($id)
    {

        if ($classe = Classe::where([['it_estado_classe', 1]])->find($id)) :
            return view('admin.classes.editar.index', compact('classe'));
        else :
            return redirect('/admin/classes/cadastrar')->with('classe', '1');

        endif;
    }

    public function update(Request $request, $id)
    {
        try {
                Classe::find($id)->update([
                'vc_classe' => $request->vc_classe
                ]);
            }

        catch (QueryException $th) {
            return redirect()->back()->with("classe","1");
            }
            $this->loggerData('Actualizou a Classe de numero '.$request->vc_classe);

        return redirect()->route('admin/classes');
    }

    public function remover($id)
    {
        try {
            // Classe::find($id)->delete();
            $response = Classe::find($id);
            $response->update(['it_estado_classe' => 0]);
            $this->loggerData('Eliminou a Classe de numero '.$response->vc_classe);

            return redirect()->route('admin/classes');
        } catch (\Exception $e) {
            return redirect("/admin/classes/cadastrar");
        }
    }


    public function purgar($id)
    {
        /* try { */
           
            $response = Classe::find($id);
            $response2 = Classe::find($id)->delete();
            $this->loggerData("Purgou a Classe");
            return redirect()->back()->with('classe.purgar.success', '1');
        /* } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('classe.purgar.error', '1');
        } */
    }

    public function eliminadas()
    {
       

        $response['classes'] = Classe::where([['it_estado_classe', 0]])->get();
        $response['class'] = FacadesDB::table('turmas_users')
            ->leftjoin('users', 'users.id', '=', 'turmas_users.it_idUser')
            ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
            ->leftJoin('classes', 'classes.id', '=', 'turmas_users.it_idClasse')
            ->select('turmas.vc_classeTurma', 'classes.*', 'users.vc_email')
            ->where([['it_estado_classe', 0]])
            ->where('turmas_users.it_idUser', Auth::user()->id)->distinct()
            ->get();
        $response['eliminadas']="eliminadas";
        return view('admin.classes.index',  $response);
    }

    public function recuperar($id)
    {
        try {
           
            $response = Classe::find($id);
            $response->update(['it_estado_classe' => 1]);
            $this->loggerData("Recuperou  a Classe de numero ".$response->vc_classe);
            return redirect()->back()->with('classe.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('classe.recuperar.error', '1');
        }
    }
}

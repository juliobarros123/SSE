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
use App\Models\User;
use App\Repositories\Eloquent\UtilizadorRepository;
use Illuminate\Support\Facades\Validator;
use App\Actions\Fortify\PasswordValidationRules;

use App\Models\Logger;

use App\Models\Cabecalho;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    use PasswordValidationRules;
    private $Logger;
    protected $user;
    public function __construct(UtilizadorRepository $user)
    {
        $this->user = $user;
        $this->Logger = new Logger();
    }


    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }


    public function index()
    {
        $this->loggerData("Listou os usuarios");

        $users = fh_users()->get();
        return view('admin.users.index', compact('users'));
    }
    public function imprimir_lista()
    {
        $data['cabecalho'] = Cabecalho::find(1);
        $data["css"] = file_get_contents('css/listas/style.css');
        $data["bootstrap"] = file_get_contents('css/listas/bootstrap.min.css');

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->loggerData("Imprimiu Lita de Utilizador");
        $html = view("admin/pdfs/listas/funcionario/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdFuncionarios.pdf", "I");
    }


    public function create()
    {
        return view('admin.users.cadastrar.index');
    }

    public function salvar(Request $request)
    {
        try {
            $dados = $request->all();
            // dd( $dados);
            Validator::make($dados, [
                'vc_nomeUtilizador' => ['required', 'string', 'max:255'],
                'vc_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
            ])->validate();
        
            $this->loggerData("Adicionou Utilizador ");
            $this->user->store($dados);
            return redirect()->route('admin.users')->with('feedback', ['type' => 'success', 'sms' => 'Utilizador cadastrado com sucesso']);

        } catch (\Exception $exception) {
// dd($exception);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado. Não foi possível repetir o e-mail, utilizador ou telefone']);

        }
    }
    public function editar($slug)
    {
        if ($user = fha_users($slug)):

            return view('admin.users.editar.index', compact('user'));
        else:
            return redirect('admin/users/cadastrar')->with('teste', '1');

        endif;
    }
    public function editarPessoal($id)
    {
        if ($user = User::where([['it_estado_user', 1]])->find($id)):

            return view('admin.users.editarPessoal.index', compact('user'));
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Utilizador não existe']);


        endif;
    }


    public function atualizar(Request $input, $slug)
    {
        try {
            $dados[] = $input;
            // dd( $dados);
            if ($user = fha_users($slug)):

                $this->user->update($dados, $slug);
                $this->loggerData("Actualizou Utilizador");

                return redirect()->route('admin/users/listar')->with('feedback', ['type' => 'success', 'sms' => 'Utilizador editado com sucesso']);

            else:
                return redirect('/')->with('teste', '1');

            endif;
        } catch (\Exception $ex) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }

    public function atualizarPessoal(Request $input, $id)
    {
        $dados[] = $input;
        $this->user->update($dados, $id);
        $this->loggerData("Actualizou Utilizador");
        return redirect('/')->with('status', '1');
    }

    public function excluir($slug)
    {
        try {
            //User::find($id)->delete();
            //User::find($id)->delete();
            $response = fha_users($slug);
            // dd($response);
            User::where('users.slug', $slug)->delete();
            $this->loggerData("Eliminou Utilizador");
            return redirect()->route('admin/users/listar')->with('feedback', ['type' => 'success', 'sms' => 'Utilizador eliminado com sucesso']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.eliminar.error', '1');
        }
    }
    public function editar_nivel($id, $nivel)
    {
        $user = User::find($id)->update(['vc_tipoUtilizador' => $nivel]);
        return response()->json($user);
    }

    public function purgar($id)
    {
        try {
            //User::find($id)->delete();
            $response = User::find($id);
            $response2 = User::find($id)->delete();
            $this->loggerData("Purgou o Utilizador");
            return redirect()->back()->with('user.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.purgar.error', '1');
        }
    }


}
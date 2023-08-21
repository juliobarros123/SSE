<?php


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


            $userExiste = User::where('vc_email', $request->vc_tipoUtilizador)->first();
            if ($userExiste) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, E-mail já está sendo usado por uma conta Existente no Sistema']);

            }

            $dados = $request->all();
            // dd( $dados);
            if ($request->hasFile('profile_photo_path')) {
                $imagem = $request->file('profile_photo_path');
                $num = rand(1111, 9999);
                $dir = public_path("images/users");
                $extensao = $imagem->guessClientExtension();
                $nomeImagem = 'profile_photo_path' . "_" . $num . "." . $extensao;
                $imagem->move($dir, $nomeImagem);
                $dados['profile_photo_path'] = "images/users" . "/" . $nomeImagem;

                // unlink($cff->vc_foto);
                // $imagem->move($dir, $nomeImagem);
            } else {
                $dados['profile_photo_path'] = "images/users/modelo.png";

            }
            Validator::make($dados, [
                'vc_nomeUtilizador' => ['required', 'string', 'max:255'],
                'vc_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => $this->passwordRules(),
            ])->validate();

            //   dd( $dados['profile_photo_path']);
            $user = $this->user->store($dados);
            //   dd($user);
            if ($user) {
                User::find($user->id)->update([
                    'profile_photo_path' => $dados['profile_photo_path']
                ]);

            }
            $this->loggerData("Adicionou Utilizador ");
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
                if ($input->hasFile('profile_photo_path')) {
                    $imagem = $input->file('profile_photo_path');
                    $num = rand(1111, 9999);
                    $dir = public_path("images/users");
                    $extensao = $imagem->guessClientExtension();
                    $nomeImagem = 'profile_photo_path' . "_" . $num . "." . $extensao;
                    $imagem->move($dir, $nomeImagem);
                    $dados['profile_photo_path'] = "images/users" . "/" . $nomeImagem;

                    // unlink($cff->vc_foto);
                    // $imagem->move($dir, $nomeImagem);
                } else {
                    $dados['profile_photo_path'] = $user->profile_photo_path;

                }
                $this->user->update($dados, $slug);
                if ($user) {
                    User::find($user->id)->update([
                        'profile_photo_path' => $dados['profile_photo_path']
                    ]);

                }
                $this->loggerData("Actualizou Utilizador");

                return redirect()->route('admin.users')->with('feedback', ['type' => 'success', 'sms' => 'Utilizador editado com sucesso']);

            else:
                return redirect('/')->with('teste', '1');

            endif;
        } catch (\Exception $ex) {
            dd($ex);
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
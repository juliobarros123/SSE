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
use App\Models\Cabecalho;
use App\Models\AnoValidadeCartao;
use App\Models\Funcionario as ModelsFuncionario;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class Funcionario extends Controller
{
    //
    private $Logger,$salario;
    public function __construct(FolhaSalarioFuncionarioController $salario)
    {
        $this->Logger = new Logger();
        $this->salario=$salario;
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function show()
    {
        $response['dados'] = ModelsFuncionario::where([['it_estado_funcionario', 1]])->get();
        return view('admin.cartoes.funcionario.visualizar.index', $response);
    }

    public function listar(){
        $data['funcionarios'] = DB::select('select * from funcionarios where it_estado_funcionario = ?', [1]);

        return view("admin.cartoes.funcionario.index",$data);
    }
    public function create()
    {
        $data['anoValidade']= AnoValidadeCartao::orderBy('id','desc')->where('vc_TipoCartao','Funcionário')->first();
        return view('admin.cartoes.funcionario.cadastrar.index',$data);
    }

    public function store(Request $request)
    {

        try {
            $dados = $request->all();
            $request->validate([
                'vc_primeiroNome' => 'required',
                'vc_ultimoNome' => 'required',
                'vc_bi' =>  'required',
                'vc_funcao' => 'required',
                'ya_anoValidade' => 'required',
                'dt_nascimento' => 'required'
            ]);


                    if ($request->hasFile('vc_foto')) {
                        $imagem = $request->file('vc_foto');
                        $num = rand(1111, 9999);
                        $dir = public_path("images/funcionarios");
                        $extensao = $imagem->guessClientExtension();
                        $nomeImagem = 'vc_foto' . "_" . $num . "." . $extensao;
                        $imagem->move($dir, $nomeImagem);
                        $dados["vc_foto"] = "images/funcionarios" . "/" . $nomeImagem;
                    }else{
                        $dados["vc_foto"] = "images/funcionarios" . "/" . "avatar.png";
                    }

            ModelsFuncionario::create($dados);
            $this->loggerData('Adicionou o(a) Funcionáro(a) '.$request->vc_primeiroNome.' '.$request->vc_ultimoNome.' com o id '.$request->id.'com a função de '.$request->vc_funcao);
            $it_id_funcionario = DB::table('funcionarios')->max('id');
            $id_mes=1;
            $this->salario->cadastrar($it_id_funcionario);
            return redirect()->back()->with('status', '1');
        } catch (\Exception $exception) {
dd($exception);
            return redirect()->back()->with('aviso', '1');
        }
    }

    public function edit($id)
    {
        if ($response['funcionario'] = ModelsFuncionario::find($id)) :
            $data['anoValidade']= AnoValidadeCartao::orderBy('id','desc')->where('vc_TipoCartao','Funcionário')->first();

            return view('admin.cartoes.funcionario.editar.index', $response);
        else :
            return redirect('/admin/funcionario/cadastrar')->with('funcionario', '1');

        endif;
    }

    public function update(Request $request, $id)
    {
        $dados = $request->all();

        $request->validate([
            'vc_primeiroNome' => 'required',
            'vc_ultimoNome' => 'required',
            'vc_bi' => 'required',
            'vc_funcao' => 'required',
            'ya_anoValidade' => 'required',
            'dt_nascimento' => 'required',
            'vc_agente' => 'required'
        ]);

        if ($request->hasFile('vc_foto')) {
            $imagem = $request->file('vc_foto');
            $num = rand(1111, 9999);
            $dir = public_path("images/funcionarios");
            $extensao = $imagem->guessClientExtension();
            $nomeImagem = 'vc_foto' . "_" . $num . "." . $extensao;
            $imagem->move($dir, $nomeImagem);
            $dados['vc_foto'] = "images/funcionarios" . "/" . $nomeImagem;
            $cff = ModelsFuncionario::find($id);
            // unlink($cff->vc_foto);
            // $imagem->move($dir, $nomeImagem);
        }
        $cf = ModelsFuncionario::find($id);
        $edit = $cf->update($dados);

        //dd($dados);
        $this->loggerData('Actualizou Funcionário ',$request->vc_primeiroNome .' '.$request->vc_ultimoNome.'com  função '.$request->vc_funcao);
        return redirect()->back();
    }

    public function destroy($id)
    {

        //$response = ModelsFuncionario::find($id);
        //$response->delete();
        $response = ModelsFuncionario::find($id);
        $response->update(['it_estado_funcionario' => 0]);

        //unlink($response->vc_foto);
        $this->loggerData('Eliminou Funcionário ',$response->vc_primeiroNome .' '.$response->vc_ultimoNome.'com  função '.$response->vc_funcao);
        return redirect()->route('admin/funcionarios');
    }

    public function gerar($id)
    {

        if ($data['response'] = ModelsFuncionario::where([['it_estado_funcionario', 1]])->find($id)) :
            $data['anoValidade']= AnoValidadeCartao::orderBy('id','desc')->first();
            //gerar cartão
            $data['cabecalho'] = Cabecalho::find(1);
               
            /* $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
            $data["css"] = file_get_contents("css/listas/style.css"); */
            if ($data['cabecalho']->vc_nif == "5000298182") {
          
                //$url = 'cartões/CorMarie/aluno.png';
                // __full_path()
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
               
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            // dd(5000820440);
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
             } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path().'css/cartao/funcionario/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }

            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 'margin_top' => 0,
                'margin_left' => 5,
                'margin_right' => 0, 'margin_bottom' => 0, 'format' => [85, 54]
            ]);

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->AddPage('L');
            $this->loggerData('Emitiu Cartão do(a) Funcionáro(a) '.$data['response']->vc_primeiroNome.' '.$data['response']->vc_ultimoNome.' com o id '.$data['response']->id);
            $html = view("admin/pdfs/cartao/funcionario/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("funcionario.pdf", "I");

        else :
            return redirect('admin/funcionarios')->with('aviso', 'Não existe nenhum Funcionário com esse ID');
        endif;
    }
    public function imprimir()
    {
        
        $data['cabecalho'] = Cabecalho::find(1);
       /*  $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */

        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }  else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }
        $data['funcionarios'] = ModelsFuncionario::where([['it_estado_funcionario', 1]])->orderby('vc_primeiroNome', 'asc')->orderby('vc_ultimoNome', 'asc')->get();
        $mpdf = new \Mpdf\Mpdf();
    
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->loggerData('Imprimiu Lista dos Funcionários');
        $html = view("admin/pdfs/listas/funcionarios/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdFuncioarios.pdf", "I");
    }


    public function purgar($id)
    {
        try {
            //ModelsFuncionario::find($id)->delete();
            $response = ModelsFuncionario::find($id);
            $response2 = ModelsFuncionario::find($id)->delete();
            $this->loggerData("Purgou o Funcionário");
            return redirect()->back()->with('funcionario.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('funcionario.purgar.error', '1');
        }
    }

    public function eliminadas()
    {
        $this->loggerData("Listou os funcionários eliminados");

        $response['funcionarios'] = ModelsFuncionario::where([['it_estado_funcionario', 0]])->get();
        $response['eliminadas']="eliminadas";
        return view('admin.cartoes.funcionario.index',  $response);
    }

    public function recuperar($id)
    {
        try {
            //ModelsFuncionario::find($id)->delete();
            //ModelsFuncionario::find($id)->delete();
            $response = ModelsFuncionario::find($id);
            $response->update(['it_estado_funcionario' => 1]);
            $this->loggerData("Recuperou Funcionário");
            return redirect()->back()->with('funcionario.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('funcionario.recuperar.error', '1');
        }
    }
}

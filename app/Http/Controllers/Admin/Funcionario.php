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
use Mpdf\Config\ConfigVariables;
use Mpdf\Config\FontVariables;
class Funcionario extends Controller
{
    //
    private $Logger, $salario;
    public function __construct()
    {
        $this->Logger = new Logger();

    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function show()
    {
        $response['dados'] = ModelsFuncionario::where([['it_estado_funcionario', 1]])->get();
        return view('admin.cartoes.funcionario.visualizar.index', $response);
    }

    public function listar()
    {
        $data['funcionarios'] = fh_funcionarios()->get();

        return view("admin.cartoes.funcionario.index", $data);
    }
    public function create()
    {
        $data['anoValidade'] = AnoValidadeCartao::orderBy('id', 'desc')->where('vc_TipoCartao', 'Funcionário')->first();
        return view('admin.cartoes.funcionario.cadastrar.index', $data);
    }

    public function store(Request $request)
    {

        try {
            $dados = $request->all();
            $request->validate([
                'vc_primeiroNome' => 'required',
                'vc_ultimoNome' => 'required',
                'vc_bi' => 'required',
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
            } else {
                $dados["vc_foto"] = "images/funcionarios" . "/" . "avatar.png";
            }
            $dados["id_cabecalho"] = Auth::User()->id_cabecalho;
            ModelsFuncionario::create($dados);
            $this->loggerData('Adicionou o(a) Funcionáro(a) ' . $request->vc_primeiroNome . ' ' . $request->vc_ultimoNome . ' com o id ' . $request->id . 'com a função de ' . $request->vc_funcao);
            $it_id_funcionario = DB::table('funcionarios')->max('id');
            $id_mes = 1;

            return redirect()->back()->with('status', '1');
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('aviso', '1');
        }
    }

    public function edit($slug)
    {
        $response['funcionario'] = fh_funcionarios()->where('funcionarios.slug', $slug)->first();

        if ($response['funcionario']):
            $data['anoValidade'] = AnoValidadeCartao::orderBy('id', 'desc')->where('vc_TipoCartao', 'Funcionário')->first();

            return view('admin.cartoes.funcionario.editar.index', $response);
        else:
            return redirect('/admin/funcionario/cadastrar')->with('funcionario', '1');

        endif;
    }

    public function update(Request $request, $slug)
    {
        // dd($slug);
        try {
            $dados = $request->except(['_token', '_method']);

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

                // unlink($cff->vc_foto);
                // $imagem->move($dir, $nomeImagem);
            }
            $cf = ModelsFuncionario::where('funcionarios.slug', $slug)->update($dados);


            //dd($dados);
            $this->loggerData('Actualizou Funcionário ', $request->vc_primeiroNome . ' ' . $request->vc_ultimoNome . 'com  função ' . $request->vc_funcao);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Funcionàrio editado com sucesso']);

        } catch (\Exception $ex) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }

    public function destroy($slug)
    {

        //$response = ModelsFuncionario::find($id);
        //$response->delete();
        $response = ModelsFuncionario::where('funcionarios.slug', $slug)->first();
        ModelsFuncionario::where('funcionarios.slug', $slug)->delete();

        //unlink($response->vc_foto);
        $this->loggerData('Eliminou Funcionário ', $response->vc_primeiroNome . ' ' . $response->vc_ultimoNome . 'com  função ' . $response->vc_funcao);
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Funcionàrio eliminado com sucesso']);

    }

    public function cartao_imprimir($slug)
    {
        $funcionario = fh_funcionarios()->where('funcionarios.slug', $slug)->first();
        if ($funcionario):

            $data['funcionario'] = $funcionario;
            $data['cabecalho'] = fh_cabecalho();
            $configVariables = new ConfigVariables();
            $fontVariables = new FontVariables();
            $fontData = $fontVariables->getDefaults();

            $fontDir = public_path('fonts/Roboto'); // Caminho para a pasta com os arquivos de fonte Roboto

            $defaultConfig = (new ConfigVariables())->getDefaults();
            $fontDirs = $defaultConfig['fontDir'];

            $defaultFontConfig = (new FontVariables())->getDefaults();
            $fontData = $defaultFontConfig['fontdata'];

            $fontData['roboto'] = [
                'R' => 'Roboto-Regular.ttf',
                'B' => 'Roboto-Bold.ttf',
                'I' => 'Roboto-Italic.ttf',
                'BI' => 'Roboto-BoldItalic.ttf',
            ];


            $mpdf = new \Mpdf\Mpdf([
                'fontDir' => array_merge($fontDirs, [
                    $fontDir,
                ]),
                'fontdata' => $fontData,
                'mode' => 'utf-8',
                'margin_top' => 1,
                'margin_left' => 0,
                'margin_right' => 0,
                'margin_bottom' => 0,
                'format' => [85, 54]
            ]);
            $data["css"] = file_get_contents('css/cartao/funcionario/style.css');
            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->AddPage('L');
            $this->loggerData('Emitiu Cartão do(a) Funcionáro(a) ' . $funcionario->vc_primeiroNome . ' ' . $funcionario->vc_ultimoNome . ' com o id ' . $funcionario->id);
            $html = view("admin/pdfs/cartao/funcionario/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("funcionario.pdf", "I");

        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, funciónario não existe']);


        endif;
    }
    public function imprimir()
    {

        $data['funcionarios'] = fh_funcionarios()->orderby('funcionarios.vc_primeiroNome', 'asc')->orderby('funcionarios.vc_ultimoNome', 'asc')->get();
        $mpdf = new \Mpdf\Mpdf();



        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();
        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);

        $this->loggerData('Imprimiu Lista dos Funcionários');

        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $html = view("admin/pdfs/listas/funcionarios/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdFuncioarios.pdf", "I");
    }




}
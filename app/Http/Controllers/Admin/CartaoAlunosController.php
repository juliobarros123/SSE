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
use App\Models\Cabecalho;
use App\Models\Estudante;
use App\Models\Logger;
use App\Models\AnoValidadeCartao;
use Illuminate\Support\Facades\Auth;

class CartaoAlunosController extends Controller
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
        return view('admin.cartoes.aluno.index');
    }

    public function recebeAluno(Request $request)
    {
        $id = $request->processo;
        return redirect("/admin/cartaoaluno/emitir/$id");
    }
    public function emitir(Estudante $estudantes, $id)
    {


        $c = $estudantes->StudentForCard($id);
        // dd(  $c);
        $data['anoValidade']= AnoValidadeCartao::orderBy('id','desc')->where('vc_TipoCartao','Aluno')->first();
        $data["css"] = file_get_contents('css/cartao/aluno/style.css');
        $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
        if ($c->count()) :
            //Metodo que gera o cartão do aluno
            $data['alunos'] =  $c;
            $data['cabecalho'] = Cabecalho::find(1);
           /*  $data["bootstrap"] = file_get_contents("css/cartao/bootstrap.min.css");
            $data["css"] = file_get_contents("css/cartao/aluno/style.css"); */

            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
             }else if ($data['cabecalho']->vc_nif == "7301003617") {

                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            }else{
                $data["css"] = file_get_contents('css/cartao/aluno/style.css');
                $data["bootstrap"] = file_get_contents('css/cartao/bootstrap.min.css');
            }
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8', 'margin_top' => 0,
                'margin_left' => 5,
                'margin_right' => 0, 'margin_bottom' => 0, 'format' => [54, 84]
            ]);
            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            $mpdf->AddPage('L');
            $html = view("admin/pdfs/cartao/aluno/index", $data);
            $mpdf->writeHTML($html);
            $this->loggerData('Emitiu o(a) Cartão do(a) Aluno(a) '.$c[0]->vc_primeiroNome.' '.$c[0]->vc_ultimoaNome);
            $mpdf->Output("aluno.pdf", "I");
        else :
            return redirect('admin/cartaoaluno')->with('aviso', '1');
        endif;
    }
}

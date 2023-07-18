<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pagamento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Logger;

class PagamentoController extends Controller
{
    public function __construct()
    {
        $this->Logger = new Logger();


    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    //
    public function pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        return view('admin.pagamento.pesquisar.index', $response);
    }

    public function filtrar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        return view('admin.pagamento.filtro.index', $response);

    }
    public function lista(Request $request)
    {
        // dd($request);
        if (session()->get('pagamentos_lista')) {

            if (!$request->id_ano_lectivo) {
                $pagamentos_lista = session()->get('pagamentos_lista');
                $request->id_ano_lectivo = $pagamentos_lista['id_ano_lectivo'];
            }
            if (!$request->mes) {
                $pagamentos_lista = session()->get('pagamentos_lista');
                $request->mes = $pagamentos_lista['mes'];
            }
            // dd($request->ciclo);

        }
        $pagamentos_lista = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'mes' => $request->mes
        ];
        storeSession('pagamentos_lista', $pagamentos_lista);
        $pagamentos = fh_pagamentos();
        // dd( $pagamentos->get());
        $response['mes'] = $request->mes;
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $pagamentos = $pagamentos->where('pagamentos.id_ano_lectivo', $request->id_ano_lectivo);
        }


        if ($request->mes != 'Todos' && $request->mes) {
            // dd(  $matriculas->get(),$request->id_curso);
            // $mes = fha_obterNumeroMes($request->mes);
            // dd($mes);
            $pagamentos = $pagamentos->where('pagamentos.mes', $request->mes);
        }
        $pagamentos = $pagamentos->get();
        // dd( $pagamentos);
        $response['pagamentos']=$pagamentos;
        return view('admin.pagamento.index', $response);

    }
    public function estado(Request $request)
    {
        // dd(session()->get('pagamento_estado_pesquisar')) ;
        // $response = $request->all();
        // dd($request->processo);

        // dd(  $response['aluno']);
        if (session()->get('pagamento_estado_pesquisar')) {
            if (!$request->processo) {
                $pagamento_estado_pesquisar = session()->get('pagamento_estado_pesquisar');
                $request->processo = $pagamento_estado_pesquisar['processo'];
            }
            if (!$request->id_ano_lectivo) {
                $pagamento_estado_pesquisar = session()->get('pagamento_estado_pesquisar');
                $request->id_ano_lectivo = $pagamento_estado_pesquisar['id_ano_lectivo'];
            }
            if (!$request->tipo) {
                $pagamento_estado_pesquisar = session()->get('pagamento_estado_pesquisar');
                $request->tipo = $pagamento_estado_pesquisar['tipo'];
            }
            // dd($request->ciclo);

        }
        $pagamento_estado_pesquisar = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'tipo' => $request->tipo,
            'processo' => $request->processo,
        ];
        // dd($matriculados);

        storeSession('pagamento_estado_pesquisar', $pagamento_estado_pesquisar);
        $matricula = fh_matriculas()->where('turmas.it_idAnoLectivo', $request->id_ano_lectivo)
            ->where('alunnos.processo', $request->processo)->first();
        // dd($matricula);
        if ($matricula):
        $classe = fh_classes()->where('classes.id', $matricula->id_classe)->first();

            $tipo_pagamento = fh_tipos_pagamento()
                ->where('tipo_pagamentos.id_classe', $matricula->id_classe)
                ->where('tipo_pagamentos.tipo', 'Mensalidades')
                ->first();
            if ($tipo_pagamento) {
                $response['matricula'] = $matricula;
                if ($request->tipo == 'Mensalidades') {
                    $response['inicio_termino_ano_lectivo'] = fh_inicio_termino_ano_lectivo()
                        ->where('inicio_termino_ano_lectivos.id_ano_lectivo', $request->id_ano_lectivo)->first();
                    // dd(   $response['inicio_termino_ano_lectivo']);
                    if ($response['inicio_termino_ano_lectivo']) {
                        return view('admin.pagamento.estado.mensalidade.index', $response);
                    } else {
                        return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, cadastra início e o termino do ano lectivo']);

                    }

                }

            } else {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Erro, cadastra o tipo de pagamento para essa Classe"]);

            }
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Tipo de pagamento eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, aluno não se econtra matriculado neste ano lectivo']);


        endif;


    }
    public function pagar_mensalidade($slug_tipo_pagamento, $processo, $slug_ano_lectivo, $mes,$valor_final)
    {



        try {
            $tipo_pagamento = fh_tipos_pagamento()->where('tipo_pagamentos.slug', $slug_tipo_pagamento)->first();
            $aluno = fha_aluno_processo($processo);
            // dd( $aluno);
            $ano_lectivo = fh_anos_lectivos()->where('anoslectivos.slug', $slug_ano_lectivo)->first();

            $pagamento = Pagamento::create([
                'id_tipo_pagamento' => $tipo_pagamento->id,
                'mes' => $mes,
                'id_aluno' => $aluno->id,
                'id_ano_lectivo' => $ano_lectivo->id,
                'valor_final'=>$valor_final

            ]);
            // $pagamento=fh_pagamentos()->where('pagamentos.slug',$pagamento->slug)->first();
            // dd(  $pagamento);
            $this->loggerData("Efectuo o pagamento do mes de $mes para o aluno com processo $aluno->processo ( $aluno->vc_primeiroNome $aluno->vc_apelido)");

            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Pagamento efectuado com sucesso']);
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, tente novamente!']);


        }
    }
    public function fatura($slug_pagamento)
    {
        $pagamento = fh_pagamentos()->where('pagamentos.slug', $slug_pagamento)->first();

        if ($pagamento):
            $response['pagamento'] = $pagamento;
            // dd($pagamento);
            $aluno = fh_alunos()->where('alunnos.id', $pagamento->id_aluno)->first();
            $response['aluno'] = $aluno;
            // dd( $response['aluno'],$response['pagamento']);
            // dd(          $response['aluno']);
            $mpdf = new \Mpdf\Mpdf([
                'mode' => 'utf-8',
                'margin_top' => 0,
                'margin_right' => 7,
                'margin_left' => 7,
                'margin_bottom' => 0,
                'format' => [200, 130]
            ]);

            $mpdf->SetFont("arial");
            $mpdf->setHeader();
            // $mpdf->AddPage();
            $mpdf->AddPage('L');


            // $response["style0"] = file_get_contents("css/lista-fragments.css");
            $response["style"] = file_get_contents("css/fatura/estilo.css");
            $html = view("admin/pdfs/fatura/index", $response);
            // $mpdf->WriteHTML($response["style0"], \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($response["style"], \Mpdf\HTMLParserMode::HEADER_CSS);
            $mpdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

            //  $html = view("admin/pdfs/alunos_municipio/index", $response);
            //  $mpdf->writeHTML($html);
            $mpdf->Output("fatura.pdf", "I");
            // Pagamento::where('slug', $slug_pagamento)->delete();
            $this->loggerData('Gerou fatura pagamento do aluno com o processo ' . $aluno->processo . '(' . $aluno->vc_primeiroNome . ' ' . $aluno->vc_apelido . ')');
            // return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Pagamento eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;

    }
    public function anular_pagamento($slug_pagamento)
    {
        $pagamento = Pagamento::where('slug', $slug_pagamento)->first();
        if ($pagamento):
            Pagamento::where('slug', $slug_pagamento)->delete();
            $this->loggerData('Eliminou paragamento do aluno com o id   ', $pagamento->id_aluno);
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Pagamento eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;

    }
}
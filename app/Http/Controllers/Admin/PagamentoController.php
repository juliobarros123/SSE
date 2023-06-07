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
    public function estado(Request $request)
    {
        // dd(session()->get('pagamento_estado_pesquisar')) ;
        // $response = $request->all();
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
        if ($matricula):
            $response['matricula'] = $matricula;
            if ($request->tipo == 'Mensalidades') {
                return view('admin.pagamento.estado.mensalidade.index', $response);

            }
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Tipo de pagamento eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, aluno não se econtra matriculado neste ano lectivo']);


        endif;


    }
    public function pagar_mensalidade($slug_tipo_pagamento, $processo, $slug_ano_lectivo)
    {



        try {
            $tipo_pagamento = fh_tipos_pagamento()->where('tipo_pagamentos.slug', $slug_tipo_pagamento)->first();
            $aluno = fha_aluno_processo($processo);
            // dd( $aluno);
            $ano_lectivo = fh_anos_lectivos()->where('anoslectivos.slug', $slug_ano_lectivo)->first();

            Pagamento::create([
                'id_tipo_pagamento' => $tipo_pagamento->id,
                'id_aluno' => $aluno->id,
                'id_ano_lectivo' => $ano_lectivo->id,

            ]);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Pagamento efectuado com sucesso']);
        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, tente novamente!']);


        }
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
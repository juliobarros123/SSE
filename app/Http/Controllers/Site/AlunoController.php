<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\User;
use Auth;
use Illuminate\Http\Request;

class AlunoController extends Controller
{
    //
    // public function login(){}
    public function index(Request $request)
    {
        // dd("o");
        try {
            $aluno = fh_alunos_site()->
                where('candidatos.tokenKey', $request->codigo)
                ->where('alunnos.processo', $request->processo)->first();
            // dd($aluno);
            if ($aluno) {
                // dd("ola");
                $aluno_login = [
                    'codigo' => $request->codigo,
                    'processo' => $request->processo
                ];
                storeSession('aluno_login', $aluno_login);
                
                $user = User::where('vc_tipoUtilizador', 'Estudante')->where('id_cabecalho',$aluno->id_cabecalho)->first();
                // dd(    $user);
                if($user){
                Auth::login($user);

                // Redireciona para a página inicial ou outra página desejada
                return redirect()->route('painel.alunos')->with('feedback', ['type' => 'success', 'sms' => 'Seja Bem-vindo!']);
                // return view('site.aluno.index');
                }else{
                    session()->remove('aluno_login');
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Sua Escola não Está Configurada para o Acesso de Alunos.']);

                }
            } else {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Credências não encontradas.']);

            }
        } catch (\Exception $exception) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);

            // return redirect()->back()->with('aviso', '1');

        }
    }
    public function painel()
    {
        // session()->remove('aluno_login');

        if (session()->get('aluno_login')) {
            $matricula = fh_matriculas()
            ->where('alunnos.processo', session()->get('aluno_login')['processo'])
            ->orderBy('anoslectivos.ya_fim','desc')
            ->first();
            $response['disciplinas']=fha_disciplinas($matricula->it_idCurso, $matricula->it_idClasse);

            // $response['disciplinas']=fha_turmas_disciplinas_dcc($matricula->it_idTurma);
            // dd( $response['disciplinas']);
            // $response['disciplinas'] = fh_turmas_professores()->where('turmas.id',$matricula->it_idTurma)->get();

    //    dd(   $response['professores']);

            return view('site.aluno.index',$response);

        } else {
            $response['erro']="Usuário sem permissão para acessar essa página";
            return view('errors.geral',$response);

        }

    }
    public function d()
    {
        return view('site.aluno.ficha.index');

    }
    public function pauta(Request $dados_notas)
    {
        $cadeado=cadeados_pauta()->first();

        if($cadeado->estado=='Disponível'){
        if (Auth::check()) {
            $aluno = session()->get('aluno_login');

            // dd( $aluno); 
// dd($dados_notas);
            if ($dados_notas->trimestre) {
                $matricula = fh_matriculas()->where('alunnos.processo', $aluno['processo'])
                    ->where('turmas.it_idAnoLectivo', $dados_notas->id_ano_lectivo)->first();
                if ($matricula) {
                    // dd(  $matricula );
                    // fh_turmas_2()
                    $turma = fh_turmas_2()->where('turmas.id', $matricula->it_idTurma)->first();
                    // dd(     $turma);
                    $response['disciplinas'] = fh_turma_disciplina($turma->slug)->get();
                    $response['turma'] = $turma;
                    $response['matricula'] = $matricula;
                    $response['trimestre'] = $dados_notas->trimestre;
                    $response['cabecalho'] = fh_cabecalho();

if( $matricula->vc_classe==13){
    return view('site.aluno.pauta.index-13', $response);

}else{
    return view('site.aluno.pauta.index', $response);

}

                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Aluno não se encontra matriculado para este Ano Lectivo']);

                }
                // dd($response['disciplinas']);
                // dd($matricula);
                // $response['disciplinas'] = fh_turma_disciplina($slug_turma)->get();
            } else {
                return view('site.aluno.pauta.index');

            }
        } else {
            return redirect('/login');
        }
    }else{
        return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'No momento, as pautas não estão disponíveis.']);

    }
    }
    public function erro()
    {
        return view('errors.permissao');

    }
    public function cartoes_pagamento(Request $request)
    {
        // dd("oa");

        if ($request->id_ano_lectivo) {
            // dd("o");
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
            // if( $matricula)
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
                            return view('site.aluno.cartao-pagemento.index', $response);
                        } else {
                            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, Não existe início e o termino do ano lectivo. Entre em contacto com a sua escola!']);

                        }

                    }

                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => "Erro, cadastra o tipo de pagamento para $classe->vc_classe" . "ª Classe"]);

                }
                return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Tipo de pagamento eliminado com sucesso']);
            else:
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro, aluno não se econtra matriculado neste ano lectivo']);


            endif;
        }

        $response = array();
        return view('site.aluno.cartao-pagemento.index', $response);

    }
    public function professores(Request $request)
    {
        $response = [];
        if (session()->get('aluno_login')) {
            $processo = session()->get('aluno_login')['processo'];

            $response['turmas'] = fh_matriculas()->where('alunnos.processo', $processo)->get();
            // dd( $response['turmas']);
            if ($request->id_turma) {
                // dd($request->id_turma);
                $response['professores'] = fh_turmas_professores()->where('turmas.id', $request->id_turma)->get();
        //    dd($response['professores']);
            }
            return view('site.aluno.professores.index', $response);
        }
    }
}
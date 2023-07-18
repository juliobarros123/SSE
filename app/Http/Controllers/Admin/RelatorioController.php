<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;
use App\Models\Curso;

class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->Logger = new Logger();

    }
    //
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function candidaturas_pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        return view('admin.relatorio.candidatura.pesquisar.index', $response);

    }
    public function candidaturas_imprimir(Request $request)
    {
        // dd(  $data['cursos']);
        if (!$request->id_curso) {
            $filtro_candidato_relatorio = session()->get('filtro_candidato_relatorio');
            $request->id_curso = $filtro_candidato_relatorio['id_curso'];
        }
        if (!$request->id_ano_lectivo) {
            $filtro_candidato_relatorio = session()->get('filtro_candidato_relatorio');
            $request->id_ano_lectivo = $filtro_candidato_relatorio['id_ano_lectivo'];
        }
        // dd($request->ciclo);
        if (!$request->ciclo) {
            $filtro_candidato_relatorio = session()->get('filtro_candidato_relatorio');
            $request->ciclo = $filtro_candidato_relatorio['ciclo'];
        }

        $data['ano_lectivo'] = 'Todos';

        $data['curso'] = 'Todos';
        $data['ciclo'] = 'Todos';
        $data['classes'] = fh_classes()->get();

        $candidatos = fh_candidatos();
        //    dd($candidatos);
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $ano_lectivo = fh_anos_lectivos_publicado()->first();
            // dd($ano_lectivo );
            $data['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
            // dd($request->id_ano_lectivo);
            $candidatos = $candidatos->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }
        // dd($candidatos->get());

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd($candidatos->get(),$request->id_curso);
            $data['curso'] = Curso::find($request->id_curso)->vc_nomeCurso;
            $data['cursos'] = fh_cursos()->where('cursos.id', $request->id_curso)->get();
            $candidatos = $candidatos->where('candidatos.id_curso', $request->id_curso);
        } else {
            $data['cursos'] = fh_cursos()->get();

        }
        // dd($candidatos->get());
        // dd($candidatos);
        // dd( $data['classes']);
        if ($request->ciclo != 'Todos' && $request->ciclo) {
            if ('Ensino Primário' == $request->ciclo) {
                $candidatos = $candidatos
                    ->whereBetween('classes.vc_classe', [1, 6]);
                // dd( $candidatos->get());
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [1, 6]);
            } else if ('Ensino Secundário (1º Ciclo)' == $request->ciclo) {
                $candidatos = $candidatos
                    ->whereBetween('classes.vc_classe', [7, 9]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [7, 9]);

            } else if ('Ensino Secundário (2º Ciclo)' == $request->ciclo) {

                $candidatos = $candidatos
                    ->whereBetween('classes.vc_classe', [10, 13]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [10, 13]);
                // dd( $data['classes']);

            }
            $data['ciclo'] = $request->ciclo;

        }
        // dd($candidatos);
        $filtro_candidato_relatorio = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'ciclo' => $request->ciclo,
        ];

        storeSession('filtro_candidato_relatorio', $filtro_candidato_relatorio);
        $data['candidatos'] = $candidatos->get();
        // dd(   $data['candidatos']);
        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();


        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        // dd( $data['candidatos'] );
        $mpdf->setHeader();
        $this->loggerData('Imprimiu relatorio de candidatura');
        $html = view("admin/pdfs/relatorio/candidatura/index", $data);

        $mpdf->writeHTML($html);

        $mpdf->Output("listasdCandidaturas.pdf", "I");

    }




    public function candidatos_aceitos_pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        return view('admin.relatorio.candidatos_aceitos.pesquisar.index', $response);

    }
    public function candidatos_aceitos_imprimir(Request $request)
    {
        // dd(  "L");
        if (!$request->id_curso) {
            $filtro_aluno_relatorio = session()->get('filtro_aluno_relatorio');
            $request->id_curso = $filtro_aluno_relatorio['id_curso'];
        }
        if (!$request->id_ano_lectivo) {
            $filtro_aluno_relatorio = session()->get('filtro_aluno_relatorio');
            $request->id_ano_lectivo = $filtro_aluno_relatorio['id_ano_lectivo'];
        }
        // dd($request->ciclo);
        if (!$request->ciclo) {
            $filtro_aluno_relatorio = session()->get('filtro_aluno_relatorio');
            $request->ciclo = $filtro_aluno_relatorio['ciclo'];
        }

        $data['ano_lectivo'] = 'Todos';

        $data['curso'] = 'Todos';
        $data['ciclo'] = 'Todos';
        $data['classes'] = fh_classes()->get();

        $alunos = fh_alunos();
        //    dd($candidatos);
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $ano_lectivo = fh_anos_lectivos_publicado()->first();
            // dd($ano_lectivo );
            $data['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
            // dd($request->id_ano_lectivo);
            $alunos = $alunos->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }
        // dd($alunos->get());

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd($alunos->get(),$request->id_curso);
            $data['curso'] = Curso::find($request->id_curso)->vc_nomeCurso;
            $data['cursos'] = fh_cursos()->where('cursos.id', $request->id_curso)->get();
            $alunos = $alunos->where('candidatos.id_curso', $request->id_curso);
        } else {
            $data['cursos'] = fh_cursos()->get();

        }
        // dd($alunos->get());
        // dd($alunos);
        // dd( $data['classes']);
        if ($request->ciclo != 'Todos' && $request->ciclo) {
            if ('Ensino Primário' == $request->ciclo) {
                $alunos = $alunos
                    ->whereBetween('classes.vc_classe', [1, 6]);
                // dd( $alunos->get());
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [1, 6]);
            } else if ('Ensino Secundário (1º Ciclo)' == $request->ciclo) {
                $alunos = $alunos
                    ->whereBetween('classes.vc_classe', [7, 9]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [7, 9]);

            } else if ('Ensino Secundário (2º Ciclo)' == $request->ciclo) {

                $alunos = $alunos
                    ->whereBetween('classes.vc_classe', [10, 13]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [10, 13]);
                // dd( $data['classes']);

            }
            $data['ciclo'] = $request->ciclo;

        }
        // dd($alunos);
        $filtro_aluno_relatorio = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'ciclo' => $request->ciclo,
        ];

        storeSession('filtro_aluno_relatorio', $filtro_aluno_relatorio);
        $data['alunos'] = $alunos->get();
        // dd(   $data['candidatos']);
        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();


        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        // dd( $data['candidatos'] );
        $mpdf->setHeader();
        $this->loggerData('Imprimiu relatorio de candidatos aceitos');
        $html = view("admin/pdfs/relatorio/candidatos_aceitos/index", $data);

        $mpdf->writeHTML($html);

        $mpdf->Output("listasdCandidaturas.pdf", "I");

    }







    public function matriculados_pesquisar()
    {
        // dd("ola");
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        // $response['turmas'] = fh_turmas()->get();

        return view('admin.relatorio.matriculados.pesquisar.index', $response);

    }
    public function matriculados_imprimir(Request $request)
    {
        // dd(  "L");

        if (!$request->id_curso) {
            $matriculados_relatorio = session()->get('matriculados_relatorio');
            $request->id_curso = $matriculados_relatorio['id_curso'];
        }
        if (!$request->id_ano_lectivo) {
            $matriculados_relatorio = session()->get('matriculados_relatorio');
            $request->id_ano_lectivo = $matriculados_relatorio['id_ano_lectivo'];
        }
        // dd($request->ciclo);
        if (!$request->ciclo) {
            $matriculados_relatorio = session()->get('matriculados_relatorio');
            $request->ciclo = $matriculados_relatorio['ciclo'];
        }

        $data['ano_lectivo'] = 'Todos';

        $data['curso'] = 'Todos';
        $data['ciclo'] = 'Todos';
        $data['classes'] = fh_classes()->get();

        $matriculados = fh_matriculas();
        //    dd($matriculados->get());
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $ano_lectivo = fh_anos_lectivos_publicado()->first();
            // dd($ano_lectivo );
            $data['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
            // dd($request->id_ano_lectivo);
            $matriculados = $matriculados->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }
        // dd($matriculados->get());

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd($matriculados->get(),$request->id_curso);
            $data['curso'] = Curso::find($request->id_curso)->vc_nomeCurso;
            $data['cursos'] = fh_cursos()->where('cursos.id', $request->id_curso)->get();
            $matriculados = $matriculados->where('candidatos.id_curso', $request->id_curso);
        } else {
            $data['cursos'] = fh_cursos()->get();

        }
        // dd($matriculados->get());
        // dd($matriculados);
        // dd( $data['classes']);
        if ($request->ciclo != 'Todos' && $request->ciclo) {
            if ('Ensino Primário' == $request->ciclo) {
                $matriculados = $matriculados
                    ->whereBetween('classes.vc_classe', [1, 6]);
                // dd( $matriculados->get());
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [1, 6]);
            } else if ('Ensino Secundário (1º Ciclo)' == $request->ciclo) {
                $matriculados = $matriculados
                    ->whereBetween('classes.vc_classe', [7, 9]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [7, 9]);

            } else if ('Ensino Secundário (2º Ciclo)' == $request->ciclo) {

                $matriculados = $matriculados
                    ->whereBetween('classes.vc_classe', [10, 13]);
                $data['classes'] = $data['classes']->whereBetween('vc_classe', [10, 13]);
                // dd( $data['classes']);

            }
            $data['ciclo'] = $request->ciclo;

        }
        // dd($matriculados);
        $matriculados_relatorio = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'ciclo' => $request->ciclo,
        ];

        storeSession('matriculados_relatorio', $matriculados_relatorio);
        $data['matriculados'] = $matriculados->get();
        // dd(   $data['candidatos']);
        $data["css"] = file_get_contents('css/lista/style-2.css');
        $data['cabecalho'] = fh_cabecalho();


        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        // dd( $data['candidatos'] );
        $mpdf->setHeader();
        $this->loggerData('Imprimiu relatorio de matriculados ');
        $html = view("admin/pdfs/relatorio/matriculados/index", $data);

        $mpdf->writeHTML($html);

        $mpdf->Output("relatorio-matriculados.pdf", "I");

    }



    public function propinas_aluno_pesquisar()
    {
        // dd("ola");
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        // $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        // $response['turmas'] = fh_turmas()->get();
// dd("o");
        return view('admin.relatorio.proprinas_aluno.pesquisar.index', $response);

    }
    public function propinas_aluno_imprimir(Request $request)
    {
        // dd("o");
        $response['ano_lectivo'] = 'Todos';

        $response['mes'] = 'Todos';
        $response['classe'] = 'Todas';
        // dd($response['classe']);
        if (session()->get('propinas_aluno_relatorio')) {

            if (!$request->id_ano_lectivo) {
                $propinas_aluno_relatorio = session()->get('propinas_aluno_relatorio');
                $request->id_ano_lectivo = $propinas_aluno_relatorio['id_ano_lectivo'];
             
            }
            if (!$request->mes) {
                $propinas_aluno_relatorio = session()->get('propinas_aluno_relatorio');
                $request->mes = $propinas_aluno_relatorio['mes'];
           
            }
            if (!$request->id_classe) {
                $propinas_aluno_relatorio = session()->get('propinas_aluno_relatorio');
                $request->id_classe = $propinas_aluno_relatorio['id_classe'];
            }
            // dd($request->ciclo);

        }
        $propinas_aluno_relatorio = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'mes' => $request->mes,
            'id_classe' => $request->id_classe
        ];
        storeSession('propinas_aluno_relatorio', $propinas_aluno_relatorio);
        $pagamentos = fh_pagamentos();
        // dd( $pagamentos->get());
        $response['mes'] = $request->mes;
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {
            $pagamentos = $pagamentos->where('pagamentos.id_ano_lectivo', $request->id_ano_lectivo);
            $ano_lectivo = fh_anos_lectivos_publicado()->first();

            $response['ano_lectivo'] = $ano_lectivo->ya_inicio . '/' . $ano_lectivo->ya_fim;
        }
        if ($request->mes != 'Todos' && $request->mes) {

            $pagamentos = $pagamentos->where('pagamentos.mes', $request->mes);
            $response['mes'] = $request->mes;
        }
        if ($request->id_classe != 'Todas' && $request->id_classe) {
            // dd(  $matriculas->get(),$request->id_curso);
            // $id_classe = fha_obterNumeroid_classe($request->id_classe);
            // dd($id_classe);

            $pagamentos = $pagamentos->where('tipo_pagamentos.id_classe', $request->id_classe);

            $response['classe'] = Classe::find($request->id_classe)->vc_classe;
        }
        // dd($response['classe']);
        $pagamentos = $pagamentos->get();
        // dd(   $data['candidatos']);
        $response['pagamentos']=$pagamentos;
        // dd(  $response['pagamentos']);
        $response["css"] = file_get_contents('css/lista/style-2.css');
        $response['cabecalho'] = fh_cabecalho();


        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);
        // dd( $data['candidatos'] );
        $mpdf->setHeader();
        $this->loggerData('Imprimiu relatorio de propinas por alunos matriculados ');
        $html = view("admin/pdfs/relatorio/propinas_aluno/index", $response);
       
        $mpdf->writeHTML($html);

        $mpdf->Output("relatorio-propinas_aluno.pdf", "I");

    }















}
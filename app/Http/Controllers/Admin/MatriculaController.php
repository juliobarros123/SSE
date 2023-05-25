<?php

namespace App\Http\Controllers\Admin;

use App\Models\Matricula;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turma;
use App\Models\Alunno;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Estudante;
use Illuminate\Support\Facades\Storage;
use Image;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;


class MatriculaController extends Controller
{
    private $Logger;
    public $retorno = [
        'status' => 1,
        'message' => 'Turma Indisponível',
    ];

    public function __construct()
    {
        $this->retorno;
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }


    public function pesquisar()
    {
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();

        $response['classes'] = fh_classes()->get();
        return view('admin.matriculas.pesquisarMatriculados.index', $response);
    }

    public function pesquisar_pdf()
    {

        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();

        $response['classes'] = fh_classes()->get();
        return view('admin.matriculas.pesquisar_pdf.index', $response);
    }
    public function lista_pdf(Request $request, Estudante $estudantes)
    {
        $response['matriculas'] = $estudantes->StudentForAll($request->vc_anolectivo, $request->vc_curso)->get();

        if ($request->vc_classe != 'Todos') {
            $response['matriculas'] = $response['matriculas']->where('vc_classe', $request->vc_classe);
        }

        $data['curso'] = $request->vc_curso;
        $data['anolectivo'] = $request->vc_anolectivo;
        $data['vc_classe'] = $request->vc_classe;

        $data['alunos'] = $response['matriculas'];
        $data['cabecalho'] = Cabecalho::find(1);
        /* $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */

        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {

            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents(__full_path() . 'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path() . 'css/listas/bootstrap.min.css');
        }


        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $this->loggerData('Imprimiu Lista de Candidatura');
        $html = view("admin/pdfs/listas/matriculas/index", $data);

        $mpdf->writeHTML($html);
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->Output("listasdCandidaturas.pdf", "I");
    }
    public function matriculados(Request $request)
    {
        $matriculas = fh_matriculas();
        if ($request->id_ano_lectivo) {

            $matriculas = $matriculas->where('turmas.it_idAnoLectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso) {
            // dd(  $matriculas->get(),$request->id_curso);
            $matriculas = $matriculas->where('turmas.it_idCurso', $request->id_curso);
        }
        if ($request->id_classe) {
            // dd(  $matriculas->get(),$request->id_curso);
            $matriculas = $matriculas->where('turmas.it_idClasse', $request->id_classe);
        }
        
        $response['matriculas'] = $matriculas->get();
        //   dd($response['matriculas']);
        return view('admin.matriculas.index', $response);

    }
    public function index(Estudante $estudantes, $anoLectivo, $curso, $vc_classe)
    {
        $response['matriculas'] = $estudantes->StudentForAll($anoLectivo, $curso)->orderBy('id', 'asc')->get();

        if ($vc_classe != 'Todos') {
            $response['matriculas'] = $response['matriculas']->where('vc_classe', $vc_classe);
        }
        return view('admin.matriculas.index', $response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cadastrar()
    {
        // $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        // $turmas = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        $response['turmas'] = fh_turmas()->get();
        $response['alunos'] = fh_alunos()->get();
        // dd(fh_ano_lectivo_publicado());
        // dd(  $alunos );
        // $cadastrar = true;
        /*$classes = Classe::where([['it_estado_classe', 1]])->get();
        $cursos = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
        return view('admin.matriculas.cadastrar.index', compact('turmas', 'alunos', 'classes', 'cursos', 'anoLectivo'));*/
        return view('admin.matriculas.cadastrar.index', $response);
    }


    public function salvar(Request $request)
    {




        try {

            //  dd(  $request);
            /* Procura se existe esse dado que esta sendo introduzido na BD,
            se não existe pode introduzir, se existe não introduza */
            $nome_arquivo = null;
            // dd($request);
            $aluno = $aluno = fh_aluno_processo($request->processo);
            ;
            $id_ano_lectivo = fh_ano_lectivo_publicado()->id_anoLectivo;
            $cont = fh_matriculas()->where('alunnos.processo', $aluno->processo)
                ->where('turmas.it_idAnoLectivo', $id_ano_lectivo)->count();
            // dd($cont );

            if ($cont == 0) {
                $dados = $request->all();
                if ($request->hasFile('vc_imagem')) {
                    // dd($request);
                    $image = $request->file('vc_imagem');
                    $input['imagename'] = $request->processo . '_' . fh_cabecalho()->vc_acronimo . '_' . $aluno->id . '.' . $image->extension();
                    $destinationPath = public_path('/images/aluno/');
                    $img = Image::make($image->path())->orientate();
                    $img->resize(333, 310, function ($constraint) {
                    })->save($destinationPath . '/' . $input['imagename']);
                    $dir = "images/aluno/";
                    $dados['vc_imagem'] = $dir . "/" . $input['imagename'];

                }
                $turma = fh_turmas()->where('turmas.id', $request->it_idTurma)->first();


                if (($turma->it_qtdeAlunos - $turma->it_qtMatriculados) <= 0) {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Turma fechada']);
                } else {
                    $matricula = Matricula::create([
                        'id_aluno' => $aluno->id,
                        'it_idTurma' => $request->it_idTurma,
                        'id_cabecalho' => Auth::User()->id_cabecalho
                    ]);

                    if ($matricula) {
                        // dd($dados['vc_imagem']);
                        if (isset($dados['vc_imagem'])) {
                            Alunno::where('alunnos.id', $aluno->id)->update(['vc_imagem' => $dados['vc_imagem']]);
                        }
                        $this->aumentar_inscritos($request->it_idTurma, 1);
                    }

                    $this->loggerData('Matriculou o(a) aluno(a) de processo ' . $request->processo . ' na turma de ' . $turma->vc_nomedaTurma . ' na ' . $turma->vc_classe . 'ª classe no curso de ' . $turma->vc_nomeCurso);
                    return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Matricula efectuada com sucesso']);

                }


            } else {
                /* redirecionar e informar que o selecionado já foi introduzido */
                // dd("ola");
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Aluno já está matriculado neste ano lectivo']);

            }
        } catch (\Exception $exception) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Matricula  $curso
     * @return \Illuminate\Http\Response
     */
    public function ver($id)
    {
        $matricula = Matricula::where([['it_estado_matricula', 1]])->findOrFail($id);
        return view('admin.matriculas.ver.index', compact('matricula'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Matricula  $curso
     * @return \Illuminate\Http\Response
     */
    public function editar($slug)
    {
        $matricula = fh_matriculas()->where('matriculas.slug', $slug)->first();
        // dd($matricula);
        if ($matricula):

            $response['anoslectivos'] = fh_anos_lectivos()->get();
            $response['cursos'] = fh_cursos()->get();
            $response['classes'] = fh_classes()->get();


            $response['turmas'] = fh_turmas()->where('cursos.id', $matricula->it_idCurso)
                ->where('anoslectivos.id', fh_ano_lectivo_publicado()->id_anoLectivo)
                ->where('turmas.it_qtdeAlunos', '>', 0)
                ->get();
            $response['matricula'] = $matricula;

            return view('admin.matriculas.editar.index', $response);
        else:
            return redirect('Admin/matriculas/cadastrar')->with('matricula', '1');

        endif;
    }


    public function diminuir_inscritos($id_turma, $qt)
    {
        $turma = Turma::find($id_turma);
        Turma::find($id_turma)->update([
            'it_qtMatriculados' => $turma->it_qtMatriculados - $qt
        ]);
    }
    public function aumentar_inscritos($id_turma, $qt)
    {
        $turma = Turma::find($id_turma);
        Turma::find($id_turma)->update([
            'it_qtMatriculados' => $turma->it_qtMatriculados + $qt
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Matricula  $curso
     * @return \Illuminate\Http\Response
     */
    public function atualizar(Request $request, $slug)
    {
        try {

            $aluno = fh_aluno_processo($request->processo);

            $id_ano_lectivo = fh_ano_lectivo_publicado()->id_anoLectivo;

            $dados = $request->all();
            $turmae_especifica = Turma::find($request->it_idTurma);
            if ($request->hasFile('vc_imagem')) {
                // dd($request);
                $image = $request->file('vc_imagem');
                $input['imagename'] = $request->processo . '_' . fh_cabecalho()->vc_acronimo . '_' . $aluno->id . '.' . $image->extension();
                $destinationPath = public_path('/images/aluno/');
                $img = Image::make($image->path())->orientate();
                $img->resize(333, 310, function ($constraint) {
                })->save($destinationPath . '/' . $input['imagename']);
                $dir = "images/aluno/";
                $dados['vc_imagem'] = $dir . "/" . $input['imagename'];

            }
            $turma_nova = fh_turmas()->where('turmas.id', $request->it_idTurma)->first();

            $matricula_anterior = fh_matriculas()->where('matriculas.slug', $slug)->first();




            if ($matricula_anterior->it_idTurma == $turma_nova->id) {

                $matricula = Matricula::where('matriculas.slug', $slug)->update([
                    'id_aluno' => $aluno->id,
                    'it_idTurma' => $turma_nova->id
                ]);
                if (isset($dados['vc_imagem'])) {
                    Alunno::where('alunnos.id', $aluno->id)->update(['vc_imagem' => $dados['vc_imagem']]);
                }
                $this->loggerData("Atualizou a matricula do aluno(a) com processo  $request->processo . ' na turma de ' . $turma_nova->vc_nomedaTurma . ' na ' . $turma_nova->vc_classe . 'ª classe no curso de ' . $turma_nova->vc_nomeCurso");
                // dd("sdsd");
                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Matricula actualizada com sucesso']);

            } else if ($turma_nova->it_qtMatriculados >= $turma_nova->it_qtdeAlunos) {

                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Turma fechada']);

            } else {
                // dd($turma_nova);
                $matricula = Matricula::where('matriculas.slug', $slug)->update([
                    'id_aluno' => $aluno->id,
                    'it_idTurma' => $turma_nova->id
                ]);

                if ($matricula) {
                    // dd($dados['vc_imagem']);
                    if (isset($dados['vc_imagem'])) {
                        Alunno::where('alunnos.id', $aluno->id)->update(['vc_imagem' => $dados['vc_imagem']]);
                    }
                    $this->diminuir_inscritos($matricula_anterior->it_idTurma, 1);
                    $this->aumentar_inscritos($turma_nova->id, 1);
                    $this->loggerData("Atualizou a matricula do aluno(a) com processo  $request->processo . ' na turma de ' . $turma_nova->vc_nomedaTurma . ' na ' . $turma_nova->vc_classe . 'ª classe no curso de ' . $turma_nova->vc_nomeCurso");
                    // dd("sdsd");
                    return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Matricula actualizada com sucesso']);
                } else {
                    return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

                }

            }
        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

        }
    }



    public function aumenta_qtAluno($id_turma)
    {

        $turma = Turma::find($id_turma);

        Turma::find($id_turma)->update([
            'it_qtdeAlunos' => $turma->it_qtdeAlunos + 1,
            'it_qtMatriculados' => $turma->it_qtMatriculados - 1
        ]);
        // $qtAluno_actual = $turma->it_qtdeAlunos + 1;

        //  Turma::where([['it_estado_turma', 1]])->find($verificaTurma1->id)->update([
        //             'it_qtdeAlunos' => $qtAluno_actual
        //         ]);
    }

    public function excluir($slug)
    {
        // dd("ola");



        try {
            $matricula = fh_matriculas()->where('matriculas.slug', $slug)->first();
            $response = Matricula::where('matriculas.slug', $slug)->first();

            $m = Matricula::where('matriculas.slug', $slug)->delete();
            if ($m) {
                $this->diminuir_inscritos($matricula->it_idTurma, 1);
                $this->loggerData("Eliminou a matricula do aluno(a) com processo  $matricula->processo . ' na turma de ' . $matricula->vc_nomedaTurma . ' na ' . $matricula->vc_classe . 'ª classe no curso de ' . $matricula->vc_nomeCurso");
                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Matricula eliminada com sucesso']);

            } else {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

        }
    }

    /////pesquisar aluno /////////////////
    public function pesquisaraluno()
    {
        return view('admin.matriculas.pesquisar.index');
    }

    public function recebeAluno(Request $request)
    {
        $id = $request->processo;
        return redirect("/admin/matriculas/emitirboletim/$id");
    }
    //metodo que gera o boletim
    public function emitirboletim(Estudante $estudantes, $id)
    {
        $c = $estudantes->StudentForSearch($id);
        if ($c->count()):

            $data['academicos'] = $c;
            $data['cabecalho'] = Cabecalho::find(1);
            $data['dadosaluno'] = Alunno::where([['it_estado_aluno', 1]])->find($id);
            /*  $data["bootstrap"] = file_get_contents("css/boletim/bootstrap.min.css");
            $data["css"] = file_get_contents("css/boletim/style.css"); */

            if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {

                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path() . 'css/boletim/style.css');
                $data["bootstrap"] = file_get_contents(__full_path() . 'css/boletim/bootstrap.min.css');
            }

            $mpdf = new \Mpdf\Mpdf();
            $mpdf->defaultfooterline = 0;
            $mpdf->setFooter('{PAGENO}');
            $mpdf->SetFont("arial");
            $this->loggerData('Emitiu o boletim do aluno de processo ' . $data['dadosaluno']->id);
            $html = view("admin/pdfs/boletim/index", $data);
            $mpdf->writeHTML($html);
            $mpdf->Output("boletim.pdf", "I");
        else:
            return redirect('admin/matriculas/pesquisar')->with('aviso', 'Não existe Estudante com este número de processo');
        endif;
    }
    public function limpar_duplicidade()
    {
        //   $f=  Matricula::where('id','!=',2)->limit(5)->get();
        //   dd($f);
        $cont1 = 0;
        $matriculas = Matricula::all();
        foreach ($matriculas as $matricula) {

            $count = Matricula::where('id_aluno', $matricula->it_idAluno)
                ->where(
                    'vc_anoLectivo',
                    $matricula->vc_anoLectivo
                )->count();
            if ($count >= 2) {
                $cont1++;
                $id_max = Matricula::where('id_aluno', $matricula->it_idAluno)
                    ->where('vc_anoLectivo', $matricula->vc_anoLectivo)
                    ->max('id');
                $id_max = Matricula::where('id_aluno', $matricula->it_idAluno)
                    ->where('vc_anoLectivo', $matricula->vc_anoLectivo)
                    ->where('id', '!=', $id_max)
                    ->delete();
            }
        }
        if ($cont1) {

            return redirect()->back()->with('duplicidade_limpada', 1);
        } else {
            return redirect()->back()->with('nenhuma_duplicidade', 1);
        }
    }
    public function purgar($id)
    {

        try {

            $response = Matricula::find($id);

            Matricula::where('id', $id)->delete();
            $this->diminuir_inscritos($response->it_idTurma, 1);
            $this->loggerData('Eliminou do(a) aluno(a) de processo ' . Alunno::find($response->it_idAluno)->id);
            return redirect()->back()->with('matricula.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('matricula.purgar.error', '1');
        }
    }

    public function eliminadas()
    {


        $response['users'] = User::where([['it_estado_user', 0]])->get();
        $response['eliminadas'] = "eliminadas";
        return view('admin.users.index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = User::find($id);
            $response->update(['it_estado_user' => 1]);
            $this->loggerData("Recuperou Utilizador");
            return redirect()->back()->with('user.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('user.recuperar.error', '1');
        }
    }
}
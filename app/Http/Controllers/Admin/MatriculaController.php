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
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();

        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        return view('admin.matriculas.pesquisarMatriculados.index', $response);
    }

    public function pesquisar_pdf()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();

        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
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
    public function recebeMatriculados(Request $request)
    {
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        $vc_classe = $request->vc_classe;

        return redirect("Admin/matriculas/listar/$anoLectivo/$curso/$vc_classe");
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
        $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        // $turmas = Turma::where([['it_estado_turma', 1], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        $turmas = Turma::where([['it_estado_turma', 1]])->get();
        $alunos = Alunno::where([['it_estado_aluno', 1]])->get();
        $cadastrar = true;
        /*$classes = Classe::where([['it_estado_classe', 1]])->get();
        $cursos = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
        return view('admin.matriculas.cadastrar.index', compact('turmas', 'alunos', 'classes', 'cursos', 'anoLectivo'));*/
        return view('admin.matriculas.cadastrar.index', compact('turmas', 'alunos', 'anoLectivo', 'cadastrar'));
    }


    public function salvar(Request $request)
    {




        try {

            //  dd(  $request);
            /* Procura se existe esse dado que esta sendo introduzido na BD,
            se não existe pode introduzir, se existe não introduza */
            $nome_arquivo = null;
            $ExisteSelecionado = Matricula::where([
                ['it_estado_matricula', 1],
                ['vc_anoLectivo', $request->vc_anoLectivo],
                ['id_aluno', $request->it_idAluno],
            ])->count();

            if ($ExisteSelecionado == 0) {
                $dados = $request->all();
                // dd( $dados );
                $request->validate([
                    'id_aluno' => 'required',
                    'it_idTurma' => 'required',
                    /*'it_idClasse' => 'required',
                    'it_idCurso' => 'required',*/
                    'vc_anoLectivo' => 'required',
                ]);
                // dd($request->hasFile('vc_imagem'));
                if ($request->hasFile('vc_imagem')) {

                    $image = $request->file('vc_imagem');
                    $input['imagename'] =  $request->it_idAluno . '.' . $image->extension();
                    $destinationPath = public_path('/images/matriculados');
                    $img = Image::make($image->path())->orientate();
                    $img->resize(333, 310, function ($constraint) {
                    })->save($destinationPath . '/' . $input['imagename']);

                    $dir = "images/matriculados";
                    $dados['vc_imagem'] = $dir . "/" . $input['imagename'];
                } else {

                    // dd("ola");
                    $nome_arquivo = basename($request->vc_nameImage);
                    // dd($nome_arquivo);  
                    $origin = public_path("confirmados/$nome_arquivo");
                    if (file_exists($origin)) {
                        $destinationPath = $origin;
                        $image_resize = Image::make($origin)->orientate();
                        // dd("ola",$image_resize);
                        $image_resize->resize(333, 310);
                        $image_resize->save($destinationPath);
                        $dir = "images/matriculados";
                        $dados['vc_imagem'] = $dir . "/" . $nome_arquivo;
                    } else {
                        $destinationPath = public_path("/images/matriculados/$nome_arquivo");
                   
                        $dir = "images/matriculados";
                        $dados['vc_imagem'] = $dir . "/" . $nome_arquivo;
                    }
                   


                }
                // else {


                //     $origin = base_path() . "/public/confirmados/$request->vc_nameImage";
                //     // dd( $origin);
                //     $destinationPath = base_path() . "/public/images/matriculados/$request->vc_nameImage";
                //     dd($destinationPath);
                //     $image_resize = Image::make($origin)->orientate();
                //     $image_resize->resize(333, 310);
                //     $image_resize->save(public_path('/images/matriculados/' . $request->vc_nameImage));
                //     $dir = "images/matriculados";
                //     $dados['vc_imagem'] = $dir . "/" . $request->vc_nameImage;
                // }


                $verificaTurma = Turma::where([['it_estado_turma', 1]])->find($dados['it_idTurma']);
                $incremente = $verificaTurma->it_qtMatriculados + 1;

                $turmae_especifica = Turma::find($request->it_idTurma);

                if ($verificaTurma->it_qtMatriculados >= $verificaTurma->it_qtdeAlunos) {
                    return redirect()->back()->with('alert', '1');
                } else {

                    Turma::where([['it_estado_turma', 1]])->find($verificaTurma->id)->update([
                        'it_qtMatriculados' => $incremente
                    ]);
                    //Matricula::create($dados);

                    //   dd($request);
                    $matricula =   Matricula::create([
                        'id_aluno' =>  $request->it_idAluno,
                        'it_idTurma' => $request->it_idTurma,
                        'it_idClasse' => $turmae_especifica->it_idClasse,
                        'it_idCurso' => $turmae_especifica->it_idCurso,
                        'vc_anoLectivo' => $request->vc_anoLectivo,
                        'vc_imagem' => $dados['vc_imagem']
                    ]);

                    if ($matricula) {
                        Turma::where([['it_estado_turma', 1]])->find($verificaTurma->id)->update([
                            'it_qtMatriculados' => $incremente
                        ]);
                    }

                    $this->loggerData('Matriculou o(a) aluno(a) de processo ' . $request->it_idAluno . ' na turma de ' . Turma::find($request->it_idTurma)->vc_nomedaTurma . ' na ' . Classe::find($turmae_especifica->it_idClasse)->vc_classe . 'ª classe no curso de ' . Curso::find($turmae_especifica->it_idCurso)->vc_nomeCurso);
                    return redirect()->back()->with('status', '1');
                }

                $matricula = Alunno::where([['it_estado_aluno', 1]])->findOrFail($request->input('id'));
                return view('admin.matriculas.ver.index', compact('matricula'))->with('status', '1');
            } else {
                /* redirecionar e informar que o selecionado já foi introduzido */
                dd("ola");
                return redirect()->back()->with('ExisteSelecionado', '1');
            }
        } catch (\Exception $exception) {
            dd($exception);
            return redirect()->back()->with('aviso', '1');
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
    public function editar($id)
    {
        $c = Matricula::where([['it_estado_matricula', 1]])->find($id);
        if ($response['matricula'] = Matricula::where([['it_estado_matricula', 1]])->find($id)) :
            $turmas = Turma::where([['it_estado_turma', 1]])->get();
            $alunos = Alunno::where([['it_estado_aluno', 1]])->get();
            $classes = Classe::where([['it_estado_classe', 1]])->get();
            $cursos = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
            $matricula = Matricula::where([['it_estado_matricula', 1]])->findOrFail($id);
            $turma = Turma::where([['it_estado_turma', 1]])->find($matricula->it_idTurma);
            $aluno = Alunno::where([['it_estado_aluno', 1]])->find($matricula->it_idAluno);
            $classe = Classe::where([['it_estado_classe', 1]])->find($matricula->it_idClasse);
            $curso = Curso::where([['it_estado_curso', 1]])->find($matricula->it_idCurso);
            $anoLectivos = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();

            return view('admin.matriculas.editar.index', compact('matricula', 'turma', 'aluno', 'classe', 'curso', 'alunos', 'turmas', 'classes', 'cursos', 'anoLectivos'));
        else :
            return redirect('Admin/matriculas/cadastrar')->with('matricula', '1');

        endif;
    }


    public function diminuir_inscritos($id_turma, $qt)
    {
        $turma =  Turma::find($id_turma);
        Turma::where([['it_estado_turma', 1]])->find($id_turma)->update([
            'it_qtMatriculados' => $turma->it_qtMatriculados - $qt
        ]);
    }
    public function aumentar_inscritos($id_turma, $qt)
    {
        $turma =  Turma::find($id_turma);
        Turma::where([['it_estado_turma', 1]])->find($id_turma)->update([
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
    public function atualizar(Request $request, $id)
    {


        $dados = $request->all();
        $turmae_especifica = Turma::find($request->it_idTurma);

        if ($request->hasFile('vc_imagem')) {


            $image = $request->file('vc_imagem');
            $input['imagename'] =  $request->it_idAluno . '.' . $image->extension();
            $destinationPath = public_path('/images/matriculados');
            $img = Image::make($image->path())->orientate();
            $img->resize(333, 310, function ($constraint) {
            })->save($destinationPath . '/' . $input['imagename']);

            $dir = "images/matriculados";
            $dados['vc_imagem'] = $dir . "/" . $input['imagename'];

            // $imagem = $request->file('vc_imagem');
            // $num = rand(1111, 9999);
            // $dir = "images/matriculados";
            // $extensao = $imagem->guessClientExtension();
            // $nomeImagem = $dados['id_aluno'] . "_" . $num . "." . $extensao;
            // $imagem->move($dir, $nomeImagem);
            // $dados['vc_imagem'] = $dir . "/" . $nomeImagem;
        } else {
            //dd($request);
            /* $input_input = $request->input_file;
            $ext =  extension_file_string($input_input);
            $distino = "images/matriculados/$request->it_idAluno.$ext";
            $estado = move_file_string($input_input, $distino);
            $dados['vc_imagem'] = $distino; */
        }



        $verificaTurma = Turma::where([['it_estado_turma', 1]])->find($dados['it_idTurma']);

        $verify = Matricula::where([['it_estado_matricula', 1]])->find($id);

        $i = $verificaTurma->it_qtMatriculados;
        $b = $verificaTurma->it_qtMatriculados;
        $incremente = ++$i;
        $decremente = $b--;


        if ($verify->it_idTurma == $verificaTurma->id) {

            Matricula::find($id)->update($dados);
            $this->loggerData('Atualizou a matricula do(a) aluno(a) de processo ' . $request->it_idAluno . ' na turma de ' . Turma::find($request->it_idTurma)->vc_nomedaTurma . ' na ' . Classe::find($turmae_especifica->it_idClasse)->vc_classe . 'ª classe no curso de ' . Curso::find($turmae_especifica->it_idCurso)->vc_nomeCurso);
            // dd("sdsd");

            return redirect()->back()->with('editMatricula', 1);
        } else if ($verificaTurma->it_qtMatriculados >= $verificaTurma->it_qtdeAlunos) {

            return redirect()->back()->with('alert', $this->retorno['message']);
        } else {

            $this->diminuir_inscritos($verify->it_idTurma, 1);
            $this->aumentar_inscritos($verificaTurma->id, 1);
            // Turma::where([['it_estado_turma', 1]])->find($verificaTurma->id)->update([
            //     'it_qtMatriculados' => $incremente
            // ]);
            // Turma::where([['it_estado_turma', 1]])->find($verify->it_idTurma)->update([
            //     'it_qtMatriculados' => $decremente
            // ]);

            // $verificaTurma->it_qtMatriculados 
            $turmae_especifica = Turma::find($request->it_idTurma);
            //dd($turmae_especifica);

            //dd($dados);
            if (isset($dados['vc_imagen'])) {
                Matricula::where([['it_estado_matricula', 1]])->find($id)->update([
                    'id_aluno' =>  $request->it_idAluno,
                    'it_idTurma' => $request->it_idAluno,
                    'it_idClasse' => $turmae_especifica->it_idClasse,
                    'it_idCurso' => $turmae_especifica->it_idCurso,
                    'vc_anoLectivo' => $request->vc_anoLectivo,
                    'vc_imagem' => $dados['vc_imagem']
                ]);
                $this->loggerData('Atualizou a matricula do(a) aluno(a) de processo ' . $request->it_idAluno . ' na turma de ' . Turma::find($request->it_idTurma)->vc_nomedaTurma . ' na ' . Classe::find($turmae_especifica->it_idClasse)->vc_classe . 'ª classe no curso de ' . Curso::find($turmae_especifica->it_idCurso)->vc_nomeCurso);
            } else {

                Matricula::where([['it_estado_matricula', 1]])->find($id)->update([
                    'id_aluno' =>  $request->it_idAluno,
                    'it_idTurma' => $request->it_idTurma,
                    'it_idClasse' => $turmae_especifica->it_idClasse,
                    'it_idCurso' => $turmae_especifica->it_idCurso,
                    'vc_anoLectivo' => $request->vc_anoLectivo,

                ]);
                $this->loggerData('Atualizou a matricula do(a) aluno(a) de processo ' . $request->it_idAluno . ' na turma de ' . Turma::find($request->it_idTurma)->vc_nomedaTurma . ' na ' . Classe::find($turmae_especifica->it_idClasse)->vc_classe . 'ª classe no curso de ' . Curso::find($turmae_especifica->it_idCurso)->vc_nomeCurso);
            }
            return redirect()->back()->with('editMatricula', '1');
        }
        return redirect()->back()->with('editMatricula', '1');
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

    public function excluir($id)
    {
        // dd("ola");



        try {

            $response = Matricula::find($id);

            Matricula::where('id', $id)->delete();
            $this->diminuir_inscritos($response->it_idTurma, 1);
            $this->loggerData('Eliminou do(a) aluno(a) de processo ' . Alunno::find($response->it_idAluno)->id);
            return redirect()->back()->with('matricula.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('matricula.eliminar.error', '1');
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
        if ($c->count()) :

            $data['academicos'] =  $c;
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
        else :
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

            $count =  Matricula::where('id_aluno', $matricula->it_idAluno)
                ->where(
                    'vc_anoLectivo',
                    $matricula->vc_anoLectivo
                )->count();
            if ($count >= 2) {
                $cont1++;
                $id_max =  Matricula::where('id_aluno', $matricula->it_idAluno)
                    ->where('vc_anoLectivo', $matricula->vc_anoLectivo)
                    ->max('id');
                $id_max =  Matricula::where('id_aluno', $matricula->it_idAluno)
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
        return view('admin.users.index',  $response);
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

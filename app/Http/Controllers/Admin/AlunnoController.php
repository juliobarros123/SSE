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

use App\Models\Processo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\AnoLectivo;
use App\Models\Candidatura;
use App\Models\Curso;
use App\Models\Logger;
use App\Models\Candidato2;
use App\Http\Resources\AlunoAdmitidos as AlunoAdmitidosResource;
use Database\Factories\AlunoFactory;
use Image;
use App\Models\Cabecalho;
use App\Models\Classe;
use App\Models\Matricula;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class AlunnoController extends Controller
{
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
        $this->cabecalho = Cabecalho::find(1);
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function getAdmitidos()
    {

        $admitidos = Alunno::all();

        return AlunoAdmitidosResource::collection($admitidos);
    }

    public function pesquisar()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/alunos/pesquisar/index', $response);
    }
    public function recebealunos(Request $request)
    {
        $anoLectivo = $request->vc_anolectivo;
        $curso = $request->vc_curso;

        return redirect("admin/alunos/listar/$anoLectivo/$curso");
    }


    public function listarAlunos($anoLectivo, $curso)
    {
        $response['alunos'] = DB::table('alunnos');

        if ($anoLectivo != 'Todos') {
            $response['alunos'] = $response['alunos']->where('vc_anoLectivo', '=', $anoLectivo);
        }
        if ($curso != 'Todos') {
            $response['alunos'] = $response['alunos']->where('vc_nomeCurso', '=', $curso);
        }
        // dd(  $response['alunos']->get());
        $response['alunos'] = $response['alunos']
            ->where('it_estado_aluno', 1)
            ->orderBy('dt_dataNascimento', 'asc')->get();

        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        // dd( $response['alunos']);
        return view('admin.alunos.index', $response);
    }

    public function recebeBI(Request $request)
    {
        $BI = $request->searchBI;
        return redirect("admin/alunos/trazerCandidato/$BI");
    }
    public function trazerCandidato($BI)
    {
        $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        $alunos = Candidatura::where([['it_estado_candidato', 1], ['id', $BI], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        // $alunosToken = Candidatura::where([['it_estado_candidato', 1], ['id', $token], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();

        //dd($alunos);
        if ($alunos->count()):
            return view("admin.alunos.cadastrar.index", compact("alunos"));
        else:
            return redirect('admin/alunos/cadastrar')->with('aviso', 'Não existe nenhum Candidato com este número de inscrição neste ano lectivo');
        endif;
    }

    public function create()
    {
        return view('admin.alunos.cadastrar.index');
    }

    public function imprimirFicha($id)
    {
        $response['alunno'] = DB::table('alunnos')
            ->leftJoin('matriculas', 'matriculas.it_idAluno', 'alunnos.id')
            ->leftJoin('turmas', 'matriculas.it_idTurma', 'turmas.id')
            ->where([['it_estado_aluno', 1]])
            ->orderBy('matriculas.id', 'desc')
            ->where('alunnos.id', $id)
            ->select('alunnos.id as processo', 'alunnos.*', 'matriculas.*', 'turmas.vc_nomedaTurma')
            ->first();

        $response['dados'] = DB::table('alunnos')->where('it_estado_aluno', 1)->where('id', $id)->get();
        $response['cabecalho'] = $this->cabecalho;
        //dd($response['cabecalho']);


        if ($response['cabecalho'] != null) {

            $mpdf = new \Mpdf\Mpdf();
            /* $response['stylesheet'] = file_get_contents(__full_path().'css/recibo/style.css'); */
            if ($response['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000820440") {

                //$url = 'cartões/Quilumosso/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $response['stylesheet'] = file_get_contents(__full_path() . 'css/recibo/style.css');
            }
            $html = view("admin/pdfs/alunno/ficha", $response);
            $mpdf->writeHTML($html);
            $this->loggerData('Imprimiu Ficha do Aluno(a)' . $response['alunno']->vc_primeiroNome . ' ' . $response['alunno']->vc_nomedoMeio . ' ' . $response['alunno']->vc_ultimoaNome);
            $mpdf->Output("ficha.pdf", "I");
        } else {
            return redirect()->back();
        }
    }



    // public function transferir($id)
    // {

    //     $candidato2 = Candidato2::find($id);

    //     try {
    //         $aluno = Alunno::create([
    //             'id' => $candidato2->id,
    //             'vc_primeiroNome' => $candidato2->vc_primeiroNome,
    //             'vc_nomedoMeio' => $candidato2->vc_nomedoMeio,
    //             'vc_ultimoaNome' => $candidato2->vc_apelido,
    //             'it_classe' => $candidato2->vc_classe,

    //             'dt_dataNascimento' => $candidato2->dt_dataNascimento,
    //             'vc_naturalidade' => $candidato2->vc_naturalidade,
    //             'vc_provincia' => $candidato2->vc_provincia,
    //             'vc_namePai' => $candidato2->vc_namePai,
    //             'vc_nameMae' => $candidato2->vc_nameMae,
    //             'vc_dificiencia' => $candidato2->vc_dificiencia,
    //             'vc_estadoCivil' => $candidato2->vc_estadoCivil,
    //             'vc_genero' => $candidato2->vc_genero,
    //             'it_telefone' => $candidato2->it_telefone,
    //             'vc_email' => $candidato2->vc_email,
    //             'vc_residencia' => $candidato2->vc_residencia,
    //             'vc_bi' => $candidato2->vc_bi,
    //             'dt_emissao' => $candidato2->dt_emissao,
    //             'vc_EscolaAnterior' => $candidato2->vc_EscolaAnterior,
    //             'ya_anoConclusao' => $candidato2->ya_anoConclusao,
    //             'vc_nomeCurso' => $candidato2->vc_nomeCurso,
    //             'vc_anoLectivo' => $candidato2->vc_anoLectivo,
    //             'it_classe' => $candidato2->vc_classe,
    //             'vc_localEmissao' => $candidato2->vc_localEmissao,
    //             'tokenKey' => $candidato2->tokenKey,
    //             'it_processo' => 0,
    //             'tokenKey' => 'não utilizado',
    //             'it_media' => $candidato2->it_media,
    //         ]);
    //         if ($aluno) {
    //             Candidato2::find($id)->update(['it_processo' => 1]);
    //             $this->loggerData("Transferiu Selecionado a Matricula" . $candidato2->vc_primeiroNome . '' . $candidato2->vc_nomedoMeio . '' . $candidato2->vc_apelido);
    //             return  response()->json($id);
    //         }
    //     } catch (\Exception $exception) {

    //         return  response()->json("ola");
    //     }
    // }


    public function transferir($id)
    {

        $candidato2 = Candidato2::find($id);
        try {
            $processo = Processo::orderBy('id', 'desc')->where('it_estado_processo', 1)->first();
            //  dd($processo);

            $aluno = Alunno::create([
                'id' => $processo->it_processo + 1,
                'vc_primeiroNome' => $candidato2->vc_primeiroNome,
                'vc_nomedoMeio' => $candidato2->vc_nomedoMeio,
                'vc_ultimoaNome' => $candidato2->vc_ultimoaNome,
                'it_classe' => $candidato2->vc_classe,

                'dt_dataNascimento' => $candidato2->dt_dataNascimento,
                'vc_naturalidade' => $candidato2->vc_naturalidade,
                'vc_provincia' => $candidato2->vc_provincia,
                'vc_namePai' => $candidato2->vc_namePai,
                'vc_nameMae' => $candidato2->vc_nameMae,
                'vc_dificiencia' => $candidato2->vc_dificiencia,
                'vc_estadoCivil' => $candidato2->vc_estadoCivil,
                'vc_genero' => $candidato2->vc_genero,
                'it_telefone' => $candidato2->it_telefone,
                'vc_email' => $candidato2->vc_email,
                'vc_residencia' => $candidato2->vc_residencia,
                'vc_bi' => $candidato2->vc_bi,
                'dt_emissao' => $candidato2->dt_emissao,
                'vc_EscolaAnterior' => $candidato2->vc_EscolaAnterior,
                'ya_anoConclusao' => $candidato2->ya_anoConclusao,
                'vc_nomeCurso' => $candidato2->vc_nomeCurso,
                'vc_anoLectivo' => $candidato2->vc_anoLectivo,
                'it_classe' => $candidato2->it_classe,
                'vc_localEmissao' => $candidato2->vc_localEmissao,
                'tokenKey' => $candidato2->tokenKey,
                'it_processo' => 0,
                'tokenKey' => 'não utilizado',
                'it_media' => $candidato2->it_media,
            ]);

            Processo::find($processo->id)->update(['it_processo' => $processo->it_processo + 1]);

            Candidato2::find($id)->update(['it_estado_aluno' => 1]);
            Candidato2::find($id)->update(['it_processo' => 1]);
            if ($aluno) {

                $this->loggerData("Adicionou Selecionado a Matricula" . $candidato2->vc_primeiroNome . '' . $candidato2->vc_nomedoMeio . '' . $candidato2->vc_apelido);
                // return redirect()->back()->with('up', '1');
                return response()->json($id);
            }
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
            return redirect()->back()->with('aviso', '1');
        }
    }

    // public function cadastrar($request)
    // {
    //     try {
    //         $aluno = Alunno::insert([
    //             'id' => $request->id,
    //             'vc_primeiroNome' => $request->vc_primeiroNome,
    //             'vc_nomedoMeio' => $request->vc_nomedoMeio,
    //             'vc_ultimoaNome' => $request->vc_apelido,
    //             'it_classe' => $request->vc_classe,

    //             'dt_dataNascimento' => $request->dt_dataNascimento,
    //             'vc_naturalidade' => $request->vc_naturalidade,
    //             'vc_provincia' => $request->vc_provincia,
    //             'vc_namePai' => $request->vc_nomePai,
    //             'vc_nameMae' => $request->vc_nomeMae,
    //             'vc_dificiencia' => $request->vc_dificiencia,
    //             'vc_estadoCivil' => $request->vc_estadoCivil,
    //             'vc_genero' => $request->vc_genero,
    //             'it_telefone' => $request->it_telefone,
    //             'vc_email' => $request->vc_email,
    //             'vc_residencia' => $request->vc_residencia,
    //             'vc_bi' => $request->vc_bi,
    //             'dt_emissao' => $request->dt_emissao,
    //             'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
    //             'ya_anoConclusao' => $request->ya_anoConclusao,
    //             'vc_nomeCurso' => $request->vc_nomeCurso,
    //             'vc_anoLectivo' => $request->vc_anoLectivo,
    //             'it_classe' => $request->vc_classe,
    //             'vc_localEmissao' => $request->vc_localEmissao,
    //             'tokenKey' => $request->tokenKey,

    //             'it_media' => $request->it_media,
    //         ]);
    //         if ($aluno) {
    //             $this->loggerData("Adicionou o(a) Aluno(a) " . $request->vc_primeiroNome . '' . $request->vc_nomedoMeio . '' . $request->vc_apelido);
    //             return redirect('admin/alunos/cadastrar')->with('status', '1');
    //         }
    //     } catch (\Exception $exception) {
    //         return redirect()->back()->with('aviso', '1');
    //     }
    // }
    public function actualizar_classe()
    {
        $alunos2 = Alunno::get();
        foreach ($alunos2 as $aluno) {
            if ($aluno->vc_bi) {
                $alunos1 = Alunno::where([['vc_bi', $aluno->vc_bi]])->get();
                // dd( $alunos1);
                if (count($alunos1) >= 2) {

                    $bi = $alunos1[0]->vc_bi;

                    $response = Http::withHeaders([
                        'Authorization' => 'Basic d3MuYWRtY2F6ZW5nYTptZm4zNDYwODIwMjI=',
                        'Content-Type' => 'application/json'
                    ])->get("https://sifphml.minfin.gov.ao/sigt/contribuinte/instituicao/v4/obter?tipoDocumento=NIF&numeroDocumento=$bi");

                    $response = $response->json();
                    // dd($response,$alunos1);

                    if (!($response['ObterContribuinte']['mensagem'] == "Nao ha dados para o filtro informado.")) {
                        if (isset($response['ObterContribuinte']['contribuinte'])) {
                            $p_nome = explode(' ', $aluno->vc_primeiroNome)[0];
                            $p_nome_bi = explode(' ', $response['ObterContribuinte']['contribuinte']['denominacao'])[0];


                            $p_ultimo = explode(' ', $aluno->vc_ultimoaNome)[count(explode(' ', $aluno->vc_ultimoaNome)) - 1];
                            // dd(  $aluno->vc_ultimoaNome);
                            $array_name = explode(' ', $response['ObterContribuinte']['contribuinte']['denominacao']);

                            // dd($array_name);
                            // dd(explode(' ', $response['ObterContribuinte']['contribuinte']['denominacao'])[ count($array_name)-1]);
                            $p_ultimo_bi = explode(' ', $response['ObterContribuinte']['contribuinte']['denominacao'])[count($array_name) - 1];
                            // if($alunos1[0]->vc_bi=='006212085LA048'){
                            //     dd($p_nome_bi, $p_nome, $p_ultimo,$p_ultimo_bi,$alunos1,$response['ObterContribuinte']['contribuinte']['denominacao'] ); 
                            // }
                            if ((strtoupper($p_nome_bi) == strtoupper($p_nome)) || (strtoupper($p_ultimo) == strtoupper($p_ultimo_bi))) {
                                // dd("i", $aluno);
                                $id_aluno = $aluno->id;
                                $als = Alunno::get();
                                foreach ($alunos1 as $aluno3) {
                                    if ($aluno3->vc_bi == $bi && $aluno3->id != $id_aluno) {
                                        $cod = uniqid(date('HisYmd'));
                                        $bi = substr($cod, -9, 10);
                                        Alunno::find($aluno3->id)->update(
                                            [
                                                'vc_bi' => $bi . 'FAKE'
                                            ]
                                        );
                                    }
                                }
                            }
                        }
                    } else {
                        foreach ($alunos1 as $aluno3) {

                            $cod = uniqid(date('HisYmd'));
                            $bi = substr($cod, -9, 10);
                            Alunno::find($aluno3->id)->update(
                                [
                                    'vc_bi' => $bi . 'FAKE'
                                ]
                            );
                        }
                    }
                }
            } else {
                // caso bi null
                // dd("ola");
                $cod = uniqid(date('HisYmd'));
                $bi = substr($cod, -9, 10);
                Alunno::find($aluno->id)->update(
                    [
                        'vc_bi' => $bi . 'FAKE'
                    ]
                );
            }
        }

        // dd("f");
        $alunos2 = Alunno::where('vc_bi', 'like', '0000%')->get();
        // dd($alunos2);

        foreach ($alunos2 as $aluno) {
            $cod = uniqid(date('HisYmd'));
            $bi = substr($cod, -9, 10);

            Alunno::find($aluno->id)->update(
                [

                    'vc_bi' => $bi . 'FAKE'
                ]
            );
        }

        $alunos = Alunno::all();
        foreach ($alunos as $aluno) {

            $m = Matricula::where('id_aluno', $aluno->id)->orderBy('id', 'desc')->first();
            if ($aluno->vc_bi) {
                if ($m) {
                    $classe = Classe::find($m->it_idClasse);
                    Alunno::find($aluno->id)->update(
                        [
                            'it_classe' => $classe->vc_classe
                        ]
                    );
                }
            } else {
                //  dd($m);

                // dd( $bi);
                if (isset($m->it_idClasse)) {
                    $classe = Classe::find($m->it_idClasse);
                }
                Alunno::find($aluno->id)->update(
                    [
                        'it_classe' => isset($classe) ? $classe->vc_classe : '',
                        'vc_bi' => $bi . 'FAKE'
                    ]
                );
            }
        }
        return redirect()->back()->with('classe', 1);
    }

    public function edit($id)
    {
        if ($response['aluno'] = Alunno::find($id)):
            $response['cursos'] = Curso::where('it_estado_curso', 1)->get();
            return view('admin.alunos.editar.index', $response);
        else:
            return redirect('admin/alunos/cadastrar')->with('aluno', '1');

        endif;
    }

    public function update(Request $request, $id)
    { //dd($request->id);
        //dd(Alunno::where('id',$request->id)->get());
        //dd($request);

        //   try {
        //dd("Sim0");
        if ($request->hasFile('vc_imagem')) {

            $image = $request->file('vc_imagem');
            $input['imagename'] = $request->id . '.' . $image->extension();

            $destinationPath = public_path('/confirmados');

            $img = Image::make($image->path())->orientate();
            ;


            $img->resize(333, 310, function ($constraint) {
            })->save($destinationPath . '/' . $input['imagename']);
            //dd("Sim");

            $dir = "images/confirmados";
            $dados['vc_imagem'] = $dir . "/" . $input['imagename'];

            Alunno::where('id', $id)->update([
                'id' => $request->id,
                'vc_primeiroNome' => $request->vc_primeiroNome,
                'vc_nomedoMeio' => $request->vc_nomedoMeio,
                'vc_ultimoaNome' => $request->vc_apelido,
                'it_classe' => $request->vc_classe,

                'dt_dataNascimento' => $request->dt_dataNascimento,
                'vc_naturalidade' => $request->vc_naturalidade,
                'vc_provincia' => $request->vc_provincia,
                'vc_namePai' => $request->vc_nomePai,
                'vc_nameMae' => $request->vc_nomeMae,
                'vc_dificiencia' => $request->vc_dificiencia,
                'vc_estadoCivil' => $request->vc_estadoCivil,
                'vc_genero' => $request->vc_genero,
                'it_telefone' => $request->it_telefone,
                'vc_email' => $request->vc_email,
                'vc_residencia' => $request->vc_residencia,
                'vc_bi' => $request->vc_bi,
                'dt_emissao' => $request->dt_emissao,
                'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                'ya_anoConclusao' => $request->ya_anoConclusao,
                'vc_nomeCurso' => $request->vc_nomeCurso,
                'vc_anoLectivo' => $request->vc_anoLectivo,
                'it_classe' => $request->vc_classe,
                'vc_localEmissao' => $request->vc_localEmissao,
                'it_media' => $request->it_media,
                'foto' => $input['imagename'],

            ]);
            $this->loggerData("Atualizou o(a) Aluno(a)" . $request->vc_primeiroNome . '' . $request->vc_nomedoMeio . '' . $request->vc_apelido);
            return redirect()->back()->with('editarAluno', 2);
        } else {
            //dd("não ");
            Alunno::where('id', $id)->update([
                'id' => $request->id,
                'vc_primeiroNome' => $request->vc_primeiroNome,
                'vc_nomedoMeio' => $request->vc_nomedoMeio,
                'vc_ultimoaNome' => $request->vc_apelido,
                'it_classe' => $request->vc_classe,

                'dt_dataNascimento' => $request->dt_dataNascimento,
                'vc_naturalidade' => $request->vc_naturalidade,
                'vc_provincia' => $request->vc_provincia,
                'vc_namePai' => $request->vc_nomePai,
                'vc_nameMae' => $request->vc_nomeMae,
                'vc_dificiencia' => $request->vc_dificiencia,
                'vc_estadoCivil' => $request->vc_estadoCivil,
                'vc_genero' => $request->vc_genero,
                'it_telefone' => $request->it_telefone,
                'vc_email' => $request->vc_email,
                'vc_residencia' => $request->vc_residencia,
                'vc_bi' => $request->vc_bi,
                'dt_emissao' => $request->dt_emissao,
                'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                'ya_anoConclusao' => $request->ya_anoConclusao,
                'vc_nomeCurso' => $request->vc_nomeCurso,
                'vc_anoLectivo' => $request->vc_anoLectivo,
                'it_classe' => $request->vc_classe,
                'vc_localEmissao' => $request->vc_localEmissao,
                'it_media' => $request->it_media,
            ]);
            $this->loggerData("Atualizou o(a) Aluno(a)" . $request->vc_primeiroNome . '' . $request->vc_nomedoMeio . '' . $request->vc_apelido);
            return redirect()->back()->with('editarAluno', 2);
        }


        //} catch (\Exception $exception) {
        //    return redirect()->back()->with('aviso', '1');
        // }
    }

    public function delete($id)
    {
        try {
           
          
        $response = Alunno::find($id);
        $response->update(['it_estado_aluno' => 0]);

        $this->loggerData("Eliminou Aluno" . $response->vc_primeiroNome . '' . $response->vc_nomedoMeio . '' . $response->vc_apelido);
            return redirect()->back()->with('aluno.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('aluno.eliminar.error', '1');
        }
    }

    public function pulgar($id)
    {


       /*  try { */

            $response = Alunno::find($id);
            Alunno::where('id', $id)->delete();
            $this->loggerData("Purgou Aluno" . $response->vc_primeiroNome . '' . $response->vc_nomedoMeio . '' . $response->vc_apelido);
            return redirect()->back()->with('aluno.purgar.success', '1');
        /* } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('aluno.purgar.error', '1');
        } */
    }
    public function cidadao($bi)
    {


        /* $response = Http::get("https://api.gov.ao/consultarBI/v2/?bi=$bi");
        $data = $response->json();
        return $data; */
        if (strlen($bi) == 14) {

            $bi = "$bi";

            $response = Http::withHeaders([
                'Authorization' => 'Basic d3MuYWRtY2F6ZW5nYTptZm4zNDYwODIwMjI=',
                'Content-Type' => 'application/json'
            ])->get("https://sifphml.minfin.gov.ao/sigt/contribuinte/instituicao/v4/obter?tipoDocumento=NIF&numeroDocumento=$bi");

            $data = $response->object();
            return $data;
        } else {
            return false;
        }
    }




    public function eliminadas()
    {



        $response['alunos'] = DB::table('alunnos');
        $response['alunos'] = $response['alunos']
            ->where('it_estado_aluno', 0)
            ->orderBy('dt_dataNascimento', 'asc')->get();


        $response['eliminadas'] = "eliminadas";
        return view('admin.alunos.index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = Alunno::find($id);
            $response->update(['it_estado_aluno' => 1]);
    
            $this->loggerData("Recuperou Aluno" . $response->vc_primeiroNome . '' . $response->vc_nomedoMeio . '' . $response->vc_apelido);
            return redirect()->back()->with('aluno.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('aluno.recuperar.error', '1');
        }
    }
}
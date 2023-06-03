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
        $response['anoslectivos'] = fh_anos_lectivos()->get();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();

        return view('admin/alunos/pesquisar/index', $response);
    }
    public function aluno($processo)
    {
        try {
            $turmas = [];
            $aluno = fha_aluno_processo($processo);

            if ($aluno) {
                $turmas = fh_turmas()->where('cursos.id', $aluno->id_curso)
                    ->where('anoslectivos.id', fha_ano_lectivo_publicado()->id_anoLectivo)
                    ->where('turmas.it_qtdeAlunos', '>', 0)
                    ->get();
            }

            return response()->json(['aluno' => $aluno, 'turmas' => $turmas]);
        } catch (\Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }
    public function importar()
    {
        //envia os cursos e classes para popular os selects
        $response['cursos'] = fh_cursos()->get();
        // dd(   $response['cursos']);
        $response['classes'] = fh_classes()->get();
        // dd($response['classes']);
        $response['idadesdecandidaturas'] = fh_idadedeCandidatura()->orderby('id', 'desc')->first();

        $response['cabecalho'] = fh_cabecalho();
        $response['provincias'] = fh_provincias()->get();
        return view('admin.alunos.importar.index', $response);
    }
    function generateRandomString($size = 9)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
        $randomString = '';
        for ($i = 0; $i < $size; $i = $i + 1) {
            $randomString .= $chars[mt_rand(0, 60)];
        }
        return $randomString;
    }
    public function cadastrar(Request $request)
    {

        // dd($request);
        try {
            // $Z = Candidatura::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi], ])->count();

            // if ($Z == 0) {

            // $vezes = Candidatura::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi]])->count();

            //rotina que cadastra o formulário

            $processo_actual = fh_processo_actual()->first();
            if ($processo_actual) {
                if ($processo_actual->it_processo < $request->processo) {
                    return redirect()->back()->with('feedback', ['error' => 'success', 'sms' => 'O processo deve ser inferior ao último processo']);
                }
            } else {
                return redirect()->back()->with('feedback', ['error' => 'success', 'sms' => 'Antes, cadastre o último processo que a escola registou']);

            }

            $c = fha_aluno_processo($request->processo);
            if ($c) {
                return redirect()->back()->with('feedback', ['error' => 'success', 'sms' => 'Já tem um aluno usando este processo']);
            }
            $candidatura = Candidatura::create([
                'vc_primeiroNome' => $request->vc_primeiroNome,
                'vc_nomedoMeio' => $request->vc_nomedoMeio,
                'vc_apelido' => $request->vc_apelido,
                'dt_dataNascimento' => $request->dt_dataNascimento,
                'vc_nomePai' => $request->vc_nomePai,
                'vc_nomeMae' => $request->vc_nomeMae,
                'vc_genero' => $request->vc_genero,
                "LP_S" => $request->LP_S,
                "LP_O" => $request->LP_O,
                "LP_N" => $request->LP_N,
                "MAT_S" => $request->MAT_S,
                "MAT_O" => $request->MAT_O,
                "MAT_N" => $request->MAT_N,
                "FIS_S" => $request->FIS_S,
                "FIS_O" => $request->FIS_O,
                "FIS_N" => $request->FIS_N,
                "QUIM_S" => $request->QUIM_S,
                "QUIM_O" => $request->QUIM_O,
                "QUIM_N" => $request->QUIM_N,

                'vc_dificiencia' => $request->vc_dificiencia,
                'vc_estadoCivil' => $request->vc_estadoCivil,
                'it_telefone' => $request->it_telefone ? $request->it_telefone : '000' . cod(6),
                'vc_email' => $request->vc_email,
                'tokenKey' => $this->generateRandomString(),
                'vc_residencia' => $request->vc_residencia,
                'vc_naturalidade' => $request->vc_naturalidade,
                'vc_provincia' => $request->vc_provincia,
                'vc_bi' => $request->vc_bi,
                'media' => $request->media,
                'tipo_candidato' => 'Comun',
                'it_estado_candidato' => "1",
                'dt_emissao' => $request->dt_emissao,
                'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                'vc_localEmissao' => $request->vc_localEmissao,
                'vc_vezesdCandidatura' => 1,
                'id_cabecalho' => id_cabecalho_user(Auth::User()->id),
                'id_classe' => $request->id_classe,
                'id_curso' => isset($request->id_curso) ? $request->id_curso :
                fh_cursos()->first()->id,
                'id_ano_lectivo' => fh_ultimo_ano_lectivo()->id
            ]);

            Alunno::create([
                'processo' => $request->processo,
                'tipo_aluno' => 'Importado',
                'id_candidato' => $candidatura->id,
                'id_cabecalho' => Auth::User()->id_cabecalho,
                'vc_imagem' => 'images/aluno/avatar.png'
            ]);



            $this->loggerData("Importou aluno com processo  $request->processo ");
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Importação efectuada com sucesso']);


        } catch (\Exception $exception) {
            dd($exception->getMessage());
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);

            // return redirect()->back()->with('aviso', '1');

        }
    }
    public function ver(Request $request)
    {

        $alunos = fh_alunos();
        // dd($alunos->get());
        if (session()->get('filtro_aluno')) {
            if (!$request->id_curso) {
                $filtro_aluno = session()->get('filtro_aluno');
                $request->id_curso = $filtro_aluno['id_curso'];
            }
            if (!$request->id_ano_lectivo) {
                $filtro_aluno = session()->get('filtro_aluno');
                $request->id_ano_lectivo = $filtro_aluno['id_ano_lectivo'];
            }
            if (!$request->id_classe) {
                $filtro_aluno = session()->get('filtro_aluno');
                $request->id_classe = $filtro_aluno['id_classe'];
            }
        }
        if ($request->id_ano_lectivo != 'Todos' && $request->id_ano_lectivo) {

            $alunos = $alunos->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso != 'Todos' && $request->id_curso) {
            // dd( $alunos->get(),$request->id_curso);
            $alunos = $alunos->where('candidatos.id_curso', $request->id_curso);
        }
        if ($request->id_classe != 'Todas' && $request->id_classe) {
            // dd($candidados->get(),$request->id_classe);


            $alunos = $alunos->where('candidatos.id_classe', $request->id_classe);
        }
        $data = [
            'id_ano_lectivo' => $request->id_ano_lectivo,
            'id_curso' => $request->id_curso,
            'id_classe' => $request->id_classe
        ];
        storeSession('filtro_aluno', $data);
        $response['alunos'] = $alunos->get();
        // dd( $response['alunos']);

        $response['anolectivo'] = request('id_ano_lectivo');
        $response['curso'] = request('id_curso');

        return view('admin.alunos.index', $response);
    }


    public function listarAlunos($anoLectivo, $curso)
    {
        dd("Ola");
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




    public function create()
    {
        return view('admin.alunos.cadastrar.index');
    }






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

    public function delete($slug)
    {
        try {


            $response = fh_aluno_slug($slug);
            // dd( $response );
            fh_alunos()->where('alunnos.slug', $slug)->delete();

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
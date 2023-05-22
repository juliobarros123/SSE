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
use App\Models\Candidatura;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Http\Requests\CandidaturaRequest;
use App\Models\Activador_da_candidatura;
use App\Models\AnoLectivo;
use App\Models\IdadedeCandidatura;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use App\Models\PermissaoDeSelecao;
use App\Models\Candidato2;
use App\Models\Pre_candidato;
use Exception;
use Illuminate\Support\Facades\Auth;

class CandidaturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Logger;
    public $provincia;
    public function __construct()
    {
        $this->provincia = [
            ['nome' => 'Bengo'],
            ['nome' => 'Benguela'],
            ['nome' => 'Bié'],
            ['nome' => 'Cabinda'],
            ['nome' => 'Cunene'],
            ['nome' => 'Huambo'],
            ['nome' => 'Huíla'],
            ['nome' => 'Kuando Kubango'],
            ['nome' => 'Kwanza Norte'],
            ['nome' => 'Kwanza Sul'],
            ['nome' => 'Luanda'],
            ['nome' => 'Lunda Norte'],
            ['nome' => 'Lunda Sul'],
            ['nome' => 'Malange'],
            ['nome' => 'Moxico'],
            ['nome' => 'Namibe'],
            ['nome' => 'Uíge'],
            ['nome' => 'Zaire']
        ];
        $this->cabecalho = Cabecalho::find(1);
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    public function pesquisar()
    {

        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderBy('ya_inicio', 'desc')->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        //dd($response);
        return view('admin/candidatura/pesquisar/index', $response);
    }
    public function recebecandidaturas(Request $request)
    {
        $anoLectivo = $request->vc_anolectivo;
        $curso = $request->vc_curso;

        $response = $this->index($anoLectivo, $curso);
        //dd($response);
        if (isset($request->nota_unica11) && $request->nota_unica11 != "null" && $request->tipo_filtro == "1") {
            $response['candidatos'] = $this->fl_uma_nota($response, $request->nota_unica11);
        } else
            if (isset($request->idade_unica12) && $request->idade_unica12 != "null" && $request->tipo_filtro == "2") {

                $response['candidatos'] = $this->fl_uma_idade($response, $request->idade_unica12);
            } else if (isset($request->nota_unica13) && $request->nota_unica13 != "null" && isset($request->idade_unica13) && $request->idade_unica13 != "null" && $request->tipo_filtro == "3") {

                $idade_unica = $request->idade_unica13;
                $nota_unica = $request->nota_unica13;
                $response['candidatos'] = $this->listarAdmitidos_por_nota_por_idade($response, $idade_unica, $nota_unica);
            } else if (isset($request->idade1) && $request->idade1 != "null" && isset($request->idade2) && $request->idade2 != "null" && $request->tipo_filtro == "4") {
                $idade1 = $request->idade1;
                $idade2 = $request->idade2;
                $response['candidatos'] = $this->fl_intervalode_idade($response, $idade1, $idade2);
                // return redirect("admin/admitidos/listar/por_intervalode_idade/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2");
            } else if (isset($request->idade51) && $request->idade51 != "null" && isset($request->idade52) && $request->idade52 != "null" && isset($request->nota_unica5) && $request->nota_unica5 != "null" && $request->tipo_filtro == "5") {
                $idade1 = $request->idade51;
                $idade2 = $request->idade52;
                $nota_unica = $request->nota_unica5;
                $response['candidatos'] = $this->por_intervalode_idade_nota($response, $idade1, $idade2, $nota_unica);
            }











        // for($cont=0;$cont<50;$cont++)
        // {

        // // echo "(default, 'Marcos$cont', 'Joao Caferico', 'Jamba', '2002-12-10', 'Joao Neto Jamba', 'Sara Pedro Caferico', 'Masculino', 'Não', 'Casado(a)', '930491733', 'elcaffrey9.2@gmail.com', 'Luanda - Rangel', 'Ambriz', 'Bengo', '007818445BO04$cont', '2021-07-27', 'Bengo', 'Colegio Publico No 117 Ambriz', '2019', 'Informática', '10', '2020-2021', 1, 0, 'b5X5NM0j1', '2021-07-27 10:19:52', '2021-08-10 07:40:26', 10, 11, 10, 10, 10, 14, 11, 10, 12, 10, 15, 13, 0, 11, 0),";
        // }
        // foreach ($response['candidatos'] as $response) {
        //     echo $response->id;
        // }
        //dd($response);

        return view('admin/candidatura/listar/index', $response);
    }



    public function por_intervalode_idade_nota($response, $idade1, $idade2, $nota_unica)
    {

        $response['candidatos'] = $this->fl_intervalode_idade($response, $idade1, $idade2);

        $response = $this->fl_uma_nota($response, $nota_unica);
        return $response;
    }


    public function fl_intervalode_idade($response, $idade1, $idade2)
    {

        //   $selecionados1 = $selecionados->where('idade', '>=', $idade1);
        //   $selecionados1 = $selecionados1->where('idade', '<=', $idade2);
        $selecionados_filter = collect();

        foreach ($response as $s) {

            foreach ($s as $s) {

                $idade = date('Y') - date('Y', strtotime($s->dt_dataNascimento));

                if ($idade >= $idade1 && $idade <= $idade2) {
                    $selecionados_filter->push($s);
                }
                //   if(date('Y') - date('Y', strtotime($s->dt_dataNascimento)) )
            }
        }
        $selecionados_filter->all();
        return $selecionados_filter;
    }

    public function fl_uma_nota($selecionados, $nota_unica)
    {
        $selecionados_filter = collect();

        foreach ($selecionados['candidatos'] as $s) {

            if ($s->media == $nota_unica) {
                $selecionados_filter->push($s);
            }
        }


        return $selecionados_filter;
    }



    public function fl_uma_idade($selecionados, $idade_unica)
    {
        //   $selecionados_filter=  $selecionados->where('idade',$idade_unica);
        $selecionados_filter = collect();
        foreach ($selecionados as $s) {
            foreach ($s as $s) {
                $idade = date('Y') - date('Y', strtotime($s->dt_dataNascimento));

                if ($idade == $idade_unica) {
                    $selecionados_filter->push($s);
                }
                //   if(date('Y') - date('Y', strtotime($s->dt_dataNascimento)) )
            }
        }
        $selecionados_filter->all();

        return $selecionados_filter;
    }

    public function listarAdmitidos_por_nota_por_idade($response, $idade_unica, $nota_unica)
    {
        $response['candidatos'] = $this->fl_uma_idade($response, $idade_unica);
        $response['candidatos'] = $this->fl_uma_nota($response, $nota_unica);
        return $response['candidatos'];
    }

    public $response1;
    public function index($anoLectivo, $curso)
    {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo],
                ['vc_nomeCurso', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['candidatos'] = Candidatura::where([
                ['it_estado_candidato', 1],
                ['vc_nomeCurso', '=', $curso]
            ])->get();
        } else {

            // $response['candidatos'] = DB::table('candidatos')->simplePaginate(15);
            // global $response;
            // $response=array();
            // $response['candidatos'] =    DB::table('candidatos')->orderBy('id', 'desc')->where('it_estado_candidato', 1)->chunk(5000, function ($candidatos) {

            //         $this->response1 = $candidatos;

            //     //    return $candidatos;
            // });

            // // dd($this->response1);

            // $response['candidatos'] = Candidatura::where([['it_estado_candidato', 1]])->get();
            $response['candidatos'] = collect(DB::table('candidatos')->where('it_estado_candidato', 1)->select('id', 'vc_primeiroNome', 'vc_apelido', 'vc_bi', 'vc_nomedoMeio', 'vc_nomeCurso', 'dt_dataNascimento', 'vc_vezesdCandidatura', 'created_at', 'vc_genero', 'media', 'it_telefone', 'it_estado_candidato', 'state')->get());
        }


        return $response;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $activador = Activador_da_candidatura::orderby('id', 'desc')->first();
        if ($activador->it_estado == 1) {
            //envia os cursos e classes para popular os selects
            $response['cursos'] = fh_cursos()->get();
            // dd(   $response['cursos']);
            $response['classes'] = fh_classes()->get();
            // dd($response['classes']);
            $response['idadesdecandidaturas'] = fh_idadedeCandidatura()->orderby('id', 'desc')->first();
            // $response['anoLectivo'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();

            $response['cabecalho'] = fh_cabecalho();
            $response['provincias'] = fh_provincias()->get();
            // dd($response['provincias']);
            return view('site/candidatura', $response);
        } else {
            return redirect('site')->with('activadoroff', '1');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    function generateRandomString($size = 9)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
        $randomString = '';
        for ($i = 0; $i < $size; $i = $i + 1) {
            $randomString .= $chars[mt_rand(0, 60)];
        }
        return $randomString;
    }

    public function store(Request $request)
    {
        // dd("ola");

        try {
            $Z = Candidatura::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi], ['vc_anoLectivo', $request->vc_anoLectivo]])->count();

            if ($Z == 0) {

                $vezes = Candidatura::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi]])->count();

                //rotina que cadastra o formulário
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
                    'media' => $media,

                    'it_estado_candidato' => "1",
                    'dt_emissao' => $request->dt_emissao,
                    'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                    'ya_anoConclusao' => $request->ya_anoConclusao,
                    'vc_nomeCurso' => $request->vc_nomeCurso,
                    'vc_classe' => $request->vc_classe,
                    'vc_localEmissao' => $request->vc_localEmissao,
                    'vc_vezesdCandidatura' => $vezes + 1,
                    'id_cabecalho' => id_cabecalho_user(Auth::User()->id),
                    'id_classe' => $request->id_classe,
                    'id_curso' => isset($request->id_curso) ? $request->id_curso :
                    fh_cursos()->first()->id,
                    'id_ano_lectivo' => fh_ultimo_ano_lectivo()->id
                ]);



                $this->loggerData("Adicionou Candidatura");
                return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Candidatura efectuada com sucesso']);


            } else {

                return redirect('site')->with('aviso', '1');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);

            // return redirect()->back()->with('aviso', '1');

        }
    }
    public function selecionar($candidatura, $request)
    {


        return Candidato2::create([

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
            'tokenKey' => $request->tokenKey,
            'it_media' => $candidatura->media,
            'idade' => date('Y') - date('Y', strtotime($request->dt_dataNascimento))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function imprimirFicha($id)
    {
        $response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id);
        $response['cabecalho'] = $this->cabecalho;
        // dd($response);
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

            $html = view("admin/pdfs/candidatura/ficha", $response);
            $mpdf->writeHTML($html);
            $this->loggerData('Imprimiu Ficha do Candidato(a)' . $response['candidato']->vc_primeiroNome . ' ' . $response['candidato']->vc_nomedoMeio . ' ' . $response['candidato']->vc_Apelido);
            $mpdf->Output("ficha.pdf", "I");
        } else {
            return redirect('candidatos');
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $c = Candidatura::where([['it_estado_candidato', 1]])->find($id);
        if ($response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id)):
            $response['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
            $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
            $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
            $response['provincias'] = $this->provincia;
            return view('admin/candidatura/editar/index', $response);
        else:
            return redirect('candidatos/pesquisar')->with('teste', '1');

        endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $media = ((($request->LP_S + $request->LP_O + $request->LP_N) / 3) + (($request->MAT_S + $request->MAT_O + $request->MAT_N) / 3) + (($request->FIS_S + $request->FIS_O + $request->FIS_N) / 3) + (($request->QUIM_S + $request->QUIM_O + $request->QUIM_N) / 3)) / 4;
        // dd($media);
        try {
            $response = Candidatura::find($id)->update([
                'vc_primeiroNome' => $request->vc_primeiroNome,
                'vc_nomedoMeio' => $request->vc_nomedoMeio,
                'vc_apelido' => $request->vc_apelido,
                'dt_dataNascimento' => $request->vc_datanascimento,
                'vc_nomePai' => $request->vc_nomePai,
                'vc_nomeMae' => $request->vc_nomeMae,
                'vc_genero' => $request->vc_genero,
                'vc_dificiencia' => $request->vc_dificiencia,
                'vc_estadoCivil' => $request->vc_estadoCivil,
                'it_telefone' => $request->it_telefone,
                'vc_email' => $request->vc_email,
                'media' => $media,

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

                'vc_residencia' => $request->vc_residencia,
                'vc_naturalidade' => $request->vc_naturalidade,
                'vc_provincia' => $request->vc_provincia,
                'vc_bi' => $request->vc_bi,
                'dt_emissao' => $request->dt_emissao,
                'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                'ya_anoConclusao' => $request->ya_anoConclusao,
                'vc_nomeCurso' => $request->vc_nomeCurso,
                'vc_classe' => $request->vc_classe,
                'vc_localEmissao' => $request->vc_localEmissao
            ]);
            if ($response) {
                $this->loggerData('Actualizou o(a) Candidato(a)' . $request->vc_primeiroNome . ' ' . $request->vc_nomedoMeio . ' ' . $request->vc_Apelido);

                $this->Logger->Log('info', 'Actualizou Candidatura');
                return redirect("candidatos/{$id}/edit")->with('status', '1');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }


    public function eliminar($id)
    { /*
     $response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id);
     $response['cursos'] = Curso::where([['it_estado_curs




     o', 1]])->get();
     $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
     $response['provincias'] = $this->provincia;
     $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
     return view('admin/candidatura/eliminar/index', $response);*/

        $response = Candidatura::find($id);
        $response->update(['it_estado_candidato' => 0]);
        $this->loggerData('Eliminou o(a) Candidato(a)' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);
        return redirect()->back();
    }
    public function pulgar($id)
    {

        try {
            $response = Candidatura::find($id);
            Candidatura::where('id', $id)->delete();
            Pre_candidato::where('vc_bi', $response->vc_bi)->update(['state' => 1]);
            $this->loggerData('Purgou o(a) Candidato(a)' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);

            return redirect()->back()->with('candidato.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('candidato.purgar.error', '1');
        }
    }


    public function destroy($id)
    {

        //Candidatura::find($id)->delete();
        $response = Candidatura::find($id);
        $response->update(['it_estado_candidato' => 0]);
        $this->loggerData('Eliminou o(a) Candidato(a)' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);
        return redirect('candidatos/pesquisar');
    }
    /**
     * visualiza the specified resource from storage.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function visualizar($id)
    {

        $response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id);
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        $response['provincias'] = $this->provincia;
        $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
        return view('admin/candidatura/visualizar/index', $response);
    }

    public function transferir($id)
    {

        $candidatura = Candidatura::find($id);
        $cont = Candidato2::where('vc_bi', $candidatura->vc_bi)->where('it_estado_aluno', 1)->count();

        try {
            // $processo=Processo::find(1);
            if (!$cont) {
                $candidato = Candidato2::create([
                    'vc_primeiroNome' => $candidatura->vc_primeiroNome,
                    'vc_nomedoMeio' => $candidatura->vc_nomedoMeio,
                    'vc_ultimoaNome' => $candidatura->vc_apelido,
                    'it_classe' => $candidatura->vc_classe,

                    'dt_dataNascimento' => $candidatura->dt_dataNascimento,
                    'vc_naturalidade' => $candidatura->vc_naturalidade,
                    'vc_provincia' => $candidatura->vc_provincia,
                    'vc_namePai' => $candidatura->vc_nomePai,
                    'vc_nameMae' => $candidatura->vc_nomeMae,
                    'vc_dificiencia' => $candidatura->vc_dificiencia,
                    'vc_estadoCivil' => $candidatura->vc_estadoCivil,
                    'vc_genero' => $candidatura->vc_genero,
                    'it_telefone' => $candidatura->it_telefone,
                    'vc_email' => $candidatura->vc_email,
                    'vc_residencia' => $candidatura->vc_residencia,
                    'vc_bi' => $candidatura->vc_bi,
                    'dt_emissao' => $candidatura->dt_emissao,
                    'vc_EscolaAnterior' => $candidatura->vc_EscolaAnterior,
                    'ya_anoConclusao' => $candidatura->ya_anoConclusao,
                    'vc_nomeCurso' => $candidatura->vc_nomeCurso,
                    'vc_anoLectivo' => $candidatura->vc_anoLectivo,
                    'it_classe' => $candidatura->vc_classe,
                    'vc_localEmissao' => $candidatura->vc_localEmissao,
                    'tokenKey' => $candidatura->tokenKey,
                    'it_processo' => 0,
                    'tokenKey' => 'não utilizado',
                    'it_media' => $candidatura->it_media,
                ]);


                // Processo::find(1)->update(['it_processo'=>$aluno->id]);
                $response = Candidatura::find($id);
                $candidato = Candidatura::find($id)->update(['state' => 0]);
                if ($candidato) {
                    $this->loggerData('Adicionou o(a) Selecionado(a) a Matricula ' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);
                    return redirect()->back()->with('up', '1');
                }
            } else {
                return redirect()->back()->with('error', '1');
            }
        } catch (\Exception $exception) {

            return redirect()->back()->with('aviso', '1');
        }
    }

    public function admitir($id)
    {
        try {
            $candidatura = Candidatura::find($id);
            $cont = Candidato2::where('vc_bi', $candidatura->vc_bi)->where('it_estado_aluno', 1)->count();

            if (!$cont && $candidatura) {
                Candidato2::create([
                    'vc_primeiroNome' => $candidatura->vc_primeiroNome,
                    'vc_nomedoMeio' => $candidatura->vc_nomedoMeio,
                    'vc_ultimoaNome' => $candidatura->vc_apelido,
                    'it_classe' => $candidatura->vc_classe,
                    'dt_dataNascimento' => $candidatura->dt_dataNascimento,
                    'vc_naturalidade' => $candidatura->vc_naturalidade,
                    'vc_provincia' => $candidatura->vc_provincia,
                    'vc_namePai' => $candidatura->vc_nomePai,
                    'vc_nameMae' => $candidatura->vc_nomeMae,
                    'vc_dificiencia' => $candidatura->vc_dificiencia,
                    'vc_estadoCivil' => $candidatura->vc_estadoCivil,
                    'vc_genero' => $candidatura->vc_genero,
                    'it_telefone' => $candidatura->it_telefone,
                    'vc_email' => $candidatura->vc_email,
                    'vc_residencia' => $candidatura->vc_residencia,
                    'vc_bi' => $candidatura->vc_bi,
                    'dt_emissao' => $candidatura->dt_emissao,
                    'vc_EscolaAnterior' => $candidatura->vc_EscolaAnterior,
                    'ya_anoConclusao' => $candidatura->ya_anoConclusao,
                    'dt_anoCandidatura' => date('Y-m-d', strtotime($candidatura->created_at)),
                    'vc_nomeCurso' => $candidatura->vc_nomeCurso,
                    'vc_anoLectivo' => $candidatura->vc_anoLectivo,
                    'it_classe' => $candidatura->vc_classe,
                    'vc_localEmissao' => $candidatura->vc_localEmissao,
                    'tokenKey' => $candidatura->tokenKey,
                    'it_processo' => 0,
                    'tokenKey' => 'não utilizado',
                    'it_media' => $candidatura->media,
                    'idade' => date('Y') - date('Y', strtotime($candidatura->dt_dataNascimento))
                ]);
            }


            $candidatos = Candidatura::find($id)->update(['state' => 0]);
            if ($candidatos) {

                $candidatura_new = Candidatura::find($id);
                $response = Candidatura::find($id);

                $this->loggerData('Adicionou o(a) Selecionado(a) a Matricula ' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);
                return response()->json($candidatura_new);
            }
        } catch (Exception $ex) {
            return response()->json($ex->getMessage());
        }
    }

    public function filtro()
    {


        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderBy('ya_inicio', 'desc')->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/candidatura/pesquisar/filtro/index', $response);
    }

    public function filtro_cadidatos(Request $request)
    {
        $anoLectivo = $request->vc_anolectivo;
        $curso = $request->vc_curso;
        // return redirect("candidaturas/listar/$anoLectivo/$curso");
        $response = $this->index($anoLectivo, $curso);


        $idade1 = $request->idade51;
        $idade2 = $request->idade52;
        $request->nota_unica5;

        $response[' '] = $this->fl_intervalode_idade($response, $idade1, $idade2);
        $response['candidatos'] = $this->fl_uma_nota_opcional($response, $request->nota_unica5, '>=');
        $response['candidatos'] = $this->fl_uma_nota_opcional($response, $request->nota_unica6, '<=');

        $response['candidatos'] = $response['candidatos']->where('state', 1);
        //else{
        //     return redirect("admin/admitidos/listar/$anoLectivo/$curso/");
        // }


        // $response['candidatos']= DB::table('candidatos')->orderBy('id')->cursorPaginate(15);

        return view('admin/candidatura/listar/index', $response);
    }

    public function fl_uma_nota_opcional($selecionados, $nota_unica, $op)
    {
        $selecionados_filter = collect();

        foreach ($selecionados['candidatos'] as $s) {
            if ($op == '>') {
                if ($s->media > $nota_unica) {
                    $selecionados_filter->push($s);
                }
            }

            if ($op == '>=') {
                if ($s->media >= $nota_unica) {
                    $selecionados_filter->push($s);
                }
            }
            if ($op == '<=') {
                if ($s->media <= $nota_unica) {
                    $selecionados_filter->push($s);
                }
            }
            if ($op == '<') {
                if ($s->media < $nota_unica) {
                    $selecionados_filter->push($s);
                }
            }
            if ($op == '==') {
                if ($s->media < $nota_unica) {
                    $selecionados_filter->push($s);
                }
            }
        }


        return $selecionados_filter;
    }


    // public function fl_uma_idade_opcional($selecionados, $idade_unica,$op)
    // {
    //     //   $selecionados_filter=  $selecionados->where('idade',$idade_unica);
    //     $selecionados_filter = collect();
    //     foreach ($selecionados as $s) {
    //         foreach ($s as $s) {
    //             $idade = date('Y') - date('Y', strtotime($s->dt_dataNascimento));
    //              if( $op=='>'){
    //             if ($idade >$idade_unica) {
    //                 $selecionados_filter->push($s);
    //             }
    //         }
    //         if( $op=='<'){
    //             if ($idade<$idade_unica) {
    //                 $selecionados_filter->push($s);
    //             }
    //         }

    //         if( $op=='='){
    //             if ($idade==$idade_unica) {
    //                 $selecionados_filter->push($s);
    //             }
    //         }
    //             //   if(date('Y') - date('Y', strtotime($s->dt_dataNascimento)) )
    //         }
    //     }
    //     $selecionados_filter->all();

    //     return $selecionados_filter;
    // }

    public function purgar($id)
    {
        try {
            //User::find($id)->delete();
            $response = User::find($id);
            $response2 = User::find($id)->delete();
            $this->loggerData("Purgou o Utilizador");
            return redirect()->back()->with('candidato.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('candidato.purgar.error', '1');
        }
    }


    public function eliminadas()
    {
        $this->loggerData("Listou os usuarios eliminados");

        $response['candidatos'] = collect(DB::table('candidatos')->where('it_estado_candidato', 0)->select('id', 'vc_primeiroNome', 'vc_apelido', 'vc_bi', 'vc_nomedoMeio', 'vc_nomeCurso', 'dt_dataNascimento', 'vc_vezesdCandidatura', 'created_at', 'vc_genero', 'media', 'it_telefone', 'it_estado_candidato', 'state')->get());


        $response['eliminadas'] = "eliminadas";
        return view('admin/candidatura/listar/index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = Candidatura::find($id);
            $response->update(['it_estado_candidato' => 1]);
            $this->loggerData('Recuperou o(a) Candidato(a)' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_Apelido);
            return redirect()->back()->with('candidato.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('candidato.recuperar.error', '1');
        }
    }

}
<?php

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
use App\Http\Resources\InscricaoOnline as InscricaoOnlineResource;
use Illuminate\Support\Facades\Auth;

use App\Models\Pre_candidato;
use Exception;

class PreCandidatoController extends Controller
{
    //

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
        return view('admin/pre_candidatura/pesquisar/index', $response);
    }
    public function recebecandidaturas(Request $request)
    {
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        // return redirect("candidaturas/listar/$anoLectivo/$curso");
        $response =  $this->index($anoLectivo, $curso);

        if (isset($request->nota_unica11) && $request->nota_unica11 != "null" &&  $request->tipo_filtro == "1") {
            $response['candidatos'] =  $this->fl_uma_nota($response, $request->nota_unica11);
        } else 
     if (isset($request->idade_unica12) && $request->idade_unica12 != "null" && $request->tipo_filtro == "2") {

            $response['candidatos'] =  $this->fl_uma_idade($response, $request->idade_unica12);
        } else if (isset($request->nota_unica13) && $request->nota_unica13 != "null" && isset($request->idade_unica13) && $request->idade_unica13 != "null" && $request->tipo_filtro == "3") {

            $idade_unica = $request->idade_unica13;
            $nota_unica = $request->nota_unica13;
            $response['candidatos'] = $this->listarAdmitidos_por_nota_por_idade($response, $idade_unica, $nota_unica);
        } else if (isset($request->idade1) && $request->idade1 != "null" && isset($request->idade2) && $request->idade2 != "null" &&  $request->tipo_filtro == "4") {
            $idade1 = $request->idade1;
            $idade2 = $request->idade2;
            $response['candidatos'] =   $this->fl_intervalode_idade($response, $idade1, $idade2);
            // return redirect("admin/admitidos/listar/por_intervalode_idade/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2");
        } else if (isset($request->idade51) && $request->idade51 != "null" && isset($request->idade52) && $request->idade52 != "null" && isset($request->nota_unica5) && $request->nota_unica5 != "null" && $request->tipo_filtro == "5") {
            $idade1 = $request->idade51;
            $idade2 = $request->idade52;
            $nota_unica = $request->nota_unica5;
            $response['candidatos'] =   $this->por_intervalode_idade_nota($response, $idade1, $idade2, $nota_unica);
        }
        //else{
        //     return redirect("admin/admitidos/listar/$anoLectivo/$curso/");
        // }

        return view('admin/pre_candidatura/listar/index', $response);
    }



    public function por_intervalode_idade_nota($response, $idade1, $idade2, $nota_unica)
    {

        $response['candidatos'] =  $this->fl_intervalode_idade($response, $idade1, $idade2);

        $response =  $this->fl_uma_nota($response, $nota_unica);
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
        return   $selecionados_filter;
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
        $response['candidatos'] =  $this->fl_uma_idade($response, $idade_unica);
        $response['candidatos'] =  $this->fl_uma_nota($response, $nota_unica);
        return  $response['candidatos'];
    }
    public function index($anoLectivo, $curso)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['candidatos'] = Pre_candidato::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso]
            ])->get();
        } elseif ($anoLectivo && !$curso) {
            $response['candidatos'] = Pre_candidato::where([
                ['it_estado_candidato', 1],
                ['vc_anoLectivo', '=', $anoLectivo]
            ])->get();
        } elseif (!$anoLectivo && $curso) {
            $response['candidatos'] = Pre_candidato::where([
                ['it_estado_candidato', 1],
                ['vc_nomeCurso', '=', $curso]
            ])->get();
        } else {
            $response['candidatos'] = Pre_candidato::where([['it_estado_candidato', 1]])->get();
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
            $response['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
            $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
            $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
            $response['anoLectivo'] =  AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();

            $response['cabecalho'] = $this->cabecalho;
            $response['provincias'] = $this->provincia;
            return view('site/pre_candidatura', $response);
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

    public function store(CandidaturaRequest $request)
    {

        $media = ($request->LP_S + $request->LP_O + $request->LP_N + $request->MAT_S + $request->MAT_O + $request->MAT_N + $request->FIS_S + $request->FIS_O + $request->FIS_N + $request->QUIM_S + $request->QUIM_O + $request->QUIM_N) / 12;


        try {
            $Z = Pre_candidato::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi], ['vc_anoLectivo', $request->vc_anoLectivo]])->count();

            if ($Z == 0) {

                $vezes = Pre_candidato::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi]])->count();

                //rotina que cadastra o formulário
                $candidatura = Pre_candidato::create([
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
                    'it_telefone' => $request->it_telefone,
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
                    'vc_anoLectivo' => $request->vc_anoLectivo,
                    'vc_vezesdCandidatura' => $vezes + 1
                ]);


                //responde se a candidatura foi efectuada com sucesso
                if ($candidatura) {
                    $permissao_de_selecao = PermissaoDeSelecao::orderBy('id', 'desc')->first();


                    //   if( $media>=$permissao_de_selecao->nota && $request->dt_dataNascimento>=$permissao_de_selecao->dt_nascimento){
                    if ($media >= $permissao_de_selecao->nota && $request->dt_dataNascimento <= $permissao_de_selecao->dt_nascimento) {
                        $resultSet =  $this->selecionar($candidatura, $request);

                        if ($resultSet) {
                            Pre_candidato::find($candidatura->id)->update(['state' => 0]);
                        }
                    } else {
                    }

                    $this->loggerData('Adicionou a Pre Candidatura');
                    return redirect('site')->with('status', '1');
                }
            } else {

                return redirect('site')->with('aviso', '1');
            }
        } catch (\Exception $exception) {

            return redirect()->back()->with('aviso', '1');
        }
    }
    public function selecionar($candidatura, $request)
    {


        return  Candidato2::create([

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
        $response['candidato'] = Pre_candidato::where([['it_estado_candidato', 1]])->find($id);
        $response['cabecalho'] = $this->cabecalho;
        // dd($response);
        if ($response['cabecalho'] != null) {

            $mpdf = new \Mpdf\Mpdf();
            /* $response['stylesheet'] = file_get_contents(__full_path().'css/recibo/style.css'); */

            if ($response['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');

            } else if ($response['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            } else if ($response['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
             } else if ($response['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            }else if ($response['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $response["stylesheet"] = file_get_contents(__full_path().'css/recibo/style.css');
                $response["bootstrap"] = file_get_contents(__full_path().'css/recibo/bootstrap.min.css');
            }
            $html = view("admin/pdfs/pre_candidatura/ficha", $response);
            $mpdf->writeHTML($html);
            $this->loggerData('Imprimiu Ficha do(a) Candidato(a) ' . $response['candidato']->vc_primeiroNome . ' ' . $response['candidato']->vc_nomedoMeio . ' ' . $response['candidato']->vc_apelido);
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
        $c = Pre_candidato::where([['it_estado_candidato', 1]])->find($id);
        if ($response['candidato'] = Pre_candidato::where([['it_estado_candidato', 1]])->find($id)) :
            $response['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
            $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
            $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
            $response['provincias'] = $this->provincia;
            return view('admin/candidatura/editar/index', $response);
        else :
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
            $response = Pre_candidato::find($id)->update([
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
                $this->loggerData('Actualizou o(a) Candidato(a) ' . $request->vc_primeiroNome . ' ' . $request->nomedoMeio . ' ' . $request->vc_apelido);
                return redirect("candidatos/{$id}/edit")->with('status', '1');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }


    public function eliminar($id)
    {/*
        $response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id);
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        $response['provincias'] = $this->provincia;
        $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
        return view('admin/pre_candidatura/eliminar/index', $response);*/

        $response = Pre_candidato::find($id);
        $response->update(['it_estado_candidato' => 0]);
        $this->loggerData('Eliminou o(a) Candidato(a) ' . $response->vc_primeiroNome . ' ' . $response->nomedoMeio . ' ' . $response->vc_apelido);

        return redirect()->back();
    }
    public function pulgar($id)
    {
        $response = Pre_candidato::find($id);
        Pre_candidato::where('id', $id)->delete();
        $this->loggerData('Purgou o(a) Candidato(a) ' . $response->vc_primeiroNome . ' ' . $response->nomedoMeio . ' ' . $response->vc_apelido);

        return redirect()->back();
    }


    public function destroy($id)
    {

        //pre_candidatura::find($id)->delete();
        $response = Pre_candidato::find($id);
        $response->update(['it_estado_candidato' => 0]);
        $this->loggerData('Eliminou o(a) Candidato(a) ' . $response->vc_primeiroNome . ' ' . $response->nomedoMeio . ' ' . $response->vc_apelido);
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

        $response['candidato'] = Pre_candidato::where([['it_estado_candidato', 1]])->find($id);
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        $response['provincias'] = $this->provincia;
        $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
        return view('admin/pre_candidatura/visualizar/index', $response);
    }


    public function admitir($id)
    {
try{
        $candidatura = Pre_candidato::find($id);
        return response()->json( $candidatura );
        $cont = Candidatura::where('vc_bi', $candidatura->vc_bi)->where('it_estado_candidato', 1)->count();

        if (!$cont && $candidatura) {
            Candidatura::create([
                'vc_primeiroNome' => $candidatura->vc_primeiroNome,
                'vc_nomedoMeio' => $candidatura->vc_nomedoMeio,
                'vc_apelido' => $candidatura->vc_apelido,
                'vc_classe' => $candidatura->vc_classe,
                'dt_dataNascimento' => $candidatura->dt_dataNascimento,
                'vc_naturalidade' => $candidatura->vc_naturalidade,
                'vc_provincia' => $candidatura->vc_provincia,
                'vc_nomePai' => $candidatura->vc_nomePai,
                'vc_nomeMae' => $candidatura->vc_nomeMae,
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
                'vc_classe' => $candidatura->vc_classe,
                'vc_localEmissao' => $candidatura->vc_localEmissao,
                'tokenKey' => $candidatura->tokenKey,
                'it_processo' => 0,
                'vc_vezesdCandidatura' => $candidatura->vc_vezesdCandidatura,
                'tokenKey' => $candidatura->tokenKey,
                'media' => $candidatura->media,

                "LP_S" => $candidatura->LP_S,
                "LP_O" => $candidatura->LP_O,
                "LP_N" => $candidatura->LP_N,
                "MAT_S" => $candidatura->MAT_S,
                "MAT_O" => $candidatura->MAT_O,
                "MAT_N" => $candidatura->MAT_N,
                "FIS_S" => $candidatura->FIS_S,
                "FIS_O" => $candidatura->FIS_O,
                "FIS_N" => $candidatura->FIS_N,
                "QUIM_S" => $candidatura->QUIM_S,
                "QUIM_O" => $candidatura->QUIM_O,
                "QUIM_N" => $candidatura->QUIM_N,

                'idade' => date('Y') - date('Y', strtotime($candidatura->dt_dataNascimento))
            ]);
        }


        $candidatos = Pre_candidato::find($id)->update(['state' => 0]);
        if ($candidatos) {

            $candidatura_new = Pre_candidato::find($id);
            $response = Pre_candidato::find($id);
            $this->loggerData('Selecionou o(a) Candidato(a) ' . $response->vc_primeiroNome . ' ' . $response->nomedoMeio . ' ' . $response->vc_apelido.' a matricula');
            return response()->json($candidatura_new);
        }
    }catch(Exception $ex){
        return response()->json($ex->getMessage());

    }
    }

    public function getInscritos()
    {
        $candidatos = Candidatura::all();
        return InscricaoOnlineResource::collection($candidatos);
    }
    public function indexAPI(Request $request)
    {

        $endereco_ws = "https://www.itel.gov.ao/api/inscritos/take";
        // abre a conexão
        $ch = curl_init();

        // define url
        curl_setopt($ch, CURLOPT_URL, $endereco_ws);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // executa o post
        $resultado = curl_exec($ch);

        if (curl_error($ch)) {
            echo 'Erro:' . curl_error($ch);
            return false;
        }

        // dd($this->generateRandomString());
        // fecha a conexão
        curl_close($ch);

        $anoLectivo = AnoLectivo::where('it_estado_anoLectivo', [1])->first();

        $data = (array) json_decode($resultado);
        // dd($data);
        foreach ($data as $a) {
            $data = Pre_candidato::where("vc_bi", $a->BI)->first();
            if ($data === null) {
                Pre_candidato::create([
                    "vc_primeiroNome" => $a->FirstName,
                    "vc_nomedoMeio" => $a->SecondName,
                    "vc_apelido" => $a->SurName,
                    "dt_dataNascimento" => $a->Born,
                    "vc_nomePai" => $a->Father,
                    "vc_nomeMae" => $a->Mother,
                    "vc_genero" => $a->Sexo,
                    "vc_dificiencia" => $a->Dificience,
                    "vc_estadoCivil" => $a->EstadoCivil,
                    "vc_email" => $a->CellMail,
                    "vc_residencia" => $a->Residence,
                    "vc_naturalidade" => $a->Naturality,
                    "vc_provincia" => $a->Naturality,
                    "vc_bi" => $a->BI,
                    "dt_emissao" => $a->date_inscrito,
                    "vc_localEmissao" => $a->Naturality,
                    "vc_EscolaAnterior" => $a->Oldschool,
                    "ya_anoConclusao" => $a->Graduate,
                    "vc_nomeCurso" => $a->Course,
                    "vc_classe" => $a->media,
                    "vc_anoLectivo" => $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim,
                    "it_estado_candidato" => "1",
                    "vc_vezesdCandidatura" => "0",
                    "it_telefone" => $a->CellPhone,
                    "tokenKey" => $a->tokenKey,
                    "LP_S" => $a->LP_S,
                    "LP_O" => $a->LP_O,
                    "LP_N" => $a->LP_N,
                    "MAT_S" => $a->MAT_S,
                    "MAT_O" => $a->MAT_O,
                    "MAT_N" => $a->MAT_N,
                    "FIS_S" => $a->FIS_S,
                    "FIS_O" => $a->FIS_O,
                    "FIS_N" => $a->FIS_N,
                    "QUIM_S" => $a->QUIM_S,
                    "QUIM_O" => $a->QUIM_O,
                    "QUIM_N" => $a->QUIM_N,
                    "estado_de_pagamento" => $a->estado_de_pagamento,
                    "media" => $a->media,

                ]);
            }
        }

        return redirect()->back();
    }
}

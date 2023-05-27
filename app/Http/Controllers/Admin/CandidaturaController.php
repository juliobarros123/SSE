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
use App\Models\Alunno;
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

    public function __construct()
    {
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
        //dd($response)
        // dd(  $response['cursos']);
        return view('admin/candidatura/pesquisar/index', $response);
    }
    public function recebecandidaturas(Request $request)
    {
        $candidados = fh_candidatos();
        // dd(  $candidados ->get());
        // dd($request);
        if ($request->id_ano_lectivo) {

            $candidados = $candidados->where('candidatos.id_ano_lectivo', $request->id_ano_lectivo);
        }

        if ($request->id_curso) {
            // dd($candidados->get(),$request->id_curso);
            $candidados = $candidados->where('candidatos.id_curso', $request->id_curso);
        }

        $response['candidatos'] = $candidados->get();
        // dd(  $response['candidatos']);
        //      dd( $request->id_ano_lectivo,
//    $request->id_curso);
        // fh_candidatos
// dd($anoLectivo);
        // $response = $this->index($anoLectivo, $curso);
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
            $Z = Candidatura::where([['it_estado_candidato', 1], ['vc_bi', $request->vc_bi], ])->count();

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
                    'media' => $request->media,
                    'tipo_candidato'=>'Comun',
                    'it_estado_candidato' => "1",
                    'dt_emissao' => $request->dt_emissao,
                    'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
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
            // dd($exception->getMessage());
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Erro. Por favor, preencha os campos corretamente.']);

            // return redirect()->back()->with('aviso', '1');

        }
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function imprimirFicha($slug)
    {
        $response['candidato'] = fh_candidato_slug($slug);
        $response['cabecalho'] = fh_cabecalho();
        // dd($response['candidato']);
        $mpdf = new \Mpdf\Mpdf();
        $response['stylesheet'] = file_get_contents('css/recibo/style.css');
        $html = view("admin/pdfs/candidatura/ficha", $response);
        $mpdf->writeHTML($html);
        $this->loggerData('Imprimiu Ficha do Candidato(a)' . $response['candidato']->vc_primeiroNome . ' ' . $response['candidato']->vc_nomedoMeio . ' ' . $response['candidato']->vc_apelido);
        $mpdf->Output("ficha.pdf", "I");
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $response['candidato'] = fh_candidato_slug($slug);
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        $response['idadesdecandidaturas'] = fh_idadedeCandidatura()->get();
        $response['provincias'] = fh_provincias()->get();
        // dd($response['provincias']);
        return view('admin/candidatura/editar/index', $response);
        // if ($response['candidato'] = Candidatura::where([['it_estado_candidato', 1]])->find($id)):
        //     $response['cursos'] = Curso::where([['it_estado_curso', 1], ['it_estadodoCurso', 1]])->get();
        //     $response['classes'] = Classe::where([['it_estado_classe', 1]])->get();
        //     $response['idadesdecandidaturas'] = IdadedeCandidatura::where([['it_estado_idadedecandidatura', 1]])->orderby('id', 'desc')->first();
        //     $response['provincias'] = $this->provincia;

        // else:
        //     return redirect('candidatos/pesquisar')->with('teste', '1');

        // endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {


        try {
            $response = Candidatura::where('slug', $slug)->update([
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
                'dt_emissao' => $request->dt_emissao,
                'vc_EscolaAnterior' => $request->vc_EscolaAnterior,
                'vc_localEmissao' => $request->vc_localEmissao,
                'id_classe' => $request->id_classe,
                'id_curso' => isset($request->id_curso) ? $request->id_curso :
                fh_cursos()->first()->id,

            ]);

            $this->loggerData('Actualizou o(a) Candidato(a)' . $request->vc_primeiroNome . ' ' . $request->vc_nomedoMeio . ' ' . $request->vc_Apelido);
            return redirect()->route('admin.candidatos.recebecandidaturas')->with('feedback', ['type' => 'success', 'sms' => 'Candidato actualizado com sucesso']);


        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }


    public function eliminar($slug)
    {
        $response = fh_candidato_slug($slug);

        fh_candidatos()->where('candidatos.slug', $slug)->delete();
        $this->loggerData('Eliminou o(a) Candidato(a)' . $response->vc_primeiroNome . ' ' . $response->vc_nomedoMeio . ' ' . $response->vc_apelido);
        return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Candidato elimando com sucesso']);

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



    /**
     * visualiza the specified resource from storage.
     *
     * @param  \App\Models\Candidatura  $candidatura
     * @return \Illuminate\Http\Response
     */
    public function extender($slug)
    {

        $response['candidato'] = fh_candidatos()->where('candidatos.slug', $slug)->first();
        $response['provincias'] = fh_provincias();
        $response['cursos'] = fh_cursos()->get();
        $response['classes'] = fh_classes()->get();
        // $response['anosl']=fh_anos_lectivos()->get();
        $response['idadesdecandidaturas'] = fh_idadedeCandidatura()->get();
        // dd($response['idadesdecandidaturas']);
        return view('admin/candidatura/extender/index', $response);
    }

    public function transferir($id)
    {

        $candidatura = Candidatura::find($id);

        try {
            // $processo=Processo::find(1);
            if (!candidado_transferido($id)) {
                if ($candidatura) {
                    $aluno = Alunno::create([
                        'processo' => gerarProcesso(),
                        'tipo_aluno' => 'Candidato_aluno',
                        'id_candidato' => $id,
                        'id_cabecalho' => Auth::User()->id_cabecalho,
                        'vc_imagem' => 'images/aluno/avatar.png'
                    ]);
                    if ($aluno) {
                        actulizarProcesso($aluno->processo);
                    }
                    if ($aluno) {
                        $this->loggerData('Transferiu ' . $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido);
                        return response()->json('candidato_transferido');
                    }
                } else {
                    return response()->json('candidato_nao_existe');

                }
            } else {
                return response()->json('ja_e_aluno');

            }
        } catch (\Exception $exception) {

            return response()->json('error');
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







}
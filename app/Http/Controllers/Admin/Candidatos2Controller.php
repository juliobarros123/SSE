<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\AnoLectivo;
use App\Models\Candidatura;
use App\Models\Curso;
use App\Models\Cabecalho;
use App\Models\Estudante;
use App\Models\Logger;
use App\Models\Candidato2;
use App\Models\PermissaoDeSelecao;
use App\Models\Processo;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\AlunoAdmitidos as AlunoAdmitidosResource;
use Exception;
class Candidatos2Controller extends Controller
{
    //

    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }

    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function pesquisar()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/admitidos/pesquisar/index', $response);
    }
    public function filtro()
    {
        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/admitidos/pesquisar/filtro/index', $response);
    }

    public function filtro_admitidos(Request $request)
    {
        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }

        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;

            $idade1 = $request->idade51;
            $idade2 = $request->idade52;

            $nota_unica = $request->nota_unica5;
            $response['alunos'] =  $this->fl_intervalode_idade($response['alunos'], $idade1, $idade2);

            if($response['alunos']->count()){
            $response['alunos']=  $this->fl_uma_nota_opcional($response, $request->nota_unica5,'>=');
            $response['alunos']=  $this->fl_uma_nota_opcional($response, $request->nota_unica6,'<=');

                  }
            return view('admin.admitidos.index', $response);

    }

    public function fl_uma_nota_opcional($selecionados, $nota_unica,$op)
    {

        $selecionados_filter =  $selecionados['alunos']->where('it_media',$op, $nota_unica);

        return $selecionados_filter;
    }

    public function pulgar($id)


    {
       
       

        try {
           
            $response =  Candidato2::find($id);
            Candidatura::where('vc_bi', $response->vc_bi)->update(['state' => 1]);
            Candidato2::where('id', $id)->delete();
    
            $this->loggerData("Purgou o Selecionado a Matricula".$response->vc_primeiroNome." ".$response->vc_nomedoMeio." ".$response->vc_apelido." a selecionado");
    
            $this->Logger->Log('info', 'Purgou um Selecionado a Matricula');


            return redirect()->back()->with('admitido.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('admitido.purgar.error', '1');
        }
    }

    public function listarAdmitidos(Request $request, $anoLectivo, $curso, $tipo_filtro, $nota_unica)
    {



        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();


            $response['alunos'] =  $this->fl_uma_nota($response['alunos'], $nota_unica);
        }
        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        return view('admin.admitidos.index', $response);
    }

    public function listar_normal(Request $request, $anoLectivo, $curso)
    {



        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }
        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
      
        return view('admin.admitidos.index', $response);
    }


    public function  listarAdmitidos_por_nota(Request $request, $anoLectivo, $curso, $tipo_filtro, $idade_unica)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }
        $response['alunos'] =  $this->fl_uma_idade($response['alunos'], $idade_unica);
        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        return view('admin.admitidos.index', $response);
    }


    public function listarAdmitidos_por_nota_por_idade(Request $request, $anoLectivo, $curso, $tipo_filtro, $idade_unica, $nota_unica)
    {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {
            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }
        $response['alunos'] =  $this->fl_uma_idade($response['alunos'], $idade_unica);
        $response['alunos'] =  $this->fl_uma_nota($response['alunos'], $nota_unica);
        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        return view('admin.admitidos.index', $response);
    }

    public function por_intervalode_idade(Request $request, $anoLectivo, $curso, $tipo_filtro, $idade1, $idade2)
    {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }
        $response['alunos'] =  $this->fl_intervalode_idade($response['alunos'], $idade1, $idade2);

        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        return view('admin.admitidos.index', $response);
    }
    public function fl_intervalode_idade($selecionados, $idade1, $idade2)
    {

        //   $selecionados1 = $selecionados->where('idade', '>=', $idade1);
        //   $selecionados1 = $selecionados1->where('idade', '<=', $idade2);
        $selecionados1 = $selecionados->whereBetween('idade', [$idade1, $idade2]);

        $selecionados1->all();

        return $selecionados1;
    }

    public function por_intervalode_idade_nota(Request $request, $anoLectivo, $curso, $tipo_filtro, $idade1, $idade2, $nota_unica)
    {
        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        if ($anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo], ['vc_nomeCurso', '=', $curso], ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif ($anoLectivo && !$curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_anoLectivo', '=', $anoLectivo],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } elseif (!$anoLectivo && $curso) {
            $response['alunos'] = Candidato2::where([
                ['vc_nomeCurso', '=', $curso],  ['it_estado_aluno', 1]
            ])->orderBy('vc_primeiroNome','asc')->where('it_estado_aluno', 1)->get();
        } else {

            $response['alunos'] = Candidato2::where([['it_estado_aluno', 1]])->orderBy('vc_primeiroNome','asc')
                ->where('it_estado_aluno', 1)->get();
        }
        $response['alunos'] =  $this->fl_intervalode_idade($response['alunos'], $idade1, $idade2);
        $response['alunos'] =  $this->fl_uma_nota($response['alunos'], $nota_unica);

        $response['anolectivo'] = $anoLectivo;
        $response['curso'] = $curso;
        return view('admin.admitidos.index', $response);
    }

    public function fl_uma_nota($selecionados, $nota_unica)
    {
        $selecionados_filter =  $selecionados->where('it_media', $nota_unica);
        return $selecionados_filter;
    }



    public function fl_uma_idade($selecionados, $idade_unica)
    {
        $selecionados_filter =  $selecionados->where('idade', $idade_unica);
        return $selecionados_filter;
    }





    public function recebe_selecionados(Request $request)
    {

        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        $tipo_filtro = $request->tipo_filtro;
        if (isset($request->nota_unica11) && $request->nota_unica11 != "null" &&  $tipo_filtro == "1") {
            $nota_unica = $request->nota_unica11;
            return redirect("admin/admitidos/listar/$anoLectivo/$curso/$tipo_filtro/$nota_unica");
        } else if (isset($request->idade_unica12) && $request->idade_unica12 != "null" && $tipo_filtro == "2") {

            $idade_unica = $request->idade_unica12;
            return redirect("admin/admitidos/listar/por_nota/$anoLectivo/$curso/$tipo_filtro/$idade_unica");
        } else if (isset($request->nota_unica13) && $request->nota_unica13 != "null" && isset($request->idade_unica13) && $request->idade_unica13 != "null" && $tipo_filtro == "3") {

            $idade_unica = $request->idade_unica13;
            $nota_unica = $request->nota_unica13;
            return redirect("admin/admitidos/listar/por_nota_por_idade/$anoLectivo/$curso/$tipo_filtro/$idade_unica/$nota_unica");
        } else if (isset($request->idade1) && $request->idade1 != "null" && isset($request->idade2) && $request->idade2 != "null" &&  $tipo_filtro == "4") {
            $idade1 = $request->idade1;
            $idade2 = $request->idade2;
            return redirect("admin/admitidos/listar/por_intervalode_idade/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2");
        } else if (isset($request->idade51) && $request->idade51 != "null" && isset($request->idade52) && $request->idade52 != "null" && isset($request->nota_unica5) && $request->nota_unica5 != "null" && $tipo_filtro == "5") {
            $idade1 = $request->idade51;
            $idade2 = $request->idade52;
            $nota_unica = $request->nota_unica5;
            return redirect("admin/admitidos/listar/por_intervalode_idade_nota/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2/$nota_unica");
        } else {

            return redirect("admin/admitidos/listar/$anoLectivo/$curso/");
        }
    }


    public function recebe_selecionados2(Request $request, Estudante $Ralunos)
    {

        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;
        $tipo_filtro = $request->tipo_filtro;
      if (isset($request->idade_unica12) && $request->idade_unica12 != "null" && $tipo_filtro == "2") {
            $idade_unica = $request->idade_unica12;
            $data['alunos']=   $this->listarAdmitidos_por_nota($request,$anoLectivo,$curso,$tipo_filtro,$idade_unica);
            $data['alunos']=$data['alunos']['alunos'];
            
            $data['anolectivo'] = $anoLectivo;
             $data['curso'] = $curso;
             $data['cabecalho'] = Cabecalho::find(1);
           /*   $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
             $data["css"] = file_get_contents("css/listas/style.css"); */

             if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
             } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }
             $mpdf = new \Mpdf\Mpdf();
            
             $mpdf->SetFont("arial");
             $mpdf->setHeader();
             $mpdf->defaultfooterline = 0;
            $mpdf->setFooter('{PAGENO}');
             $this->loggerData("Imprimiu Lista dos Selecionados a Matricula");
             $html = view("admin/pdfs/listas/selecionados/index", $data);
             $mpdf->writeHTML($html);
             $mpdf->Output("listasdSelecionados.pdf", "I");
        } else if (isset($request->nota_unica13) && $request->nota_unica13 != "null" && isset($request->idade_unica13) && $request->idade_unica13 != "null" && $tipo_filtro == "3") {

            $idade_unica = $request->idade_unica13;
            $nota_unica = $request->nota_unica13;
            return redirect("admin/admitidos/listar/por_nota_por_idade/$anoLectivo/$curso/$tipo_filtro/$idade_unica/$nota_unica");
        } else if (isset($request->idade1) && $request->idade1 != "null" && isset($request->idade2) && $request->idade2 != "null" &&  $tipo_filtro == "4") {
            $idade1 = $request->idade1;
            $idade2 = $request->idade2;
            $data['alunos']=$this->por_intervalode_idade($request, $anoLectivo, $curso, $tipo_filtro, $idade1, $idade2);
            $data['alunos']=$data['alunos']['alunos'];
            $data['anolectivo'] = $anoLectivo;
             $data['curso'] = $curso;
             $data['cabecalho'] = Cabecalho::find(1);
            /*  $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
             $data["css"] = file_get_contents("css/listas/style.css"); */
             if ($data['cabecalho']->vc_nif == "5000298182") {

                //$url = 'cartões/CorMarie/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

            } else if ($data['cabecalho']->vc_nif == "7301002327") {

                //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000303399") {

                //$url = 'cartões/negage/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000820440") {
            
                //$url = 'cartões/Quilumosso/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000305308") {

                //$url = 'cartões/Foguetao/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "7301002572") {

                //$url = 'cartões/LiceuUíge/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
             } else if ($data['cabecalho']->vc_nif == "7301003617") {

                //$url = 'cartões/ldc/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else if ($data['cabecalho']->vc_nif == "5000300926") {

                //$url = 'cartões/imagu/aluno.png';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            } else {
                //$url = 'images/cartao/aluno.jpg';
                $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
                $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
            }
             $mpdf = new \Mpdf\Mpdf();

             $mpdf->SetFont("arial");
             $mpdf->defaultfooterline = 0;
            $mpdf->setFooter('{PAGENO}');
             $mpdf->setHeader();
             $this->loggerData("Imprimiu Lista dos Selecionados a Matricula");
             $html = view("admin/pdfs/listas/selecionados/index", $data);
             $mpdf->writeHTML($html);
             $mpdf->Output("listasdSelecionados.pdf", "I");
            return redirect("admin/admitidos/listar/por_intervalode_idade/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2");
        } else if (isset($request->idade51) && $request->idade51 != "null" && isset($request->idade52) && $request->idade52 != "null" && isset($request->nota_unica5) && $request->nota_unica5 != "null" && $tipo_filtro == "5") {
            $idade1 = $request->idade51;
            $idade2 = $request->idade52;
            $nota_unica = $request->nota_unica5;
            return redirect("admin/admitidos/listar/por_intervalode_idade_nota/$anoLectivo/$curso/$tipo_filtro/$idade1/$idade2/$nota_unica");
        } else {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        $c =  $Ralunos->Selecionados2Listas($anoLectivo, $curso);
        $data['alunos'] = $c->get();
        $data['anolectivo'] = $anoLectivo;
        $data['curso'] = $curso;


        $data['cabecalho'] = Cabecalho::find(1);
       /*  $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301003617") {

            //$url = 'cartões/ldc/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }  else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }

        $mpdf = new \Mpdf\Mpdf();
        $mpdf->defaultfooterline = 0;
        $mpdf->setFooter('{PAGENO}');
        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->loggerData("Imprimiu Lista dos Selecionados a Matricula");
        $html = view("admin/pdfs/listas/selecionados/index", $data);
        $mpdf->writeHTML($html);

        $mpdf->Output("listasdSelecionados.pdf", "I");
        }
    }




    public function transferir($id)
    {
        
        $candidato2 = Candidato2::find($id);
        try {   
            $processo = Processo::orderBy('id','desc')->first();
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
                'it_classe' => $candidato2->vc_classe,
                'vc_localEmissao' => $candidato2->vc_localEmissao,
                'tokenKey' => $candidato2->tokenKey,
                'it_processo' => 0,
                'tokenKey' => 'não utilizado',
                'it_media' => $candidato2->it_media,
            ]);

            Processo::find( $processo->id)->update(['it_processo' => $aluno->id]);

            Candidato2::find($id)->update(['it_estado_aluno' => 1]);
            Candidato2::find($id)->update(['it_processo' => 1]);
            if ($aluno) {

                $this->loggerData("Adicionou Selecionado a Matricula".$candidato2->vc_primeiroNome.''.$candidato2->vc_nomedoMeio.''.$candidato2->vc_apelido);
               // return redirect()->back()->with('up', '1');
               return response()->json($aluno);

            }
        } catch (\Exception $exception) {
            return response()->json($exception->getMessage());
            return redirect()->back()->with('aviso', '1');
        }
    }
    public function enviarEmail($distino, $dados, $view)
    {
        try {

            $this->email = $distino;
            Mail::send($view, $dados, function ($message) {
                $message->from('vagas@itel.gov.ao', 'S.I.E');
                $message->subject('Intrevista de trabalho');
                $message->to($this->email);

            });
            return true;
        } catch ( Exception $ex) {

        }
    }


    public function pesquisar_admitidos_pdf()
    {

        $response['anoslectivos'] = AnoLectivo::where([['it_estado_anoLectivo', 1]])->get();
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('admin/admitidos/listas/index', $response);
    }

    public function recebe_selecionados_pdf(Request $request)
    {

        $anoLectivo =  $request->vc_anolectivo;
        $curso = $request->vc_curso;

        return redirect("Admin/lista/selecionados_pdf/$anoLectivo/$curso");
    }

    public function index(Estudante $Ralunos, $anoLectivo, $curso)
    {

        if ($anoLectivo == 'Todos') {
            $anoLectivo = '';
        }
        if ($curso == 'Todos') {
            $curso = '';
        }
        $c =  $Ralunos->Selecionados2Listas($anoLectivo, $curso);
        $data['alunos'] = $c->get();
        $data['anolectivo'] = $anoLectivo;
        $data['curso'] = $curso;


        $data['cabecalho'] = Cabecalho::find(1);
     /*    $data["bootstrap"] = file_get_contents("css/listas/bootstrap.min.css");
        $data["css"] = file_get_contents("css/listas/style.css"); */
        if ($data['cabecalho']->vc_nif == "5000298182") {

            //$url = 'cartões/CorMarie/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');

        } else if ($data['cabecalho']->vc_nif == "7301002327") {

            //$url = 'cartões/InstitutoPolitécnicodoUIGE/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000303399") {

            //$url = 'cartões/negage/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000820440") {
        
            //$url = 'cartões/Quilumosso/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000305308") {

            //$url = 'cartões/Foguetao/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "7301002572") {

            //$url = 'cartões/LiceuUíge/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else if ($data['cabecalho']->vc_nif == "5000300926") {

            //$url = 'cartões/imagu/aluno.png';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        } else {
            //$url = 'images/cartao/aluno.jpg';
            $data["css"] = file_get_contents(__full_path().'css/listas/style.css');
            $data["bootstrap"] = file_get_contents(__full_path().'css/listas/bootstrap.min.css');
        }

        $mpdf = new \Mpdf\Mpdf();

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $this->loggerData("Imprimiu Lista dos Selecionados a Matricula");
        $html = view("admin/pdfs/listas/selecionados/index", $data);
        $mpdf->writeHTML($html);
        $mpdf->Output("listasdSelecionados.pdf", "I");
    }

    public function selecionar()
    {
        return view('admin.admitidos.cadastrar.index');
    }

    public function recebeBI(Request $request)
    {

        $BI = $request->searchBI;
        return redirect("admin/candidatos/trazerCandidato/$BI");
    }

    public function trazerCandidato($BI)
    {

        $anoLectivo = AnoLectivo::where([['it_estado_anoLectivo', 1]])->orderby('id', 'desc')->first();
        $alunos = Candidatura::where([['it_estado_candidato', 1], ['id', $BI], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();
        // $alunosToken = Candidatura::where([['it_estado_candidato', 1], ['id', $token], ['vc_anoLectivo', $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim]])->get();

        //dd($alunos);
        if ($alunos->count()) :
            return view("admin.admitidos.cadastrar.index", compact("alunos"));
        else :
            return redirect('admin/admitidos/cadastrar')->with('aviso', 'Não existe nenhum Candidato com este número de inscrição neste ano lectivo');
        endif;
    }

    public function cadastrar(Request $request)
    {

        try {
            $linha =  Candidato2::where('vc_bi', $request->vc_bi)->count();
            if (!$linha) {
                $aluno = Candidato2::insert([
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
                    'tokenKey' => $request->tokenKey,
                    'it_media' => $request->it_media,
                    'idade' => date('Y') - date('Y', strtotime($request->dt_dataNascimento))
                ]);
                if ($aluno) {
                    $this->loggerData("Adicionou candidato ".$request->vc_primeiroNome." ".$request->vc_nomedoMeio." ".$request->vc_apelido." a selecionado");
                    return redirect('admin/candidatos/selecionar')->with('status', '1');
                }
            } else {
                return redirect()->back()->with('existe', '1');
            }
        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }

    public function delete($id)
    {
       
      
        try {
           
            $response =  Candidato2::find($id);
            $res =  Candidato2::find($id);
            Candidatura::where('vc_bi', $response->vc_bi)->update(['state' => 1]);
            $response = Candidato2::find($id)->update(['it_estado_aluno' => 0]);
    
            $this->loggerData("Eliminou o Selecionado a Matricula".$res->vc_primeiroNome." ".$res->vc_nomedoMeio." ".$res->vc_apelido." a selecionado");
    
            $this->Logger->Log('info', 'Eliminou um Selecionado a Matricula');

            return redirect()->back()->with('admitido.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('admitido.eliminar.error', '1');
        }
    }

    public function edit($id)
    {
        if ($response['aluno'] = Candidato2::find($id)) :
            return view('admin.admitidos.editar.index', $response);
        else :
            return redirect('admin/alunos/cadastrar')->with('aluno', '1');

        endif;
    }

    public function update(Request $request, $id)
    {
        // dd()
        try {
            Candidato2::where('id', $id)->update([
                'id' => $id,
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
        $this->loggerData("Actualizou Selecionado a Matricula ".$request->vc_primeiroNome." ".$request->vc_nomedoMeio." ".$request->vc_apelido." a selecionado");

            $this->Logger->Log('info', 'Actualizou Selecionado a Matricula');
            return redirect()->back()->with('up', '1');
        } catch (\Exception $exception) {
            return redirect()->back()->with('aviso', '1');
        }
    }

    public function editar_selecao()
    {
        $candidaturas = Candidatura::all();

        foreach ($candidaturas as $candidatura) {
            $permissao_de_selecao = PermissaoDeSelecao::orderBy('id', 'desc')->first();


            if ($candidatura->media >= $permissao_de_selecao->nota && $candidatura->dt_dataNascimento <= $permissao_de_selecao->dt_nascimento) {

                $this->actualizar_selecao($candidatura);
            }
        }
        return redirect()->back()->with('up', '1');
    }


    public function actualizar_selecao($request)
    {

        $linha =  Candidato2::where('vc_bi', $request->vc_bi)->count();

        if (!$linha) {
            Candidato2::insert([

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
                'it_media' => $request->media,
                'idade' => date('Y') - date('Y', strtotime($request->dt_dataNascimento))
            ]);
        }
    }

    public function eliminadas()
    {
        $response['alunos'] = Candidato2::where([['it_estado_aluno',0]])->orderBy('vc_primeiroNome','asc')
        ->where('it_estado_aluno',0)->get();

        $response['eliminadas']="eliminadas";
         return view('admin.admitidos.index', $response);
    }

    public function recuperar($id)
    {
        try {
           
            $response =  Candidato2::find($id);
            $res =  Candidato2::find($id);
            Candidatura::where('vc_bi', $response->vc_bi)->update(['state' => 1]);
            $response = Candidato2::find($id)->update(['it_estado_aluno' => 1]);
    
            $this->loggerData("Recuperou o Selecionado a Matricula".$res->vc_primeiroNome." ".$res->vc_nomedoMeio." ".$res->vc_apelido." a selecionado");
    
            $this->Logger->Log('info', 'Recuperou um Selecionado a Matricula');


            return redirect()->back()->with('admitido.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('admitido.recuperar.error', '1');
        }
    }
}

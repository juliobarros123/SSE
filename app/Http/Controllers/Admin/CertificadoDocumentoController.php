<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alunno;
use App\Models\Cabecalho;
use App\Models\Curso;
use App\Models\Disciplina_Curso_Classe;
use App\Models\Logger;
use App\Models\Matricula;
use App\Models\Nota;
use App\Models\Turma;
use Disciplinas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use stdClass;

class CertificadoDocumentoController extends Controller
{
    //
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function emitir()
    {
        // dd(gerarCodigo());
        return view('admin.documentos.certificado.index');
    }
    public function imprimir(Request $request)
    {
        $data['info_certificado'] = fh_infos_certificado()->where('classes.id', $request->id_classe_2)
        ->where('info_cerficados.tipo_documento','Certificado')->first()
        ->first();
        $classe = fh_classes()->where('classes.id', $request->id_classe_2)->first();
        if ($data['info_certificado']) {
            //    dd($data['info_certificado']);
            $data['cabecalho'] = fh_cabecalho();

            $data['classe_inicial'] = fh_classes()->where('classes.id', $request->id_classe)->first();
            $data['classe_final'] = fh_classes()->where('classes.id', $request->id_classe_2)->first();
            $data['aluno'] = fh_matriculas()->where('alunnos.processo', $request->processo)
                ->whereBetween('classes.vc_classe', [$data['classe_inicial']->vc_classe, $data['classe_final']->vc_classe])

                ->first();
            if ($data['aluno']) {
                // dd(   $data['aluno']);
                $data['disciplinas'] = fh_disciplinas_cursos_classes()
                    ->where('classes.vc_classe', '>=', $data['classe_inicial']->vc_classe)
                    ->where('classes.vc_classe', '<=', $data['classe_final']->vc_classe)
                    ->where('cursos.id', $data['aluno']->id_curso)->select('disciplinas.*')->get();
                // dd( $data['disciplinas']);
                $data['componentes'] = fh_componentes()
                    ->where('classes.vc_classe', '>=', $data['classe_inicial']->vc_classe)
                    ->where('classes.vc_classe', '<=', $data['classe_final']->vc_classe)
                    ->where('cursos.id', $data['aluno']->id_curso)
                    ->get();
                    // dd($data['componentes'])
                // dd($data);
                // dd(   $data['disciplinas']);




                //    dd(   $data );



                // dd($request);
                $data["visto"] = $request->visto;
                $data["folha"] = $request->folha;
                $data["registo"] = $request->registo;


                $data["css"] = file_get_contents('css/certificado/style.css');
                $mpdf = new \Mpdf\Mpdf([
                    'format' => 'A4',
                    'margin_top' => 14,
                    'margin_right' => 15,
                    'margin_left' => 15
                ]);
                // dd(medias_anuas_disciplina($request->processo,"ELECTR",[10,11,12]));
                $mpdf->SetFont("times new roman");
                $mpdf->setHeader();
                $this->Logger->Log('info', "Imprimiu certificado do aluno com processo $request->processo ");
                $html = "";
                // if ($data['cabecalho']->vc_tipo_escola == "Liceu") {
                //     $html = view("admin.documentos.certificado.imprimir.liceu.index",    $data);
                // } else if ($data['cabecalho']->vc_tipo_escola == "Magisterio") {
                //     $html = view("admin.documentos.certificado.imprimir.magisterio.index",    $data);
                // } else if ($data['cabecalho']->vc_tipo_escola == "Instituto") {
                //     $html = view("admin.documentos.certificado.imprimir.instituto.index",    $data);
                // }
                // dd($data['cabecalho']->vc_tipo_escola);

                if($data['classe_inicial']->vc_classe >= 1 && $data['classe_final']->vc_classe <= 6){
                    $html = view("admin.documentos.certificado.imprimir.complexo.ensino-primario.index", $data);

                }
                else if ($data['classe_inicial']->vc_classe >= 7 && $data['classe_final']->vc_classe <= 9) {
                    $html = view("admin.documentos.certificado.imprimir.complexo.nona.index", $data);
                } else if ($data['classe_inicial']->vc_classe >= 10 && $data['cabecalho']->vc_tipo_escola == "Geral") {
                    $html = view("admin.documentos.certificado.imprimir.complexo.medio.geral.index", $data);

                } else if ($data['classe_inicial']->vc_classe >= 10 && $data['cabecalho']->vc_tipo_escola == "Técnico") {
                    $html = view("admin.documentos.certificado.imprimir.complexo.medio.tecnico.index", $data);

                }


                // return   $html;
                $mpdf->writeHTML($html);

                $mpdf->Output("Certificado $request->processo", "I");
            } else {
                return redirect()->back()->with('feedback', ['error' => 'success', 'sms' => "Aluno não existe na $classe->vc_classe" . "ª Classe."]);

            }
        } else {
            return redirect()->back()->with('feedback', ['error' => 'success', 'sms' => "Antes, cadastre as informações Necesssário para o certificado da $classe->vc_classe" . "ª Classe. No menu (Info. Certificado)"]);

        }
    }



}
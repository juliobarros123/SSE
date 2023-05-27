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
        return view('admin.documentos.certificado.index');
    }
    public function imprimir(Request $request)
    {
        // // dd("ol");
        // $response = Http::get("https://api.gov.ao/consultarBI/v2/?bi=009145854LA047");
        // $response = $response->json();
        // dd( $response);
        // $id_aluno = 
        $data['cabecalho'] = Cabecalho::find(1);
        $data['aluno'] = Alunno::find($request->processo);
        $data["notas"] =  notas_finais($request->processo);;
        $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
            ->where('id_aluno', $request->processo)
            ->orderBy('it_idTurma', 'desc')->first();
        $data["disciplinas_terminas"] =  $data["notas"]["disciplinas_terminas"];


        $resultados = array();


        $data['media_anual'] = media_anual_geral($request->processo, $data["matricula"]->it_idClasse);
        // dd(  $data['media_anual']);
        // dd($data["notas"]);


        $data['ordem_disciplinas'] = $this->order_dics_por_curso($request->processo);
        // dd($data['ordem_disciplinas']);
        $data['ordem_disciplinas']['tipos'] =
            [
                ['csc', 'COMPONENTE SÓCIO-CULTURAL'],
                ['cc', 'COMPONENTE CIENTÍFICA'],
                ['cttp', 'COMPONENTE TÉCNICA, TECNOLÓGICA E PRÁTICA']
            ];
        // dd($data['ordem_disciplinas']['tipos']);
        $cfds = 0;
        $ttl_TM = 0;
        $count_TM = 0;
        // dd( $data["notas"]["notas"],$data["notas "]["disciplinas"]);
        // dd(  $data["notas"]["notas"] );
        foreach ($data["notas"]["notas"] as $nota) {
            //     dd(intval( ""
            // ));
            foreach ($data['ordem_disciplinas']['tipos'] as $tipo) {
                // dd($data['ordem_disciplinas'][$tipo]);
                foreach ($data['ordem_disciplinas'][$tipo[0]] as $disciplina) {
                    // dd($data['ordem_disciplinas'][$tipo[0]]);
                    if (isset($nota[$disciplina[0]])) {

                        $cfds += intval(isset($nota[$disciplina[0]][0]['rec']) ? $nota[$disciplina[0]][0]['rec'] : (isset($nota[$disciplina[0]][0]['cfd']) ? $nota[$disciplina[0]][0]['cfd'] : 0));

                        // dd($data["disciplinas_terminas"]->where("vc_nome", "$disciplina[0]"));
                        if ($data["disciplinas_terminas"]->where("vc_acronimo", $disciplina[0])->count() && $disciplina[0] != 'P.A.P.') {
                            $ttl_TM += intval(isset($nota[$disciplina[0]][0]['rec']) ? $nota[$disciplina[0]][0]['rec'] : (isset($nota[$disciplina[0]][0]['cfd']) ? $nota[$disciplina[0]][0]['cfd'] : 0));
                            $count_TM++;
                        }
                    }
                }
            }
        }
        // dd( $cfds );
        // dd($data["notas"]["disciplinas"]->count(), $data["notas"]["notas"]);
        $data["media"] = round($cfds /  $data["notas"]["disciplinas"]->count(), 0, PHP_ROUND_HALF_UP);
        $data["ttl_TM"] = $ttl_TM;

        $data["visto"] = $request->visto;
        $data["css"] = file_get_contents('css/pauta/style.css');
        $mpdf = new \Mpdf\Mpdf([
            'format' => 'A4', 'margin_right' => 8,
            'margin_left' => 8
        ]);
        // dd(medias_anuas_disciplina($request->processo,"ELECTR",[10,11,12]));
        $mpdf->SetFont("times new roman");
        $mpdf->setHeader();
        $this->Logger->Log('info', "Imprimiu certificado do aluno com processo $request->processo ");
        $html="";
        if ($data['cabecalho']->vc_tipo_escola == "Liceu") {
            $html = view("admin.documentos.certificado.imprimir.liceu.index",    $data);
        } else if ($data['cabecalho']->vc_tipo_escola == "Magisterio") {
            $html = view("admin.documentos.certificado.imprimir.magisterio.index",    $data);
        } else if ($data['cabecalho']->vc_tipo_escola == "Instituto") {
            $html = view("admin.documentos.certificado.imprimir.instituto.index",    $data);
        }
        // return   $html;
        $mpdf->writeHTML($html);

        $mpdf->Output("Certificado $request->processo", "I");
    }
    public function order_dics_por_curso($processo)
    {
        $m = Matricula::where('id_aluno', $processo)->join('cursos', 'cursos.id', 'matriculas.it_idCurso')->first();
        if ($m->vc_shortName == "Info e Sistemas Multimédia") {
            return $this->ordem_disciplinas_mult();
        } else if ($m->vc_shortName == "Informática") {
            return $this->ordem_disciplinas_info();
        } else {
            return  $this->ordem_disciplinas_electr();
        }
    }
    public function ordem_disciplinas_info()
    {
        $data['ordem_disciplinas']['csc'] = collect(
            [
                [
                    'L. PORT', 'Língua Portuguesa'
                ],
                [
                    'L. ING', 'Língua Inglesa'
                ],
                [
                    'F.A.I.', 'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT', 'Matemática'
                ],
                [
                    'QUI', 'Química'
                ],
                [
                    'FÍS', 'Física'
                ],
                [
                    'ELECTR', 'Electrotecnia'
                ],
                [
                    'O.G.I.', 'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP', 'Empreendedorismo'
                ],
                [
                    'DES. TÉC.', 'Desenho Técnico'
                ],
                [
                    'T.L.P.', 'Técnicas e Linguagens de Programação'
                ],
                [
                    'T.R.E.I', 'Técnicas de Reparação de Equipamentos Informáticos'
                ],
                [
                    'S.E.A.C.', 'Sistemas de Exploração e Arquitetura de Computadores'
                ],
                [
                    'T.I.C.', 'Tecnologias de Informação e Comunicação'
                ],
                [
                    'PROJ. TECN.', 'Projecto Tecnológico'
                ],
                [
                    'ING. TEC', 'Inglês Técnico'
                ],
                [
                    'E.C.S.', 'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.', 'Prova de Aptidão Profissional (PAP)'
                ]


            ]

        );
        // dd( $data['ordem_disciplinas'] );
        return $data['ordem_disciplinas'];
    }

    public function ordem_disciplinas_mult()
    {
        $data['ordem_disciplinas']['csc'] = collect(
            [
                [
                    'L. PORT', 'Língua Portuguesa'
                ],
                [
                    'L. ING', 'Língua Inglesa'
                ],
                [
                    'F.A.I.', 'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT', 'Matemática'
                ],
                [
                    'QUI', 'Química'
                ],
                [
                    'FÍS', 'Física'
                ],
                [
                    'INF', 'Informática'
                ],
                [
                    'O.G.I.', 'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP', 'Empreendedorismo'
                ],
                [
                    'DES. TÉC.', 'Desenho Técnico'
                ],
                [
                    'SIST . INF.', 'Sistemas de Informação'
                ],
                [
                    'D.C.A.', 'Design, Comunicação e Audiovisual'
                ],
                [
                    'TEC. MULT', 'Técnicas de Multimédia'
                ],
                [
                    'P.P.M.', 'Projecto e Produção de Multimédia'
                ],
                [
                    'PROJ. TECN.', 'Projecto Tecnológico'
                ],
                [
                    'ING. TEC', 'Inglês Técnico'
                ],
                [
                    'E.C.S.', 'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.', 'Prova de Aptidão Profissional (PAP)'
                ]


            ]

        );
        // dd( $data['ordem_disciplinas'] );
        return $data['ordem_disciplinas'];
    }



    public function ordem_disciplinas_electr()
    {
        $data['ordem_disciplinas']['csc'] = collect(
            [
                [
                    'L. PORT', 'Língua Portuguesa'
                ],
                [
                    'L. ING', 'Língua Inglesa'
                ],
                [
                    'F.A.I.', 'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT', 'Matemática'
                ],
                [
                    'QUI', 'Química'
                ],
                [
                    'FÍS', 'Física'
                ],
                [
                    'INF', 'Informática'
                ],
                [
                    'O.G.I.', 'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP', 'Empreendedorismo'
                ],
                [
                    'DES. TÉC.', 'Desenho Técnico'
                ],
                [
                    'E. ELECTR.', 'Electricidade e Electrónica'
                ],
                [
                    'SIST. DIG.', 'Sistemas Digitais'
                ],
                [
                    'TELCOM', 'Telecomunicações'
                ],
                [
                    'TEC. TELECOM.', 'Tecnologias de Telecomunicações'
                ],
                [
                    'P.O.L.', 'Práticas de Oficinas e Laboratório'
                ],
                [
                    'PROJ. TECN.', 'Projecto Tecnológico'
                ],
                [
                    'ING. TEC', 'Inglês Técnico'
                ],
                [
                    'E.C.S.', 'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.', 'Prova de Aptidão Profissional (PAP)'
                ]


            ]

        );
        // dd( $data['ordem_disciplinas'] );
        return $data['ordem_disciplinas'];
    }
}

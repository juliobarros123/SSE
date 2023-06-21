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

        $data['cabecalho'] = fh_cabecalho();
        $classe = fh_classes()->where('classes.id', $request->id_classe_2)->first();
        $data['classe_inicial'] = fh_classes()->where('classes.id', $request->id_classe)->first();
        $data['classe_final'] = fh_classes()->where('classes.id', $request->id_classe_2)->first();
        $data['aluno'] = fh_matriculas()->where('alunnos.processo', $request->processo)
            ->whereBetween('classes.vc_classe', [$data['classe_inicial']->vc_classe, $data['classe_final']->vc_classe])

            ->first();
        // dd(   $data['aluno']);
        $data['disciplinas'] = fh_disciplinas_cursos_classes()
            ->where('classes.vc_classe', '>=', $data['classe_inicial']->vc_classe)
            ->where('classes.vc_classe', '<=', $data['classe_final']->vc_classe)
            ->where('cursos.id', $data['aluno']->id_curso)->select('disciplinas.*')->get();
        $data['componentes'] = fh_componentes()
            ->where('classes.id', $data['classe_final']->id)
            ->where('cursos.id', $data['aluno']->id_curso)->get();
       
// dd(   $data['disciplinas']);




        //    dd(   $data );




        $data["visto"] = $request->visto;
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
        $html = view("admin.documentos.certificado.imprimir.complexo.nona.index", $data);


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
            return $this->ordem_disciplinas_electr();
        }
    }
    public function ordem_disciplinas_info()
    {
        $data['ordem_disciplinas']['csc'] = collect(
            [
                [
                    'L. PORT',
                    'Língua Portuguesa'
                ],
                [
                    'L. ING',
                    'Língua Inglesa'
                ],
                [
                    'F.A.I.',
                    'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT',
                    'Matemática'
                ],
                [
                    'QUI',
                    'Química'
                ],
                [
                    'FÍS',
                    'Física'
                ],
                [
                    'ELECTR',
                    'Electrotecnia'
                ],
                [
                    'O.G.I.',
                    'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP',
                    'Empreendedorismo'
                ],
                [
                    'DES. TÉC.',
                    'Desenho Técnico'
                ],
                [
                    'T.L.P.',
                    'Técnicas e Linguagens de Programação'
                ],
                [
                    'T.R.E.I',
                    'Técnicas de Reparação de Equipamentos Informáticos'
                ],
                [
                    'S.E.A.C.',
                    'Sistemas de Exploração e Arquitetura de Computadores'
                ],
                [
                    'T.I.C.',
                    'Tecnologias de Informação e Comunicação'
                ],
                [
                    'PROJ. TECN.',
                    'Projecto Tecnológico'
                ],
                [
                    'ING. TEC',
                    'Inglês Técnico'
                ],
                [
                    'E.C.S.',
                    'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.',
                    'Prova de Aptidão Profissional (PAP)'
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
                    'L. PORT',
                    'Língua Portuguesa'
                ],
                [
                    'L. ING',
                    'Língua Inglesa'
                ],
                [
                    'F.A.I.',
                    'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT',
                    'Matemática'
                ],
                [
                    'QUI',
                    'Química'
                ],
                [
                    'FÍS',
                    'Física'
                ],
                [
                    'INF',
                    'Informática'
                ],
                [
                    'O.G.I.',
                    'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP',
                    'Empreendedorismo'
                ],
                [
                    'DES. TÉC.',
                    'Desenho Técnico'
                ],
                [
                    'SIST . INF.',
                    'Sistemas de Informação'
                ],
                [
                    'D.C.A.',
                    'Design, Comunicação e Audiovisual'
                ],
                [
                    'TEC. MULT',
                    'Técnicas de Multimédia'
                ],
                [
                    'P.P.M.',
                    'Projecto e Produção de Multimédia'
                ],
                [
                    'PROJ. TECN.',
                    'Projecto Tecnológico'
                ],
                [
                    'ING. TEC',
                    'Inglês Técnico'
                ],
                [
                    'E.C.S.',
                    'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.',
                    'Prova de Aptidão Profissional (PAP)'
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
                    'L. PORT',
                    'Língua Portuguesa'
                ],
                [
                    'L. ING',
                    'Língua Inglesa'
                ],
                [
                    'F.A.I.',
                    'Formação de Atitudes Integradoras'
                ]



            ]

        );
        $data['ordem_disciplinas']['cc'] = collect(
            [
                [
                    'MAT',
                    'Matemática'
                ],
                [
                    'QUI',
                    'Química'
                ],
                [
                    'FÍS',
                    'Física'
                ],
                [
                    'INF',
                    'Informática'
                ],
                [
                    'O.G.I.',
                    'Organização e Gestão Industrial'
                ]


            ]

        );

        $data['ordem_disciplinas']['cttp'] = collect(
            [



                [
                    'EMP',
                    'Empreendedorismo'
                ],
                [
                    'DES. TÉC.',
                    'Desenho Técnico'
                ],
                [
                    'E. ELECTR.',
                    'Electricidade e Electrónica'
                ],
                [
                    'SIST. DIG.',
                    'Sistemas Digitais'
                ],
                [
                    'TELCOM',
                    'Telecomunicações'
                ],
                [
                    'TEC. TELECOM.',
                    'Tecnologias de Telecomunicações'
                ],
                [
                    'P.O.L.',
                    'Práticas de Oficinas e Laboratório'
                ],
                [
                    'PROJ. TECN.',
                    'Projecto Tecnológico'
                ],
                [
                    'ING. TEC',
                    'Inglês Técnico'
                ],
                [
                    'E.C.S.',
                    'Estágio Curricular Supervisionado (ECS)'
                ],
                [
                    'P.A.P.',
                    'Prova de Aptidão Profissional (PAP)'
                ]


            ]

        );
        // dd( $data['ordem_disciplinas'] );
        return $data['ordem_disciplinas'];
    }
}
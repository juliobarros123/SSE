<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Turma;
use App\Models\Logger;
use Illuminate\Support\Facades\DB;
class ListaController extends Controller
{
    //
    
    public function __construct()
    {
        $this->Logger = new Logger();

    }
    //
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    
    public function propinas_turmas_pesquisar()
    {
        // dd("ola");
        $response['turmas'] = fh_turmas_2()->get();

        return view('admin.lista.propinas_turma.pesquisar.index', $response);

    }
    
    public function propinas_turmas_imprimir(Request $request)
    {
        // dd($request);
        $response['ano_lectivo'] = 'Todos';

        $response['mes'] = 'Todos';
        $response['estado'] = 'Todos';
        // dd($response['estado']);
        if (session()->get('propinas_turma_aluno_lista')) {

            if (!$request->id_turma) {
                $propinas_turma_aluno_lista = session()->get('propinas_turma_aluno_lista');
                $request->id_turma = $propinas_turma_aluno_lista['id_turma'];
             
            }
            if (!$request->mes) {
                $propinas_turma_aluno_lista = session()->get('propinas_turma_aluno_lista');
                $request->mes = $propinas_turma_aluno_lista['mes'];
           
            }
            if (!$request->estado) {
                $propinas_turma_aluno_lista = session()->get('propinas_turma_aluno_lista');
                $request->estado = $propinas_turma_aluno_lista['estado'];
            }
            // dd($request->ciclo);

        }
        $propinas_turma_aluno_lista = [
            'id_turma' => $request->id_turma,
            'mes' => $request->mes,
            'estado' => $request->estado
        ];
        // dd($propinas_turma_aluno_lista);
       $matriculas= fh_matriculas()->where('turmas.id',$request->id_turma)->get();
    //    dd($matriculas);
        storeSession('propinas_turma_aluno_lista', $propinas_turma_aluno_lista);
 
        $data['turma'] = fh_turmas_2()->where('turmas.id',$request->id_turma)->first();
  
        $data['cabecalho'] = fh_cabecalho();
        $data['turma_alunos'] = $matriculas;
        $data['propinas_turma_aluno_lista']=$propinas_turma_aluno_lista;
        // dd($data['matriculas']);
     
        $data['css'] = file_get_contents('css/lista/style-2.css');
        // Dados para a tabela

        // Carregar a view


        // Parâmetros da view

        $mpdf = new \Mpdf\Mpdf([
            'mode' => 'utf-8',
            'margin_top' => 5,

        ]);

        $mpdf->SetFont("arial");
        $mpdf->setHeader();
        $mpdf->defaultfooterline = 0;

        $mpdf->setFooter('{PAGENO}');

        $this->loggerData("Imprimiu Lista da Propinas Da turma " . $data['turma']->vc_nomedaTurma);

        $html = view("admin.pdfs.listas.propinas_turma.index", $data);
        // return  $html;
        $mpdf->writeHTML($html);

        $mpdf->Output("lista-turma.pdf", "I");

    }

    
    public function imprimir_alunos(Estudante $estudantes, $slug)
    {
       

    }

}

<?php

use App\Models\Activador_da_candidatura;
use App\Models\Alunno;
use App\Models\AnoLectivoPublicado;
use App\Models\Candidatura;
use App\Models\Classe;
use App\Models\DireitorTurma;
use App\Models\Disciplinas;
use App\Models\IdadedeCandidatura;
use App\Models\Nota;
use App\Models\PermissaoProfessorNota;
use App\Actions\Fortify;
use App\Models\Processo;
use App\Models\Provincia;
use App\Models\Turma;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\NotaRecurso;
use App\Models\Rupe;
use App\Models\Pre_candidato;
use Keygen\Keygen;
use App\Models\Cabecalho;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Admin\PautaFinalController;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\CaminhoFicheiro;
use App\Models\Componente;
use App\Models\ComponenteDisciplina;
use App\Models\Disciplina_Curso_Classe;
use App\Models\Disciplina_Terminal;
use App\Models\Matricula;
use Carbon\Carbon;

function ficha($vc_bi)
{
}
function vrf_img($img)
{
    $filename = $img;
    // dd( realpath($filename));
    if (file_exists($filename)) {
        return $img;
    } else {
        // dd("ola");
        return 'images/matriculados/aluno_padrao.png';
    }
}

function id_first_cabecalho()
{
    return Cabecalho::find(1)->id;
}
function id_cabecalho_user($id_user)
{
    return User::find($id_user)->id_cabecalho;
}
function fh_cabecalho()
{
    return Cabecalho::find(Auth::User()->id_cabecalho);
}
function gerarProcesso()
{

    $processo = Processo::where('id_cabecalho', Auth::User()->id_cabecalho)->first();
    if ($processo) {
        return $processo->it_processo + 1;
    } else {
        // Alunno::max('processo');
        return Alunno::max('processo') + 1;
    }

}
function actulizarProcesso($ultimo_processo)
{
    $processo = Processo::where('id_cabecalho', Auth::User()->id_cabecalho)->update([
        'it_processo' => $ultimo_processo + 1
    ]);
    return $processo;

}

function candidado_transferido($id_candidato)
{
    return Alunno::where('id_cabecalho', Auth::User()->id_cabecalho)
        ->where('id_candidato', $id_candidato)->count();


}
function fh_alunos()
{

    return fh_candidatos()
        ->join('alunnos', 'alunnos.id_candidato', 'candidatos.id')
        ->where('alunnos.id_cabecalho', Auth::User()->id_cabecalho)
        ->orderby('candidatos.vc_primeiroNome', 'asc')
        ->orderby('candidatos.vc_nomedoMeio', 'asc')
        ->orderby('candidatos.vc_apelido', 'asc')
        ->select('alunnos.*', 'candidatos.*', 'cursos.*', 'anoslectivos.*', 'classes.vc_classe as vc_classe', 'alunnos.id as id', 'alunnos.slug as slug');



}
function fh_aluno_slug($slug)
{
    return fh_alunos()->where('alunnos.slug', $slug)->first();
}


function fh_matriculas()
{

    return fh_alunos()
        ->join('matriculas', 'matriculas.id_aluno', 'alunnos.id')
        ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
        ->where('alunnos.id_cabecalho', Auth::User()->id_cabecalho)
        ->select('matriculas.*', 'alunnos.*', 'candidatos.*', 'cursos.*', 'anoslectivos.*', 'classes.vc_classe as vc_classe', 'turmas.*', 'matriculas.slug as slug', 'matriculas.id as id');
}




function fh_turmas()
{

    return Turma::join('classes', 'turmas.it_idClasse', '=', 'classes.id')
        ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
        ->join('anoslectivos', 'anoslectivos.id', '=', 'turmas.it_idAnoLectivo')
        ->where('turmas.id_cabecalho', Auth::User()->id_cabecalho)
        ->select('turmas.*', 'cursos.*', 'anoslectivos.*', 'classes.*', 'turmas.slug as slug', 'turmas.id as id');



}

function fha_turma_alunos($slug)
{
    return fh_matriculas()->where('turmas.slug', $slug)
        ->select(
            'turmas.*',
            'cursos.*',
            'anoslectivos.*',
            'alunnos.id as id_aluno',
            'alunnos.*',
            'classes.*',
            'turmas.slug as slug',
            'turmas.id as id',
            'candidatos.vc_primeiroNome',
            'candidatos.vc_nomedoMeio',
            'candidatos.vc_apelido',
            'candidatos.dt_dataNascimento',
            'candidatos.vc_genero',
            'candidatos.vc_dificiencia',
            'vc_estadoCivil',
            'candidatos.it_telefone',
            'candidatos.vc_email',

            'candidatos.vc_bi',
        )

        ->get();





}

function fha_turma_professores($slug)
{
    $response['atribuicoes'] = DB::table('turmas_users')
        ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
        ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
        ->where('users.vc_tipoUtilizador', '=', 'professor')
        ->leftJoin('turmas', 'turmas.id', '=', 'turmas_users.it_idTurma')
        ->distinct()
        ->select(
            'turmas_users.it_idUser',
            'turmas_users.id as ident',
            'users.vc_primemiroNome',
            'users.vc_apelido',
            'turmas.vc_nomedaTurma',
            'turmas.it_qtMatriculados',
            'turmas.it_qtdeAlunos',
            'turmas.id as id_turma',
            'disciplinas.id as id_disciplina',

            'disciplinas.vc_nome as disciplina'

        )
        ->where('turmas_users.id_cabecalho', Auth::User()->id_cabecalho)
        ->where('turmas.slug', $slug)
        ->where('users.vc_tipoUtilizador', '=', 'professor')->get();
    // dd(   $response['atribuicoes']);

    $response['disciplinas'] = DB::table('turmas_users')
        ->join('users', 'users.id', '=', 'turmas_users.it_idUser')
        ->join('disciplinas', 'turmas_users.it_idDisciplina', '=', 'disciplinas.id')
        ->where('users.vc_tipoUtilizador', '=', 'professor')
        ->where('turmas_users.id_cabecalho', Auth::User()->id_cabecalho)
        ->distinct()
        ->select(
            'turmas_users.it_idUser',
            'disciplinas.vc_nome as disciplina'
        )->get();
    return $response;
}
function fh_turmas_slug($slug)
{

    return Turma::join('classes', 'turmas.it_idClasse', '=', 'classes.id')
        ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
        ->join('anoslectivos', 'anoslectivos.id', '=', 'turmas.it_idAnoLectivo')
        ->where('turmas.id_cabecalho', Auth::User()->id_cabecalho)
        ->where('turmas.slug', $slug)
        ->select('turmas.*', 'cursos.*', 'anoslectivos.*', 'classes.*', 'turmas.slug as slug', 'turmas.id as id');



}

function fh_aluno_processo($processo)
{
    return fh_alunos()

        ->where('alunnos.processo', $processo)
        ->select('alunnos.*', 'candidatos.*', 'cursos.*', 'anoslectivos.*', 'classes.vc_classe as vc_classe', 'alunnos.id as id', 'alunnos.slug as slug')

        ->first();
}

// function fh_matricula_slug($slug)
// {
//     return fh_alunos()
//     ->join('matriculas', 'matriculas.id_aluno', 'alunnos.id')
//     ->join('turmas', 'matriculas.it_idTurma', '=', 'turmas.id')
//     ->where('alunnos.id_cabecalho', Auth::User()->id_cabecalho)
//     ->where('alunnos.slug', $slug)
//     ->select('alunnos.*', 'candidatos.*', 'cursos.*', 'anoslectivos.*', 'alunnos.id as id','alunnos.slug as slug', 'classes.vc_classe as vc_classe','turmas.*')
//     ->first();
// }
function fh_provincias()
{
    return Provincia::orderBy('vc_nome', 'asc');
}
function fh_processo_actual()
{
    return Processo::where('id_cabecalho', Auth::User()->id);
}
function resultados_final_alunos($matriculas)
{
    $resultados = array();
    $pauta = new PautaFinalController(new Nota, new Turma, new Curso);
    foreach ($matriculas as $m) {
        array_push($resultados, $pauta->alunoPauta_array($m->it_idAluno));
    }
    return $resultados;
}
// function resultados_final_alunos($matriculas)
// {
//     $resultados = array();

//     $ms =   Matricula::where('vc_anoLectivo', '2021-2022')->get();
// $cont=0;
//     foreach ($ms as $m) {
//         array_push($resultados, $pauta->alunoPauta_array($m->it_idAluno));
//         if($cont==70){
//             return $resultados;
//         }
//         $cont++;
//     }
//     return $resultados;
// }

function slug_gerar()
{

    $slug = Keygen::numeric(2)->generate() . uniqid(date('HisYmd')) . Keygen::numeric(4)->generate();

    return $slug;
}
function users()
{

    if (Auth::User()->desenvolvedor == 2) {
        return User::orderBy('id', 'desc');
    } else {
        return User::orderBy('id', 'desc')->where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}
function fh_cursos()
{
    if (Auth::User()->desenvolvedor == 2) {
        return Curso::orderBy('id', 'desc');
    } else {
        return Curso::orderBy('id', 'desc')->where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}
function fha_ano_lectivo_publicado()
{

    return AnoLectivoPublicado::orderBy('id', 'desc')
        ->where('id_cabecalho', Auth::User()->id_cabecalho)->first();

}
function fh_idades_admissao()
{

    return IdadedeCandidatura::where('idadesdecandidaturas.id_cabecalho', Auth::User()->id_cabecalho)
        ->join('anoslectivos', 'anoslectivos.id', 'idadesdecandidaturas.id_ano_lectivo')
        ->select('anoslectivos.*', 'idadesdecandidaturas.*', 'idadesdecandidaturas.id as id', 'idadesdecandidaturas.slug as slug');


}
function fh_anos_lectivos_publicado()
{

    return AnoLectivoPublicado::orderBy('id', 'desc')
        ->where('id_cabecalho', Auth::User()->id_cabecalho);

}
function fh_cadiado_candidatura()
{

    return Activador_da_candidatura::orderBy('id', 'desc')
        ->where('activadores_das_candidaturas.id_cabecalho', Auth::User()->id_cabecalho);

}
function fh_classes()
{
    // dd("ola");
    if (Auth::User()->desenvolvedor == 2) {
        return Classe::orderBy('id', 'desc');
    } else {
        return Classe::orderBy('id', 'desc')->where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}
function fh_disciplinas()
{

    if (Auth::User()->desenvolvedor == 2) {
        return Disciplinas::orderBy('id', 'desc');
    } else {
        return Disciplinas::orderBy('id', 'desc')->where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}



function fh_users()
{
    return User::where('users.id_cabecalho', Auth::User()->id_cabecalho)
        ->select('users.*');


}
function fh_professores()
{
    return User::where('users.id_cabecalho', Auth::User()->id_cabecalho)
        ->where('vc_tipoUtilizador', 'Professor')
        ->select('users.*');


}
function fh_directores_turmas()
{

    return
        DireitorTurma::join('turmas', 'direitor_turmas.id_turma', 'turmas.id')
            ->join('classes', 'turmas.it_idClasse', '=', 'classes.id')
            ->join('cursos', 'turmas.it_idCurso', '=', 'cursos.id')
            ->join('users', 'direitor_turmas.id_user', 'users.id')
            ->join('anoslectivos', 'anoslectivos.id', '=', 'turmas.it_idAnoLectivo')
            ->where('turmas.id_cabecalho', Auth::User()->id_cabecalho)
            ->select(
                'cursos.*',
                'anoslectivos.*',
                'turmas.*',
                'users.vc_primemiroNome',
                'users.vc_apelido',
            
                'users.vc_email',
                'cursos.vc_nomeCurso',
                'classes.vc_classe',
                'direitor_turmas.*',
                'direitor_turmas.id as id',
                'direitor_turmas.slug as slug'
            );





}
function fha_users($slug)
{
    return User::where('users.id_cabecalho', Auth::User()->id_cabecalho)
        ->where('users.slug', $slug)
        ->select('users.*')->first();


}
function fh_disciplinas_cursos_classes()
{
    return Disciplina_Curso_Classe::join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
        ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
        ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
        ->orderBy('id', 'desc')
        ->where('disciplinas_cursos_classes.id_cabecalho', Auth::User()->id_cabecalho)
        ->select('disciplinas_cursos_classes.*', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'cursos.vc_nomeCurso', 'classes.vc_classe');


}
function fh_idadedeCandidatura()
{
    if (Auth::User()->desenvolvedor == 2) {
        return IdadedeCandidatura::orderBy('id', 'desc');
    } else {
        return IdadedeCandidatura::orderBy('id', 'desc')->where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}
function fh_candidatos()
{
    if (Auth::User()->desenvolvedor == 2) {
        return DB::table('candidatos')->leftjoin('cursos', 'cursos.id', 'candidatos.id_curso')
            ->leftjoin('anoslectivos', 'anoslectivos.id', 'candidatos.id_ano_lectivo')
            ->leftjoin('classes', 'classes.id', 'candidatos.id_classe')
            // ->orderBy('candidatos.id', 'desc')
            ->orderby('candidatos.vc_primeiroNome', 'asc')
            ->orderby('candidatos.vc_nomedoMeio', 'asc')
            ->orderby('candidatos.vc_apelido', 'asc')
            ->select('candidatos.*', 'cursos.*', 'classes.*', 'anoslectivos.*', 'candidatos.id as id', 'candidatos.slug as slug');

    } else {
        return DB::table('candidatos')->leftjoin('cursos', 'cursos.id', 'candidatos.id_curso')
            ->leftjoin('anoslectivos', 'anoslectivos.id', 'candidatos.id_ano_lectivo')
            ->leftjoin('classes', 'classes.id', 'candidatos.id_classe')
            ->orderby('candidatos.vc_primeiroNome', 'asc')
            ->orderby('candidatos.vc_nomedoMeio', 'asc')
            ->orderby('candidatos.vc_apelido', 'asc')
            ->select('candidatos.*', 'cursos.*', 'classes.*', 'anoslectivos.*', 'candidatos.id as id', 'candidatos.slug as slug')
            ->where('candidatos.id_cabecalho', Auth::User()->id_cabecalho);

    }
}
function consultarRupe($idOrigem)
{


    /*  $response = Http::withHeaders([
        'Authorization' => 'Basic aG1sLndzLnNnZTptZm4yOTUyMDIy',
        'Content-Type' => 'application/json'
    ])->get("https://sifphml.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?sistemaOrigem=SGE&idOrigem=$idOrigem"); */
    $response = Http::withHeaders([
        'Authorization' => 'Basic d3Muc2dlOm1mbisxOTcwMSsyMDIy',
        'Content-Type' => 'application/json'
    ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?sistemaOrigem=SGE&idOrigem=$idOrigem");
    if (!isset($response['Error'])) {

        $estado = $response->json();
        return ($estado['DC']['DCItem'][count($estado['DC']['DCItem']) - 1]);
        //return $response->json();
    } else {
        return "error";
    }
}

// function idOrigem($id_pre_candidato)
// {
//     $rupe = Rupe::where('id_pre_candidato', $id_pre_candidato)->orderBy('id', 'desc')->first();
//     if (isset($rupe->idOrigem)) {
//         return $rupe->idOrigem;
//     } else {
//         return "SEM RUPE";
//     }
// }
function extension_file_string($idOrigem)
{
    $ext = explode('.', $idOrigem)[count(explode('.', $idOrigem)) - 1];
    return $ext;
}
function vr_nif($nif)
{

    // sifphml.minfin.gov.ao/sigfe
    /*   $response = Http::withHeaders([
        'Authorization' => 'Basic d3MuYWRtY2F6ZW5nYTptZm4zNDYwODIwMjI=',
        'Content-Type' => 'application/json'
    ])->get("https://sifphml.minfin.gov.ao/sigt/contribuinte/instituicao/v4/obter?tipoDocumento=NIF&numeroDocumento=$nif"); */

    $response = Http::withHeaders([
        'Authorization' => 'Basic d3Muc2dlOm1mbisxOTcwMSsyMDIy',
        'Content-Type' => 'application/json'
    ])->get("https://sifp.minfin.gov.ao/sigt/contribuinte/instituicao/v4/obter?tipoDocumento=NIF&numeroDocumento=$nif");
    return json_decode($response->body(), true);
}
function move_file_string($idOrigem, $distino)
{

    // if (!file_exists($distino)) {
    return copy($idOrigem, $distino);
    // } else {
    //     return false;
    // }
}
// function 
// {
//     $caminho_file_model = CaminhoFicheiro::orderBy('id', 'desc')->get()->first();
//     if (isset($caminho_file_model->vc_caminho)) {
//         return $caminho_file_model->vc_caminho;
//     } else {
//         return '';
//     }
// }
function calcularIdade($data)
{
    // dd($data);
    $idade = 0;
    $data_nascimento = date('Y-m-d', strtotime($data));
    $data = explode("-", $data_nascimento);
    $anoNasc = $data[0];
    $mesNasc = $data[1];
    $diaNasc = $data[2];

    $anoAtual = date("Y");
    $mesAtual = date("m");
    $diaAtual = date("d");

    $idade = $anoAtual - $anoNasc;
    if ($mesAtual < $mesNasc) {
        $idade -= 1;
    } elseif (($mesAtual == $mesNasc) && ($diaAtual <= $diaNasc)) {
        $idade -= 1;
    }

    return $idade;
}
//    echo (calcularIdade("01/04/1970"));
function dif_pre_cand($ano_lectivo, $data, $curso, $genero)
{
    $pre_candidatos = DB::table('pre_candidatos')->join('candidatos', 'pre_candidatos.vc_bi', 'candidatos.vc_bi')
        ->where('pre_candidatos.it_estado_candidato', 1)
        ->where('candidatos.it_estado_candidato', 1);

    if ($ano_lectivo != "Todos") {
        $pre_candidatos = $pre_candidatos->where('pre_candidatos.vc_anoLectivo', $ano_lectivo);
    }
    if ($data) {
        $pre_candidatos = $pre_candidatos->whereDate('pre_candidatos.created_at', $data);
    }
    if ($curso) {
        $pre_candidatos = $pre_candidatos->where('pre_candidatos.vc_nomeCurso', $curso);
    }
    if ($genero) {
        $pre_candidatos = $pre_candidatos->where('pre_candidatos.vc_genero', $genero);
    }
    return $pre_candidatos;
}
function pre_candidatos($ano_lectivo, $data, $curso, $genero)
{

    $pre_candidatos = DB::table('pre_candidatos')->where([['pre_candidatos.it_estado_candidato', 1]]);
    if ($ano_lectivo != "Todos") {
        $pre_candidatos = $pre_candidatos->where('pre_candidatos.vc_anoLectivo', $ano_lectivo);
    }
    if ($data) {
        $pre_candidatos = $pre_candidatos->whereDate('created_at', $data);
    }
    if ($curso) {
        $pre_candidatos = $pre_candidatos->where('vc_nomeCurso', $curso);
    }
    if ($genero) {
        $pre_candidatos = $pre_candidatos->where('vc_genero', $genero);
    }
    return $pre_candidatos;
}
// function consultarRupePronto($id_pre_candidato)
// {
//     $rupe = Rupe::where('id_pre_candidato', $id_pre_candidato)->orderBy('id', 'desc')->first();
//     if (isset($rupe->idOrigem)) {
//         return $rupe->idOrigem;
//     } else {
//         return "SEM RUPE";
//     }
// }


function consultarRupePreCandidato_v3($numeroDC)
{

    /* if (isset($numeroDC)) {

        $response = Http::withHeaders([
            'Authorization' => 'Basic d3Muc2dlOm1mbjE0Njk4MjAyMg==',
            'Content-Type' => 'application/json'
        ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?numeroDC=$numeroDC");
        if (!isset($response['Error'])) {

            $estado = $response->json();

            if ($estado['DC']['DCItem'][0]['sitDC']  == "P") {
                return "PAGO";
            } else {
                return "NÃO PAGO";
            }
            //return $response->json();
        } else {
            return "error";
        }
    } else {
        return "SEM RUPE";
    } */
    if (isset($numeroDC)) {

        /*  $response = Http::withHeaders([
            'Authorization' => 'Basic d3Muc2dlOm1mbjE0Njk4MjAyMg==',
            'Content-Type' => 'application/json'
        ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?numeroDC=$numeroDC");
        // ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?numeroDC=$numeroDC"); Manuel */

        $response = Http::withHeaders([
            'Authorization' => 'Basic d3Muc2dlOm1mbisxOTcwMSsyMDIy',
            'Content-Type' => 'application/json'
        ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?numeroDC=$numeroDC");
        // ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?numeroDC=$numeroDC"); Manuel
        if (!isset($response['Error'])) {

            $estado = $response->json();

            if ($estado['DC']['DCItem'][0]['sitDC'] == "P") {
                return "PAGO";
            } else {
                return "NÃO PAGO";
            }
            //return $response->json();
        } else {
            return "error";
        }
    } else {
        return "SEM RUPE";
    }
}


function verificarPagamentoRupe($idOrigem)
{


    /* $response = Http::withHeaders([
        'Authorization' => 'Basic aG1sLndzLnNnZTptZm4yOTUyMDIy',
        'Content-Type' => 'application/json'
    ])->get("https://sifphml.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?sistemaOrigem=SGE&idOrigem=$idOrigem"); */

    $response = Http::withHeaders([
        'Authorization' => 'Basic d3Muc2dlOm1mbisxOTcwMSsyMDIy',
        'Content-Type' => 'application/json'
    ])->get("https://sifp.minfin.gov.ao/sigfe/tributario/receita/ape/v5/obterDC?sistemaOrigem=SGE&idOrigem=$idOrigem");
    if (!isset($response['Error'])) {

        $estado = $response->json();
        return ($estado['DC']['DCItem'][0]['sitDC']);
        //return $response->json();
    } else {
        return "error";
    }
}


function cod($digitos)
{

    $p2 = Keygen::numeric($digitos)->generate();
    return $p2;
}

function codigoCandidatura($digitos = null)
{
    // $p1=Keygen::numeric(ceil($digitos/2))->generate();
    $cod = uniqid(date('HisYmd'));
    $p2 = substr($cod, 19, strlen($cod));
    // $p2=Keygen::numeric(ceil($digitos/2));
    return $p2;
}
function acc_admin_desenvolvedor()
{
    if (Auth::User()->vc_tipoUtilizador == 'Administrador' && Auth::User()->desenvolvedor) {
        return 1;
    }
}

function fh_ultimo_ano_lectivo()
{
    return AnoLectivo::where('id_cabecalho', Auth::User()->id_cabecalho)->orderBy('ya_fim', 'desc')->first();
}
function fh_candidato_slug($slug)
{
    return fh_candidatos()->where('candidatos.slug', $slug)->first();
}
// function fh_candidato_slug_find($slug)
// {
//     $c= fh_candidatos()->where('candidatos.slug', $slug)->first();
//     if($c){
//       return  fh_candidatos()->find($c->id);
//     }else{
//         return   $c  ;
//     }
// }
function fh_anos_lectivos()
{
    if (Auth::User()->desenvolvedor == 2) {
        return AnoLectivo::all();
    } else {
        return AnoLectivo::where('id_cabecalho', Auth::User()->id_cabecalho);
    }
}
function meses()
{
    return $meses = array(1 => "Janeiro", 2 => "Fevereiro", 3 => "Março", 4 => "Abril", 5 => "Maio", 6 => "Junho", 7 => "Julho", 8 => "Agosto", 9 => "Setembro", 10 => "Outubro", 11 => "Novembro", 12 => "Dezembro");
}
function eliminarElement($element, $collection)
{

    $keys = $collection->keys();
    $keys->all();
    foreach ($keys as $key) {
        if ($collection[$key] == $element) {
            $collection = $collection->except([$key]);
            return $collection;
        }
    }
}
function temNegativaDeRecurso($processo)
{

    return DB::table('nota_recursos')
        ->join('alunnos', 'nota_recursos.it_idAluno', '=', 'alunnos.id')
        ->where('alunnos.id', '=', $processo)
        ->where('nota', '<', 10)->count();
}
// function codigo($digitos)
// {
//     return Keygen::numeric($digitos)->generate();
// }
function permissaoInserirNota($id_user)
{
    return PermissaoProfessorNota::where('id_user', $id_user)->count();
}


function trimestresAutorizados($id_user)
{
    $trimestres = PermissaoProfessorNota::where('id_user', $id_user)->get();
    return $trimestres;
}
function notasDeOutrosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe)
{
    $nota = new Nota;

    $data = mediaDosAnos($id_aluno = 13129, $id_disciplina = 4, $id_anoLectivo = "''", $id_ultima_classe = 2);
    dd($data, $id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe);
    return $data;
}


function upload_img($request, $input, $caminho)
{


    if (isset($request[$input]) && $request[$input]->isValid()) {

        // Define um aleatório para o arquivo baseado no timestamps atual
        $name = uniqid(date('HisYmd'));

        // Recupera a extensão do arquivo
        $extension = $request[$input]->extension();

        // Define finalmente o nome
        $nameFile = "{$name}.{$extension}";


        // Faz o upload:
        $upload = $request[$input]->storeAs($caminho, $nameFile);

        //            dd($upload,"O");

        //            $upload = substr($upload, 7, strlen($upload));
        // Se tiver funcionado o arquivo foi armazenado em storage/app/public/categories/nomedinamicoarquivo.extensao

        // Verifica se NÃO deu certo o upload ( Redireciona de volta )

        if (!$upload) {

            return -1;
        } else {
            return $upload;
            //         $size= getimagesize('storage/'.$upload);

            //  return ['caminho'=>$upload,'altura'=>$size[0],'largura'=>$size[1],'bits'=>$size["bits"],'mime'=>$size["mime"]];

        }
    } else {
        return '';
        // $size= getimagesize('storage/timeline/capa/capa.jpg');
        // return ['caminho'=>'timeline/capa/capa.jpg','altura'=>$size[0],'largura'=>$size[1],'bits'=>$size["bits"],'mime'=>$size["mime"]];

    }
}
function ola()
{
    return "ola tudo bem";
}
function deixouCadeiraDesteAno($cadeiras, $detalhes_turma)
{
    if ($detalhes_turma->vc_classe == 12) {
        foreach ($cadeiras as $cadeira) {
            $disciplina = Disciplinas::where('vc_acronimo', $cadeira["disciplina"])->first();
            $cont = temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso);
            if ($cont) {
                return 1;
            }
        }
    }
}
function temCadeirasDoAnoAnterior($cadeiras, $detalhes_turma)
{

    if ($detalhes_turma->vc_classe == 12 || $detalhes_turma->vc_classe == 11) {
        foreach ($cadeiras as $cadeira) {
            $disciplina = Disciplinas::where('vc_acronimo', $cadeira["disciplina"])->first();
            $cont = temDCCNestaClasse($disciplina->id, $detalhes_turma->it_idClasse, $detalhes_turma->it_idCurso);

            if (!$cont) {
                return 1;
            }
        }
    }
}
function notaRecurso($id_aluno, $id_disciplina)
{
    $notaRecurso = NotaRecurso::where('id_aluno', $id_aluno)->where('id_disciplina', $id_disciplina)->orderBy('id', 'desc')->first();
    if ($notaRecurso) {
        return $notaRecurso->nota;
    } else {
        return -1;
    }
}
function alunoPorProcesso($id_aluno)
{
    $aluno = Alunno::find($id_aluno);
    return $aluno;
}


function notasFakes($id_aluno, $id_disciplina, $id_anoLectivo, $id_classe)
{

    $disciplina = Disciplinas::find($id_disciplina);
    // $classe = Classe::find($id_classe);
    $aluno = Alunno::find($id_aluno);
    //Alun
    //  $AnoLectivo=AnoLectivo::find($id_anoLectivo);
    //  dd( $AnoLectivo);

    $fkNotas =
        [
            "it_idAluno" => $id_aluno,
            "vc_nome" => $disciplina->vc_nome,
            "vc_acronimo" => $disciplina->vc_acronimo,
            "vc_tipodaNota" => 'FK',
            "id_classe" => $id_classe,
            "vc_classe" => 'FK',
            "id_disciplina" => $id_disciplina,
            "fl_media" => 0,
            "fl_nota1" => 0,
            "fl_nota2" => 0,
            "fl_mac" => 0,
            "id" => $id_aluno,
            "vc_primeiroNome" => $aluno->vc_primeiroNome,
            "vc_nomedoMeio" => $aluno->vc_nomedoMeio,
            "vc_ultimoaNome" => $aluno->vc_ultimoaNome,
            "ya_inicio" => '',
            "ya_fim" => '',
            "id_anolectivo" => $id_anoLectivo
        ];
    //
    return $fkNotas;
}

function temDCCNestaClasse($id_disciplina, $id_classe, $id_curso)
{
    return DB::table('disciplinas_cursos_classes')
        ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
        ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
        ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
        ->where('disciplinas.id', $id_disciplina)
        ->where('classes.id', $id_classe)
        ->where('cursos.id', $id_curso)
        ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])->count();
}
function valorPorExtenso($valor = 0, $bolExibirMoeda = true, $bolPalavraFeminina = false)
{

    $valor = $valor;

    $singular = null;
    $plural = null;

    if ($bolExibirMoeda) {
        $singular = array("centavo", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("centavos", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    } else {
        $singular = array("", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
        $plural = array("", "", "mil", "milhões", "bilhões", "trilhões", "quatrilhões");
    }

    $c = array("", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
    $d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa");
    $d10 = array("dez", "onze", "doze", "treze", "catorze", "quinze", "dezasseis", "dezassete", "dezóito", "dezanove");
    $u = array("", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");


    if ($bolPalavraFeminina) {

        if ($valor == 1) {
            $u = array("", "uma", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
        } else {
            $u = array("", "um", "duas", "três", "quatro", "cinco", "seis", "sete", "oito", "nove");
        }


        $c = array("", "cem", "duzentas", "trezentas", "quatrocentas", "quinhentas", "seiscentas", "setecentas", "oitocentas", "novecentas");
    }


    $z = 0;

    $valor = number_format($valor, 2, ".", ".");
    $inteiro = explode(".", $valor);

    for ($i = 0; $i < count($inteiro); $i++) {
        for ($ii = mb_strlen($inteiro[$i]); $ii < 3; $ii++) {
            $inteiro[$i] = "0" . $inteiro[$i];
        }
    }

    // $fim identifica onde que deve se dar junção de centenas por "e" ou por "," ;)
    $rt = null;
    $fim = count($inteiro) - ($inteiro[count($inteiro) - 1] > 0 ? 1 : 2);
    for ($i = 0; $i < count($inteiro); $i++) {
        $valor = $inteiro[$i];
        $rc = (($valor > 100) && ($valor < 200)) ? "cento" : $c[$valor[0]];
        $rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
        $ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]] : $u[$valor[2]]) : "";

        $r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd && $ru) ? " e " : "") . $ru;
        $t = count($inteiro) - 1 - $i;
        $r .= $r ? " " . ($valor > 1 ? $plural[$t] : $singular[$t]) : "";
        if ($valor == "000")
            $z++;
        elseif ($z > 0)
            $z--;

        if (($t == 1) && ($z > 0) && ($inteiro[0] > 0))
            $r .= (($z > 1) ? " de " : "") . $plural[$t];

        if ($r) {
            $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? (($i < $fim) ? ", " : " e ") : " ") . $r;
        }
    }

    $rt = mb_substr($rt, 1);
    // dd($rt,"ol");
    return ($rt ? trim($rt) : "zero");
}
function hoje_extenso()
{

    $data = Carbon::now()->locale('pt_BR')->isoFormat('D [de] MMMM [de] YYYY');
    return $data;
}
function pri_ultimo_nome($nome)
{
    $partes = explode(' ', $nome);
    $primeiroNome = array_shift($partes);
    $ultimoNome = array_pop($partes);
    return [$primeiroNome, $ultimoNome];
}

function sub_traco_barra($dt)
{
    $dt = date('d-m-Y', strtotime($dt));
    $dt = str_replace('-', '/', $dt);
    return $dt;
}
function temDisciplinaNoClasseAnterior($id_disciplina, $classe, $id_curso)
{
    $cols = 0;
    for ($cont = 10; $cont < $classe; $cont++) {
        $datas = DB::table('disciplinas_cursos_classes')
            ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
            ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
            ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
            ->where('disciplinas.id', $id_disciplina)
            ->where('classes.vc_classe', $cont)
            ->where('cursos.id', $id_curso)
            ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])->count();
        if ($datas) {
            $cols++;
        }
    }
    return $cols;
    // $datas = DB::table('disciplinas_cursos_classes')
    // ->join('disciplinas', 'disciplinas_cursos_classes.it_disciplina', '=', 'disciplinas.id')
    // ->join('cursos', 'disciplinas_cursos_classes.it_curso', '=', 'cursos.id')
    // ->join('classes', 'disciplinas_cursos_classes.it_classe', '=', 'classes.id')
    // ->where('disciplinas.id',$id_disciplina)
    // ->where('disciplinas.vc_classe',$classe)
    // ->where('cursos.id',$id_curso )
    // ->where([['disciplinas_cursos_classes.it_estado_dcc', 1]])

    // ->select('disciplinas_cursos_classes.*', 'disciplinas.vc_nome', 'disciplinas.vc_acronimo', 'cursos.vc_nomeCurso', 'classes.vc_classe');

    return $datas;
}
function notas_finais($processo)
{
    try {
        $pauta = new PautaFinalController(new Nota, new Turma, new Curso);
        return $pauta->alunoPauta_array($processo);
    } catch (\Exception $ex) {
        return response()->json("Pendente");
    }
}
function disciplinas_terminas($it_idClasse, $it_idCurso)
{


    $disciplinas_terminas = Disciplina_Terminal::join('classes', 'disciplina__terminals.id_classe', '=', 'classes.id')
        ->join('cursos', 'disciplina__terminals.it_idCurso', '=', 'cursos.id')
        ->join('disciplinas', 'disciplina__terminals.id_disciplina', '=', 'disciplinas.id')
        ->orderBy('disciplinas.id', 'asc')
        ->where('disciplina__terminals.it_estado', 1)
        ->where('disciplina__terminals.id_classe', $it_idClasse)
        ->where('disciplina__terminals.it_idCurso', $it_idCurso)
        ->select('disciplinas.*', 'disciplina__terminals.id as id_disciplina_terminal');

    return $disciplinas_terminas;
}
function mediaDosAnos($id_aluno = 13129, $id_disciplina = 4, $id_anoLectivo = "''", $id_ultima_classe = 2)
{

    // $id_aluno=13129;
    // $id_disciplina=4;
    //  $id_anoLectivo="''";
    //   $id_ultima_classe=2;
    $mediaDosAnos = 0;
    $disciplina = Disciplinas::find($id_disciplina);
    $nota = new Nota;
    $notas = collect();
    $CAS = collect();
    $classe = Classe::find($id_ultima_classe);
    $classe->vc_classe;
    $ttlClasses = 0;
    $id_curso = Matricula::where('id_aluno', $id_aluno)->first()->it_idCurso;
    $qtClassesAnterior = temDisciplinaNoClasseAnterior($id_disciplina, $classe->vc_classe, $id_curso);
    // dd($classe->vc_classe - 1 );
    // dd(  $qtClassesAnterior,$classe->vc_classe - $qtClassesAnterior,$classe);
    for ($cont = $classe->vc_classe - 1; $cont >= $classe->vc_classe - $qtClassesAnterior; $cont--) {

        if ($disciplina->vc_acronimo == "SIST. DIG." && $classe->vc_classe == 12 && $cont == 10) {

            break;
        }
        //    dd(notasFakes($id_aluno,$id_disciplina,$id_anoLectivo,$classe->id));

        $classe = Classe::where('vc_classe', $cont)->first();

        $notas->push($nota->notasNoutrosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $classe->id)->get());

        $ttlClasses++;

        //  dd( $ttlClasses);
        $mediaDosAnos = 0;
        $classe = Classe::find($id_ultima_classe);
        // $notas[1][1]=['f'=>0];
        // for ($contAno = 0; $contAno < 3; $contAno++) {
        //     for ($contAno1 = 0; $contAno1 < 3; $contAno1++) {

        //         if (!isset($notas[$contAno][$contAno1])) {
        //             $notas[$contAno][1]='';
        //         }
        //     }
        // dd($notas);
        //     }

    }
    // dd(  $notas);

    //  dd($notas);
    // if ($id_aluno == '13518') {
    //     addNotasFakes($id_aluno,$notas, $classe->vc_classe,$id_disciplina,$id_anoLectivo);
    // }

    $notas = addNotasFakes($id_aluno, $notas, $classe->vc_classe, $id_disciplina, $id_anoLectivo);
    // dd($notas);
    foreach ($notas as $notasAnual) {
        // if ($id_aluno == '13518') {
        //     dd($notas[2][1]['id_classe']);
        // }
        //  dd($notas);

        $ca = 0;
        $mat1 = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media : 0;
        $mat2 = isset($notasAnual->where('vc_tipodaNota', 'II')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'II')->last()->fl_media : 0;
        $mat3 = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_media : 0;

        $mat1 = round(($mat1), 0, PHP_ROUND_HALF_UP);
        $mat2 = round(($mat2), 0, PHP_ROUND_HALF_UP);
        $mat3 = round(($mat3), 0, PHP_ROUND_HALF_UP);

        // if ($disciplina->vc_acronimo == "EMP" && $classe->vc_classe == 12) {
        //     dd($notasAnual,"o",$classe->vc_classe);
        // }
        if ($notasAnual->count()) {

            if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                // dd($notasAnual);
                $fl_nota1 = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1 : 0;
                $fl_mac = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac : 0;
                $mft = $fl_nota1 + $fl_mac;
                $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                $exame = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2 : 0;
                $ca = ($mfd * 0.6) + ($exame * 0.4);
                $ca = round(($ca), 0, PHP_ROUND_HALF_UP);
                // dd(                $ca );
            } else {
                $ca = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);
            }


            // if ($detalhes_turma->vc_classe == 12) {
            //     if (isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2)) {
            //         $exame = $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2;
            //     } else {
            //         $exame = 0;
            //     }
            // }
            // $mft = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ?
            // $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota1 + $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_mac : 0;

            // $mft = ceil($mft / 2);
            // $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);

            // $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);

            // $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);
            //guardar acs dos anos anteriores

            $id_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->id_classe : 0;
            $vc_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->vc_classe : 0;
            $vc_nome = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->vc_nome : 0;
            //quando é vector as notas para o trimestre
            //    dd($notasAnual);
            if (!$id_classe) {
                // dd($notasAnual);
                if (isset($notasAnual[1]->id_classe)) {
                    $id_classe = $notasAnual[1]->id_classe;
                } else if (isset($notasAnual[1]['id_classe'])) {
                    $id_classe = $notasAnual[1]['id_classe'];
                }
            }
            if (!$vc_classe) {
                if (isset($notasAnual[1]->vc_classe)) {
                    $vc_classe = $notasAnual[1]->vc_classe;
                } else if (isset($notasAnual[1]['vc_classe'])) {
                    $vc_classe = $notasAnual[1]['vc_classe'];
                }
            }
            if (!$vc_nome) {
                if (isset($notasAnual[1]->vc_nome)) {
                    $vc_nome = $notasAnual[1]->vc_nome;
                } else if (isset($notasAnual[1]['vc_nome'])) {
                    $vc_nome = $notasAnual[1]['vc_nome'];
                }
            }
            if (isset($notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota1)) {
                // dd("ola");
                if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                    // dd($notasAnual);
                    $mft = $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota1 + $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_mac;
                    $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                    $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                    $exame = $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota2;
                    $ca = ($mfd * 0.6) + ($exame * 0.4);
                    $ca = round(($ca), 0, PHP_ROUND_HALF_UP);
                    // dd($ca12classe);
                    // dd(  $ca);
                }
            } else {

                if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                    // dd($notasAnual);
                    $mft = $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1 + $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac;
                    $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                    $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                    $exame = $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2;
                    $ca = ($mfd * 0.6) + ($exame * 0.4);
                    $ca = round(($ca), 0, PHP_ROUND_HALF_UP);

                    // dd($ca, "ola");
                    // dd($ca12classe);
                    // dd(  $ca);
                }
            }

            if (intVal($classe->vc_classe) > $vc_classe) {
                // dd(intVal($classe->vc_classe) ,$vc_classe);
                $CAS->push(['id_classe' => $id_classe, 'ca' => isset($ca12classe) ? $ca12classe : $ca, 'id_diciscplina' => $id_disciplina, 'vc_classe' => $vc_classe, 'vc_nome' => $vc_nome]);
            } else {
            }
        } else {
            //  dd($notasAnual->count(),$notasAnual, $notas,$mediaDosAnos);
            $ca = 0;
        }
        if ($disciplina->vc_acronimo == "SIST. DIG." && $classe->vc_classe == 12 && $cont == 10) {

            // dd(   $ca);
        }
        if ($disciplina->vc_acronimo == "EMP" && $classe->vc_classe == 12) {
            // dd("la",$ca,$classe->vc_classe);
        }
        $mediaDosAnos += $ca;
    }
    //    dd(  $CAS);
    // if(!$mediaDosAnos->count()){
    //     dd("ola");

    // }
    // if ($disciplina->vc_acronimo == "EMP" ) {
    //     dd("la",$mediaDosAnos,$notas->count());
    // }


    $media = round(($mediaDosAnos / ($notas->count() ? $notas->count() : 1)), 0, PHP_ROUND_HALF_UP);
    $dados['media'] = $media;
    $dados['ACS'] = $CAS;

    // dd($dados['ACS'] );
    // if ($id_aluno == '13518') {
    //     dd(  $dados['ACS']);
    // }

    return $dados;
}
function sub_traco_barra_string($string)
{

    $string = str_replace('-', '/', $string);
    return $string;
}
function trazerIDAnoLectivo($vc_anoLectivo)
{

    $anos = explode("-", $vc_anoLectivo);
    // dd( $anos);
    return AnoLectivo::where('ya_inicio', $anos[0])->where('ya_fim', $anos[1])->where('it_estado_anoLectivo', 1)->select('id')->first()->id;
}
function menor_zero($valor)
{
    if ($valor >= 0) {
        return 1;
    } else {
        return 0;
    }
}
function medias_anuas_disciplina($processo, $disciplina, $classes)
{
    $array_notas_anuais = array();
    foreach ($classes as $classe) {
        $cl = Classe::where('vc_classe', $classe)->first();
        $mas = medias_anual($processo, $cl->id);
        if (count(collect($mas)->where('1', $disciplina))) {
            foreach ($mas as $media_anual) {
                if ($media_anual[1] == $disciplina) {
                    array_push($array_notas_anuais, $media_anual[2]);
                }
            }
        } else {
            array_push($array_notas_anuais, -1);
        }
    }

    // if ('P.A.P.' == $disciplina) {
    //     dd($array_notas_anuais);
    // }
    // //    $nota=media_anual(14333, 5, 2, 1);
    // foreach (medias_anual($processo, $id_classe) as $media_anual) {
    //     array_push($array_notas_anuais, $media_anual[2]);
    // }
    return $array_notas_anuais;
}
function media_anual_geral($processo, $id_classe)
{
    $array_notas_anuais = array();
    //    $nota=media_anual(14333, 5, 2, 1);
    foreach (medias_anual($processo, $id_classe) as $media_anual) {
        array_push($array_notas_anuais, $media_anual[2]);
    }
    return round((media($array_notas_anuais)), 0, PHP_ROUND_HALF_UP);
}
function medias_anual($processo, $id_classe)
{
    $disciplinas_notas = array();
    $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
        ->where('id_aluno', $processo)
        ->orderBy('it_idTurma', 'desc')->where('it_idClasse', $id_classe)->first();
    // dd(  $data["matricula"]);
    if ($data["matricula"]) {
        $dccs = Disciplina_Curso_Classe::where('it_classe', $id_classe)->where('it_curso', $data["matricula"]->it_idCurso)->get();
        //    dd($dccs);
        $id = trazerIDAnoLectivo($data["matricula"]->vc_anoLectivo);
        // dd( $id);
        foreach ($dccs as $dcc) {
            $d = Disciplinas::find($dcc->it_disciplina);
            // dd($dcc);
            $nota = media_anual($processo, $dcc->it_disciplina, $id, $id_classe);
            array_push($disciplinas_notas, [$d->vc_nome, $d->vc_acronimo, $nota['media']]);
        }
    } else {
        $data["matricula"] = Matricula::join('classes', 'classes.id', 'matriculas.it_idClasse')
            ->where('id_aluno', $processo)
            ->orderBy('it_idTurma', 'desc')->first();
        $dccs = Disciplina_Curso_Classe::where('it_classe', $id_classe)->where('it_curso', $data["matricula"]->it_idCurso)->get();
        foreach ($dccs as $dcc) {
            // dd($dcc);
            $d = Disciplinas::find($dcc->it_disciplina);
            array_push($disciplinas_notas, [$d->vc_nome, $d->vc_acronimo, 0]);
        }
    }
    return $disciplinas_notas;
}
function media_anual($id_aluno = 13129, $id_disciplina = 4, $id_anoLectivo = "''", $id_ultima_classe = 2)
{ {
        $mediaDosAnos = 0;
        $disciplina = Disciplinas::find($id_disciplina);

        $nota = new Nota;
        $notas = collect();
        $CAS = collect();
        $classe = Classe::find($id_ultima_classe);
        // dd( $disciplina,  $classe,$id_aluno,$id_anoLectivo);
        $classe->vc_classe;
        $ttlClasses = 0;

        // dd(  $qtClassesAnterior,$classe->vc_classe - $qtClassesAnterior,$classe);
        for ($cont = $classe->vc_classe; $cont <= $classe->vc_classe; $cont++) {

            if ($disciplina->vc_acronimo == "SIST. DIG." && $classe->vc_classe == 12 && $cont == 10) {

                break;
            }
            //    dd(notasFakes($id_aluno,$id_disciplina,$id_anoLectivo,$classe->id));

            $classe = Classe::where('vc_classe', $cont)->first();
            // dd(            $classe);
            $notas->push($nota->notasNoutrosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $classe->id)->get());

            $ttlClasses++;

            //  dd( $ttlClasses);
            $mediaDosAnos = 0;
            $classe = Classe::find($id_ultima_classe);
            // $notas[1][1]=['f'=>0];
            // for ($contAno = 0; $contAno < 3; $contAno++) {
            //     for ($contAno1 = 0; $contAno1 < 3; $contAno1++) {

            //         if (!isset($notas[$contAno][$contAno1])) {
            //             $notas[$contAno][1]='';
            //         }
            //     }
            // dd($notas);
            //     }

        }
        // dd(  $notas);

        //  dd($notas);
        // if ($id_aluno == '13518') {
        //     addNotasFakes($id_aluno,$notas, $classe->vc_classe,$id_disciplina,$id_anoLectivo);
        // }

        $notas = addNotasFakes($id_aluno, $notas, $classe->vc_classe, $id_disciplina, $id_anoLectivo);
        // dd($notas);
        foreach ($notas as $notasAnual) {
            // if ($id_aluno == '13518') {
            //     dd($notas[2][1]['id_classe']);
            // }
            //  dd($notas);

            $ca = 0;
            $mat1 = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media : 0;
            $mat2 = isset($notasAnual->where('vc_tipodaNota', 'II')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'II')->last()->fl_media : 0;
            $mat3 = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_media : 0;

            $mat1 = round(($mat1), 0, PHP_ROUND_HALF_UP);
            $mat2 = round(($mat2), 0, PHP_ROUND_HALF_UP);
            $mat3 = round(($mat3), 0, PHP_ROUND_HALF_UP);

            // if ($disciplina->vc_acronimo == "EMP" && $classe->vc_classe == 12) {
            //     dd($notasAnual,"o",$classe->vc_classe);
            // }
            if ($notasAnual->count()) {

                if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                    // dd($notasAnual);
                    $fl_nota1 = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1 : 0;
                    $fl_mac = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac : 0;
                    $mft = $fl_nota1 + $fl_mac;
                    $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                    $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                    $exame = isset($notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2) ? $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2 : 0;
                    $ca = ($mfd * 0.6) + ($exame * 0.4);
                    $ca = round(($ca), 0, PHP_ROUND_HALF_UP);
                    // dd(                $ca );
                } else {
                    $ca = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);
                }


                // if ($detalhes_turma->vc_classe == 12) {
                //     if (isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2)) {
                //         $exame = $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota2;
                //     } else {
                //         $exame = 0;
                //     }
                // }
                // $mft = isset($notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_media) ?
                // $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_nota1 + $notas->where('id_disciplina', $disciplina->id)->where('vc_tipodaNota', 'III')->where('id_aluno', $aluno->id)->first()->fl_mac : 0;

                // $mft = ceil($mft / 2);
                // $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);

                // $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);

                // $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);
                //guardar acs dos anos anteriores

                $id_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->id_classe : 0;
                $vc_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->vc_classe : 0;
                $vc_nome = isset($notasAnual->where('vc_tipodaNota', 'I')->last()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->last()->vc_nome : 0;
                //quando é vector as notas para o trimestre
                //    dd($notasAnual);
                if (!$id_classe) {
                    // dd($notasAnual);
                    if (isset($notasAnual[1]->id_classe)) {
                        $id_classe = $notasAnual[1]->id_classe;
                    } else if (isset($notasAnual[1]['id_classe'])) {
                        $id_classe = $notasAnual[1]['id_classe'];
                    }
                }
                if (!$vc_classe) {
                    if (isset($notasAnual[1]->vc_classe)) {
                        $vc_classe = $notasAnual[1]->vc_classe;
                    } else if (isset($notasAnual[1]['vc_classe'])) {
                        $vc_classe = $notasAnual[1]['vc_classe'];
                    }
                }
                if (!$vc_nome) {
                    if (isset($notasAnual[1]->vc_nome)) {
                        $vc_nome = $notasAnual[1]->vc_nome;
                    } else if (isset($notasAnual[1]['vc_nome'])) {
                        $vc_nome = $notasAnual[1]['vc_nome'];
                    }
                }
                if (isset($notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota1)) {
                    // dd("ola");
                    if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                        // dd($notasAnual);
                        $mft = $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota1 + $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_mac;
                        $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                        $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                        $exame = $notasAnual->where('vc_tipodaNota', 'FK')->last()->fl_nota2;
                        $ca = ($mfd * 0.6) + ($exame * 0.4);
                        $ca = round(($ca), 0, PHP_ROUND_HALF_UP);
                        // dd($ca12classe);
                        // dd(  $ca);
                    }
                } else {

                    if (isset($notasAnual[1]->vc_classe) && ($notasAnual[1]->vc_classe == 12 || $notasAnual[1]->vc_classe == 13)) {
                        // dd($notasAnual);
                        $mft = $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota1 + $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_mac;
                        $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
                        $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
                        $exame = $notasAnual->where('vc_tipodaNota', 'III')->last()->fl_nota2;
                        $ca = ($mfd * 0.6) + ($exame * 0.4);
                        $ca = round(($ca), 0, PHP_ROUND_HALF_UP);

                        // dd($ca, "ola");
                        // dd($ca12classe);
                        // dd(  $ca);
                    }
                }

                if (intVal($classe->vc_classe) > $vc_classe) {
                    // dd(intVal($classe->vc_classe) ,$vc_classe);
                    $CAS->push(['id_classe' => $id_classe, 'ca' => isset($ca12classe) ? $ca12classe : $ca, 'id_diciscplina' => $id_disciplina, 'vc_classe' => $vc_classe, 'vc_nome' => $vc_nome]);
                } else {
                }
            } else {
                //  dd($notasAnual->count(),$notasAnual, $notas,$mediaDosAnos);
                $ca = 0;
            }
            if ($disciplina->vc_acronimo == "SIST. DIG." && $classe->vc_classe == 12 && $cont == 10) {

                // dd(   $ca);
            }
            if ($disciplina->vc_acronimo == "EMP" && $classe->vc_classe == 12) {
                // dd("la",$ca,$classe->vc_classe);
            }
            $mediaDosAnos += $ca;
        }
        //    dd(  $CAS);
        // if(!$mediaDosAnos->count()){
        //     dd("ola");

        // }
        // if ($disciplina->vc_acronimo == "EMP" ) {
        //     dd("la",$mediaDosAnos,$notas->count());
        // }


        $media = round(($mediaDosAnos / ($notas->count() ? $notas->count() : 1)), 0, PHP_ROUND_HALF_UP);
        $dados['media'] = $media;
        $dados['ACS'] = $CAS;

        // dd($dados['ACS'] );
        // if ($id_aluno == '13518') {
        //     dd(  $dados['ACS']);
        // }

        return $dados;
    }
}

function componentes()
{
    return Componente::all();
}
function componentes_disciplinas()
{
    return ComponenteDisciplina::join('disciplinas', 'componente_disciplinas.id_disciplina', 'disciplinas.id')
        ->join('componentes', 'componente_disciplinas.id_componente', '=', 'componentes.id')
        ->select('componente_disciplinas.*', 'disciplinas.vc_acronimo', 'disciplinas.vc_nome', 'componentes.vc_componente');
}
function addNotasFakes($id_aluno, $notas, $ultimaClasse, $id_disciplina, $id_anoLectivo)
{
    // dd($notas,$ultimaClasse);
    for ($cont = $ultimaClasse; $cont >= 10; $cont--) {

        for ($cont1 = 0; $cont1 <= $ultimaClasse - 10; $cont1++) {
            // dd($notas[$cont1]);
            if (isset($notas[$cont1])) {
                for ($cont2 = 0; $cont2 <= 2; $cont2++) {
                    if (isset($notas[$cont1][$cont2])) {
                    } else {

                        if ($cont1 == 0) {
                            $classe = 10;
                        } else if ($cont1 == 1) {
                            $classe = 11;
                        } else if ($cont1 == 2) {
                            $classe = 12;
                        } else if ($cont1 == 3) {
                            $classe = 13;
                        }
                        $aluno = Alunno::find($id_aluno);
                        $id_classe = Classe::where('vc_classe', $classe)->first()->id;
                        // dd(    $notas[$cont1]);º
                        $dtd = new stdClass();
                        $dtd->it_idAluno = $id_aluno;
                        $dtd->vc_nome = Disciplinas::find($id_disciplina)->vc_nome;
                        $dtd->vc_acronimo = Disciplinas::find($id_disciplina)->vc_acronimo;
                        $dtd->vc_tipodaNota = "FK";
                        $dtd->id_classe = $id_classe;
                        $dtd->vc_classe = $classe;
                        $dtd->id_disciplina = $id_disciplina;
                        $dtd->fl_media = 0.0;
                        $dtd->fl_nota1 = 0.0;
                        $dtd->fl_nota2 = 0.0;
                        $dtd->fl_mac = 0.0;
                        $dtd->id_aluno = $id_aluno;
                        $dtd->vc_primeiroNome = $aluno->vc_primeiroNome;
                        $dtd->vc_nomedoMeio = $aluno->vc_nomedoMeio;
                        $dtd->vc_ultimoaNome = $aluno->vc_ultimoaNome;
                        $dtd->ya_inicio = 2021;
                        $dtd->ya_fim = 2022;
                        $dtd->id_anolectivo = $id_anoLectivo;
                        //  dd(  $dtd);

                        $notas[$cont1] = $notas[$cont1]->push(
                            $dtd
                        );

                        $notas[$cont1]->all();
                    }
                }
            }
        }
    }
    // dd($notas);
    return $notas;
}
function mediaDisciplinaNoAno($id_aluno, $id_turma, $id_CCD)
{
    $turma = Turma::find($id_turma);
    $id_curso = $turma->it_idCurso;
    $id_classe = $turma->it_idClasse;
    $it_idAnoLectivo = $turma->it_idAnoLectivo;
    $nota = Nota::where('id_aluno', $id_aluno)
        ->where('id_classe', $id_classe)
        ->where('it_disciplina', $id_CCD)
        ->where('id_turma', $id_turma)
        ->where('id_ano_lectivo', $it_idAnoLectivo)
        ->sum('fl_media') / 3;
    $nota = round(($nota), 0, PHP_ROUND_HALF_UP);
    return $nota;
}

function buscarCDF($id_aluno, $id_disciplina)
{

    $nota = new Nota;
    $notas = $nota->notasNoutrosAnos($id_aluno, $id_disciplina, "''", "''")->get();

    $classe = Classe::where('vc_classe', 12)->first();
    $disciplina = Disciplinas::find($id_disciplina);
    // dd($notas->where('id_disciplina', $id_disciplina));
    $classe_12 = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_tipodaNota', 'I')->where('vc_classe', '12')->where('id_aluno', $id_aluno)->first()->fl_media) ? 1 : 0;
    $mat1 = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'I')->where('id_aluno', $id_aluno)->first()->fl_media) ? $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'I')->where('id_aluno', $id_aluno)->first()->fl_media : 0;
    $mat2 = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'II')->where('id_aluno', $id_aluno)->first()->fl_media) ? $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'II')->where('id_aluno', $id_aluno)->first()->fl_media : 0;
    $mat3 = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_media) ? $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_media : 0;
    $id_curso = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->it_curso) ? $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->it_curso : 0;

    $terminal = disciplinas_terminas($classe->id, $id_curso)->where('disciplinas.id', $id_disciplina)->count();
    // if($id_disciplina==25){
    //     dd(disciplinas_terminas( $classe->id,$id_curso)->get(),"ola", $classe,$id_curso);
    //  }
    if ($classe_12 && $terminal) {
        //   dd("ola");
        $dataOutrosAnos = mediaDosAnos($id_aluno, $id_disciplina, "''", $classe->id);

        // dd($dataOutrosAnos);
        if ($classe_12) {
            if (isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_nota2)) {
                $exame = $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_nota2;
            } else {
                $exame = 0;
            }
        }

        // $mat1 = ceil($mat1);
        $mat1 = round(($mat1), 0, PHP_ROUND_HALF_UP);
        // $mat2 = ceil($mat2);
        $mat2 = round(($mat2), 0, PHP_ROUND_HALF_UP);
        // $mat3 = ceil($mat3);
        $mat3 = round(($mat3), 0, PHP_ROUND_HALF_UP);
        $mft = isset($notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_media) ?
            $notas->where('id_disciplina', $id_disciplina)->where('vc_classe', '12')->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_nota1 + $notas->where('id_disciplina', $id_disciplina)->where('vc_tipodaNota', 'III')->where('id_aluno', $id_aluno)->first()->fl_mac : 0;

        // $mft = ceil($mft / 2);
        $mft = round(($mft / 2), 0, PHP_ROUND_HALF_UP);
        // $mfd = ceil(($mat1 + $mat2 + $mft) / 3);
        $mfd = round((($mat1 + $mat2 + $mft) / 3), 0, PHP_ROUND_HALF_UP);
        $ac = round((($mfd * 0.6) + ($exame * 0.4)), 0, PHP_ROUND_HALF_UP);

        if (!temDisciplinaNoClasseAnterior($id_disciplina, 12, $id_curso)) {
            $array = array(
                $ac
            );
            $media = media($array);
            // dd($mat1,$mat2,$mft, $exame);   
            return round($media, 0, PHP_ROUND_HALF_UP);
        } else
            if ($classe_12) {
                // dd( $classe_12);
                $array = array(
                    $dataOutrosAnos['ACS']->sum('ca') / ($dataOutrosAnos['ACS']->count() ? $dataOutrosAnos['ACS']->count() : 1),
                    $ac
                );
                $media = media($array);
                return round($media, 0, PHP_ROUND_HALF_UP);
            }
    } else {
        return round(($notas->sum('fl_media') / ($notas->count() ? $notas->count() : 1)), 0, PHP_ROUND_HALF_UP);
    }
}
function media($array)
{
    // dd($array);

    $soma = 0;
    foreach ($array as $index) {
        $soma += $index;
    }
    return $soma / (count($array) ? count($array) : 1);
}
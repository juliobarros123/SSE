<?php

namespace App\Http\Controllers\Admin;
use App\Models\DeclaracaoSsemNota;
use App\Models\Alunno;
use App\Models\Matricula;
use App\Models\Cabecalho;
use App\Models\Classe;
use Illuminate\Http\Request;
use App\Models\Estudante;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\Logger;
use App\Models\Turma;
use Illuminate\Support\Facades\Auth;

//use DB;

class DeclaracaoSemNotasController extends Controller
{ // Begin (Meus objectos de Models)
  private  $declaracaosemnota, $aluno, $cabecalho, $classe, $matriculas, $pegarMatricula, $estudante;
 // End (Meus objectos de Models)

 // Begin (Minhas variáveis para emissão da declaração)
  
    //private $it_idClasse;??
         //Begin (variaveis dos dados da minha model)
             private $it_idDeclaracao, $vc_efeito, $it_id_Aluno,$vc_classe,$vc_tipoDeclaracao;
             private $vector;
        //End (variaveis dos dados da minha model)

        //Begin (variaveis dos dados do aluno)
             private $vc_nomeAluno;
             private $vc_nomeMae;
             private $vc_nomePai;
             private $vc_biEmissao;
             private $naturalidade;
             private $dt_dataNascimento;
             private $dt_biValidade;
             private $vc_turma;
        //End (variaveis dos dados do aluno)
    private $avaliar;private $id_erro;private $erro;private $avaliarUp;
// End (Minhas variáveis para emissão da declaração)

private $teste;
private $Logger;

// Construtor
public function __construct(DeclaracaoSsemNota $declaracaosemnota, Alunno $aluno, Cabecalho $cabecalho, Classe $classe,Matricula $matricula,Estudante $estudante)
{
    $this->declaracaosemnota=$declaracaosemnota;
    $this->aluno=$aluno;
    $this->cabecalho=$cabecalho;
    $this->avaliar=false;
    $this->avaliarUp=false;
    $this->classe=$classe;
    $this->matriculas=$matricula;
    $this->estudante=$estudante;
   // $this->$turma=$turma 
   $this->Logger = new Logger();
}
public function loggerData($mensagem){
    $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
    $this->Logger->Log('info', $dados_Auth.$mensagem);
}
public function retornando()
{
    
   
     $pegar=$this->estudante->entregando(1,2);
     echo $pegar['turma'];
    //else echo 'tá pico';
}



// Begin controller que pega os dados do formulario para a cadastro das declarações
public function pegarDadosDecla(Request $request)
{
    
   //global $it_id_Aluno,$it_idClasse,$vc_efeito;
    $this->it_id_Aluno=$request->input('idAluno');
    $this->it_idClasse=$request->input('AlClasse');
    $this->vc_efeito=$request->input('efeito');   
    $this->vc_tipoDeclaracao=$request->input('tipoDeclaracao');

    $this->pegarDadosAlunos();
    
    if( $this->avaliar)
           
        return redirect()->route('lista');
       
    else 
    {   
       echo "Houve um erro, aluno não exite ou ainda não chegou a classe";
    }
    
    
}
// End controller que pega os dados do formulario para a cadastro das declarações



// Begin controller que Verifica se os dados do aluno e os inseridos na declaração batem
public function pegarDadosAlunos(){

if($this->vc_tipoDeclaracao=="DECLARAÇÃO DE FREQUÊNCIA")
   // $this->it_idClasse=$pegaAluno->it_classe;// pegar classe
   // $this->it_idClasse=$pegaAluno->it_classe;// pegar classe
$this->cadastrar($this->it_id_Aluno,$this->vc_efeito,$this->it_idClasse,$this->vc_tipoDeclaracao);
   else 
   if($this->vc_tipoDeclaracao=="DECLARAÇÃO DE APROVEITAMENTO")  {
    $this->cadastrar($this->it_id_Aluno,$this->vc_efeito,$this->it_idClasse,$this->vc_tipoDeclaracao); 
   }                  
}  
    
// End controller que Verifica se os dados do aluno e os inseridos na declaração batem


    // Begin (controller responsavel pela captura dos dados da declaracao)

    public function paginaDeclaracao($it_idDeclaracao)
    {   
    
        // Begin (pegando os valores da declaracao e do aluno)
        $pegaDeclaracao=$this->declaracaosemnota->find($it_idDeclaracao);
        $pegaAluno=$this->aluno->find($pegaDeclaracao->it_id_processoAluno);
        $pegaCabecalho=$this->cabecalho->find(1); 
//dd($pegaDeclaracao->it_id_processoAluno);
       $matriculaA =  Matricula::where('id_aluno', $pegaDeclaracao->it_id_processoAluno)
       ->where('vc_anoLectivo',$pegaAluno->vc_anoLectivo)->limit(1)->get();
     $matricula = json_decode($matriculaA[0]);

     $turma = Turma::find($matricula->it_idTurma);
       // dd();
       //   $this->pegarMatricula=$this->estudante->entregando( $pegaDeclaracao->it_id_Aluno, $pegaDeclaracao->it_idClasse);
        // End (pegando os valores da declaracao e do aluno)
        $vc_classificacao="Ainda não implementada";
        $vc_FrequenciaAproveitamento="";

        if($pegaDeclaracao->vc_tipoDeclaracao=="DECLARAÇÃO DE APROVEITAMENTO")
        {
            $vc_FrequenciaAproveitamento='frequentou no ano lectivo <strong>'.$pegaAluno->vc_anoLectivo.'</strong> o curso <strong>'.$pegaAluno->vc_nomeCurso.'</strong>, a <strong> '.$pegaDeclaracao->classe.'ª</strong> Classe em tendo obtido a classificação final '.$vc_classificacao.'.';    
        }
        else if($pegaDeclaracao->vc_tipoDeclaracao=="DECLARAÇÃO DE FREQUÊNCIA")
        //dd($pegaAluno->vc_turma);
        //pegaDeclaracao
        $classe = classe::find($pegaDeclaracao->classe)->vc_classe;
      
        
        
        $vc_FrequenciaAproveitamento='frequenta no ano lectivo  <strong>'.$pegaAluno->vc_anoLectivo.'</strong> o curso <strong>'.$pegaAluno->vc_nomeCurso.'</strong>, na turma <strong>'.$turma->vc_nomedaTurma.'</strong>, a <strong> '.$classe.'ª</strong> Classe.';  
            
        $dadosDinamicos['pegaCabecalho'] = $pegaCabecalho;
        $dadosDinamicos['pegaDeclaracao']=$pegaDeclaracao;
       
        $dadosDinamicos['pegaAluno']=$pegaAluno;
        $dadosDinamicos['frequencia']=$vc_FrequenciaAproveitamento;
        $dadosDinamicos['nome']=$pegaAluno->vc_primeiroNome.' '.$pegaAluno->vc_nomedoMeio.' '.$pegaAluno->vc_ultimoaNome;
        $nome="Andrade";
        $mpdf= new \Mpdf\Mpdf();
        
        $declaracao = view("admin/declaracaoSemNotas/declaracao/index",$dadosDinamicos/*,$dataAluno*/);
        $mpdf->writeHTML($declaracao);
        $mpdf->Output();
     
    }
  // End (controller responsavel pela captura dos dados da declaracao)

   
    public function paginaCadastro()
    {try {
       $classes=$this->classe->all();
       return view('admin.declaracaoSemNotas.criar.index',compact('classes'));
    }
    catch(\Exception $e){
        return redirect('admin.declaracaoSemNotas.criar.index');
    }
    }

    public function paginaVisualizar()
    {
      
       return  view('admin.declaracaoSemNotas.visualizar.index');
    }

    public function paginaActualizar($id)
    {  
        $classes=$this->classe->all();
        $dadosActualizar=$this->declaracaosemnota->find($id);
        return view('admin.declaracaoSemNotas.actualizar.index',compact('dadosActualizar','classes'));
    }

    public function paginaErros($id_erro)
    { 
        //1- processo não existe, 2- não chegou a essa classe(cadastrar), 3- não chegou a essa classe(actualizar) 
        if($id_erro==1)
         {
             $this->erro="O processo digitado não existe";
         }
    
         if($id_erro==2)
         {
            $this->erro="O aluno referido ainda não chegou a essa classe";
         }
    
         if($id_erro==3)
         {
            $this->erro="O aluno referido ainda não chegou a essa classe";
         }
    
         if($id_erro==4)
         {
            $this->erro="O processo digitado não existe";
         }
         $erro=$this->erro;
        return view('admin.declaracaoSemNotas.mostrarErros.index',compact('id_erro','erro'));
    }

// Begin (Controllers que manipulam o CRUD)

    //Begin (Controller que faz o cadastro)
    public function cadastrar($aluno,$vc_efeito,$it_classe,$vc_tipoDeclaracao)
    {
        $insert=$this->declaracaosemnota->create
        ([
            'it_id_processoAluno'=>$aluno,
            'vc_efeito'=>$vc_efeito,
            'dt_declaracao'=>date("Y/m/d"),
            'classe'=>$it_classe, 
            'vc_tipoDeclaracao'=>$vc_tipoDeclaracao,  
        ]

        );

        
        if($insert)
        {
            $this->loggerData('Adicionou Uma Declaração Sem Nota');
            $this->avaliar=$insert;
        }
        
        else
        return "Houve um erro na declaracao do aluno "+ $aluno;
        
    }
    //End (Controller que faz o cadastro)

    //Begin (Controller que faz a actualização)
    
    public function verificarAluno($it_id_Aluno)
    {
        if($pegaAluno=$this->aluno->find($it_id_Aluno)){

            if(($pegaAluno->it_classe-$it_idClasse)>=0)
            echo 1;
        }

    }

    public function actualizar(Request $request)
    {
        $idDeclaracao=$request->input('id');
        $it_id_Aluno=$request->input('idAluno');
        $it_idClasse=$request->input('AlClasse');
        $vc_efeito=$request->input('efeito');
        $vc_tipoDeclaracao=$request->input('tipoDeclaracao');   
        if($pegaAluno=$this->aluno->find($it_id_Aluno)){

        if(($pegaAluno->it_classe-$it_idClasse)>=0)
        {   if($vc_tipoDeclaracao=="DECLARAÇÃO DE FREQUÊNCIA")
                $it_idClasse=$pegaAluno->it_classe;

            $verificar= $this->declaracaosemnota->where('id',$idDeclaracao)->update([
                'it_id_processoAluno'=>$it_id_Aluno,
                'dt_declaracao'=>date("Y/m/d"),
                'vc_efeito'=>$vc_efeito,
                'vc_tipoDeclaracao'=>$vc_tipoDeclaracao,
                'classe'=>$it_idClasse,
                ]);
                
                if($verificar) {
                     $this->loggerData(' Actualizou Declaração Sem Nota do aluno ',Alunno::find($it_id_Aluno)->vc_primeiroNome);
                    return redirect()->route('lista',['aluno'=>$it_id_Aluno,'declaracao'=>$idDeclaracao]);  
                }
               
                else {
                     return 'A actualização ocorreu mal';
                }
                   
                  
        }
    else 
       {//$this->erro="O aluno".$pegaAluno->vc_primeiroNome.$pegaAluno->vc_nomedoMeio.$pegaAluno->vc_ultimoNome." ainda não chegou a essa classe";
        $this->id_erro=3;
        if($this->id_erro==3)
            {  $id_erro=$this->id_erro;
                return $this->paginaErros($id_erro);
            }
            //$this->id_erro=4;
       }

        }

        else 
        { $this->id_erro=4;
            if($this->id_erro==4)
            {  $id_erro=$this->id_erro;
                return $this->paginaErros($id_erro);
            }
        }
    }
    //End (Controller que faz a actualização)

    //Begin (Controller que faz a eliminação)
   public function eliminar($it_idDeclaracao)
   {     
      $declaracao=$this->declaracaosemnota->find($it_idDeclaracao);
       $eliminar=$declaracao->delete();
       if($eliminar){
        $this->loggerData('Eliminou Uma Declaração Sem Nota');
           return redirect()->route('lista');
       }
           
                     
       else{
            return 'Não conseguiu eliminar';
       }
          
   }

   //End (Controller que faz a eliminação)

// End (Controllers que manipulam o CRUD)   

    

    //Begin (Controllerers que fazem a filtragem dos registos a serem visualizados)
        //Begin (Request da página visualização)    
    public function manipularVisualizacao(Request $request)
    {
        $this->it_id_Aluno=$request->input('aluno');
        $this->it_id_declaracao=$request->input('declaracao');
        $this->it_idClasse=$request->input('Alclasse');
       // $aluno=$this->it_id_Aluno;
       // $declaracao=$this->it_id_declaracao;
        return redirect()->route('lista',['aluno'=>$this->it_id_Aluno,'declaracao'=>$this->it_id_declaracao]);     
    }   
        //End (Request da página visualização)

        //Begin (filtragem dos registos a serem visualizados)
    public function mostrarLista($aluno='',$declaracao='')
    {
       
        $declaracaosemnotas=$this->declaracaosemnota->all();
       // return view('admin.declaracaoSemNotas.tabelaDeclaracoes.index',compact('declaracaosemnotas','aluno','declaracao'));
        if($aluno==""  && $declaracao=="")
        {
            
        $declaracaosemnotas=$this->declaracaosemnota->all();
        return view('admin.declaracaoSemNotas.tabelaDeclaracoes.index',compact('declaracaosemnotas'));
        } 

        else if(($aluno!="" || $aluno=="")  && $declaracao==!"" )
        {
            $declaracaosemnotas=DeclaracaoSsemNota::where('id',$declaracao)->get();
        
            return view('admin.declaracaoSemNotas.tabelaDeclaracoes.index',compact('declaracaosemnotas'));
        } 

       else if($aluno!="")
        {
            $declaracaosemnotas=DeclaracaoSsemNota::where('it_id_processoAluno',$aluno)->get();
            
            return view('admin.declaracaoSemNotas.tabelaDeclaracoes.index',compact('declaracaosemnotas'));
        }  
    }
            //End (filtragem dos registos a serem visualizados)
    
   //End (Controllerers que fazem a filtragem dos registos a serem visualizados)

    
   
}
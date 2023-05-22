<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Alunno;
use App\Models\Candidatura;
use Illuminate\Support\Facades\Auth;

class ConexaoDosSistemas extends Controller
{
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function postAluno(){

       // dd(public_path());


        $endereco_ws = "http://172.16.50.83:8003/api/alunos/todos";
        // abre a conexão
        $ch = curl_init();
        ini_set('max_execution_time', 300); // 5 minutes
        // define url
        curl_setopt($ch, CURLOPT_URL, $endereco_ws);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 700000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 700000); //timeout in seconds
        // executa o post
        $resultado = curl_exec($ch);

        if (curl_error($ch)) {
            echo 'Erro:' . curl_error($ch);
            return false;
        }

        // dd($this->generateRandomString());
        // fecha a conexão
        curl_close($ch);

       

        $data = (array) json_decode($resultado);

       // dd($data);
        foreach ($data as $a) {
           
            $data = Alunno::where("vc_bi", $a->vc_bi)->first();
       
            if ($data === null) {
                $arr = array($a);
              
              //  dd($a);
                    
                    $aluno = Alunno::create([
                                'id' => $a->id,
                                'vc_anoLectivo' => "ss",
                                'tokenKey' => $a->id,
                                'vc_primeiroNome'=>$a->vc_primeiroNome, 
                                'vc_nomedoMeio'=> $a->vc_nomedoMeio,
                                'vc_ultimoaNome' => $a->vc_ultimoaNome,
                                'it_classe' => $a->it_classe,
                                'dt_dataNascimento'=> $a->dt_dataNascimento,
                                'vc_naturalidade' => $a->vc_naturalidade,
                                'vc_naturalidade'=> $a->vc_naturalidade,
                                'vc_provincia'=> $a->vc_provincia,
                                'vc_namePai'=> $a->vc_namePai,
                                'vc_nameMae'=>  $a->vc_nameMae,
                                'vc_dificiencia'=> $a->vc_dificiencia,
                                'vc_estadoCivil' => $a->vc_estadoCivil,
                                'vc_genero' => $a->vc_genero,
                                'it_telefone' => $a->it_telefone,
                                'vc_email' => $a->vc_email,
                                'vc_residencia' => $a->vc_residencia,

                                'vc_bi' => $a->vc_bi,
                                'dt_emissao' => $a->dt_emissao,
                                'vc_localEmissao' => $a->vc_localEmissao,
                                'vc_EscolaAnterior' => $a->vc_EscolaAnterior,
                                'ya_anoConclusao' => $a->ya_anoConclusao,
                                'vc_nomeCurso' => $a->vc_nomeCurso,

                                'dt_anoCandidatura' => $a->dt_anoCandidatura,
                                'it_media' => $a->it_media,
                                'vc_anoLectivo' => $a->vc_anoLectivo,
                                'tokenKey' => $a->tokenKey,
                                'foto' => $a->foto,
                                'it_estado_aluno' => $a->it_estado_aluno
                        ]);
                    //dd($data);
                    if ($a->foto != null) {
                       $this->donwloadImage($a->foto);
                    }
                
            }
        }

        return redirect()->route('home');

    }

    public function getAluno(){
        $alunos = Alunno::all();
        //return "dd";
        return response($alunos,200);
    }

    public function donwloadImage(String $image)
    {

        // dd($ids);


        /* Cria um novo arquivo e caso o arquivo exista, substitui */
        $file = fopen("confirmados/{$image}", "w+");
        ini_set('max_execution_time', 300); // 5 minutes
        /* Cria uma nova instância do cURL */
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 700000);
        curl_setopt($curl, CURLOPT_TIMEOUT, 700000); //timeout in seconds
        curl_setopt_array($curl, [
            /* Define a URL */
            CURLOPT_URL            => "http://172.16.50.83:8003/confirmados/" . $image,

            /* Informa que você quer receber o retorno */
            CURLOPT_RETURNTRANSFER => true,

            /* Define o "resource" do arquivo (Onde o arquivo deve ser salvo) */
            CURLOPT_FILE           => $file,

            /* Desabilita a verificação do SSL */
            CURLOPT_SSL_VERIFYPEER => true
        ]);

        /* Envia a requisição e fecha as conexões em seguida */
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }
    public function getPath(){
        //$alunos = Alunno::all();
        //return "dd";
        $caminho = public_path();
        return response($caminho,200);

}



}

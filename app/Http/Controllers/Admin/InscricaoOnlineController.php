<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Candidatura;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Http\Resources\InscricaoOnline as InscricaoOnlineResource;
use App\Models\AnoLectivo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class InscricaoOnlineController extends Controller
{
    //
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function getInscritos()
    {
        $candidatos = Candidatura::all();
        return InscricaoOnlineResource::collection($candidatos);

    }

    public function index(Request $request){

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

            $anoLectivo = AnoLectivo::where('it_estado_anoLectivo',[1])->first();

            $data = (array) json_decode($resultado);
           // dd($data);
            foreach ($data as $a) {
                $data = Candidatura::where("vc_bi",$a->BI)->first();
                if($data === null){
                    Candidatura::create([
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
                        "vc_anoLectivo" =>$anoLectivo->ya_inicio."-".$anoLectivo->ya_fim,
                        "it_estado_candidato" => "1",
                        "vc_vezesdCandidatura" => "0",
                        "it_telefone"=> $a->CellPhone,
                        "tokenKey" => $a->tokenKey,
                        "LP_S" =>$a->LP_S,
                        "LP_O" =>$a->LP_O,
                        "LP_N" =>$a->LP_N,
                        "MAT_S" =>$a->MAT_S,
                        "MAT_O" =>$a->MAT_O,
                        "MAT_N" =>$a->MAT_N,
                        "FIS_S" =>$a->FIS_S,
                        "FIS_O" =>$a->FIS_O,
                        "FIS_N" =>$a->FIS_N,
                        "QUIM_S" =>$a->QUIM_S,
                        "QUIM_O" =>$a->QUIM_O,
                        "QUIM_N" =>$a->QUIM_N,
                        "estado_de_pagamento" =>$a->estado_de_pagamento,
                        "media" =>$a->media,

                    ]);
                }

            }

            return redirect()->back();
    }


    function generateRandomString($size = 9)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
        $randomString = '';
        for ($i = 0; $i < $size; $i = $i + 1) {
            $randomString .= $chars[mt_rand(0, 60)];
        }
        return $randomString;
    }


}

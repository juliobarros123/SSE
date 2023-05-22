<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AlunoResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {

       //    dd($this);
        return [
            "processo" => $this->id,
            "vc_primeiroNome" => $this->vc_primeiroNome,
            "vc_email" => $this->vc_email,
            "vc_nomeCurso" => $this->vc_nomeCurso,
            "vc_classe" => $this->vc_classe,
            "vc_nomedaTurma" => $this->vc_nomedaTurma,
            "vc_namePai" => $this->vc_namePai,
            "vc_ultimoaNome" => $this->vc_ultimoaNome,
            "vc_nameMae" => $this->vc_ultimoaNome,

        ];
    }
}

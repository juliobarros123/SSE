<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
 abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
 dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
 do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Candidatura extends Model
{
    use HasFactory;
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash_bcrypt = '';
            $hash_bcrypt = Hash::make(slug_gerar());
            $stringSemBarras = str_replace('/', '', $hash_bcrypt);
            $model->slug = $stringSemBarras;
        });
    }
    protected $table = 'candidatos';
    protected $fillable = ['id_cabecalho','slug', 
    'id_classe','id_curso','id_ano_lectivo',
        'vc_primeiroNome', 'vc_nomedoMeio', 'vc_apelido', 'dt_dataNascimento',
        'vc_nomePai', 'vc_nomeMae', 'vc_genero', 'vc_dificiencia', 'vc_estadoCivil',
        'it_telefone', 'vc_email', 'vc_residencia', 'vc_naturalidade', 'vc_provincia',
        'vc_bi', 'dt_emissao', 'vc_localEmissao', 'vc_EscolaAnterior', 'ya_anoConclusao',
        'vc_nomeCurso','vc_classe', 'vc_anoLectivo', 'vc_vezesdCandidatura','it_estado_candidato','tokenKey','LP_S','LP_O','LP_N',
        'LP_S' ,'LP_O' , 'LP_N' , 'MAT_S' ,'MAT_O' , 'MAT_N' , 'FIS_S' ,'FIS_O' ,'FIS_N' , 'QUIM_S' ,'QUIM_O','QUIM_N','estado_de_pagamento', 'media',
        'state'
    ];


    public  function CandidaturasListas($anoLectivo, $curso)
    {
        $Rcandidatos = DB::table('candidatos')
            ->orderby('vc_primeiroNome', 'asc')->orderby('vc_nomedoMeio', 'asc')->orderby('vc_apelido', 'asc');
        if ($anoLectivo && $anoLectivo != 'Todos') {
            $Rcandidatos->where([['candidatos.vc_anoLectivo', $anoLectivo]]);
        }
        if ($curso && $curso != 'Todos') {
            $Rcandidatos->where([['candidatos.vc_nomeCurso', $curso]]);
        }

        return $Rcandidatos;
    }
}

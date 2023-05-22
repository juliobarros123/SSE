<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Candidato2 extends Model
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
    // $candidato2->vc_classe
    protected $fillable = ['id_cabecalho','slug', 
        'id', 'vc_primeiroNome', 'vc_nomedoMeio', 'vc_ultimoaNome', 'it_classe',
        'dt_dataNascimento', 'vc_naturalidade', 'vc_provincia', 'vc_namePai', 'vc_nameMae', 'vc_dificiencia', 'vc_estadoCivil',
        'vc_genero', 'it_telefone', 'vc_email', 'vc_residencia', 'vc_bi',
        'dt_emissao', 'vc_localEmissao', 'vc_EscolaAnterior', 'ya_anoConclusao', 'vc_nomeCurso', 'dt_anoCandidatura',
        'it_media', 'vc_anoLectivo', 'it_estado_aluno', 'tokenKey', 'foto', 'it_processo', 'idade'
    ];
}
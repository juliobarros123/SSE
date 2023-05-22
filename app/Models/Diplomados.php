<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Diplomados extends Model
{
    protected $fillable = ['id_cabecalho','slug', 'it_estado','it_id_aluno','id_curso','vc_primeiroNome','vc_nomeMeio','vc_ultimoNome','vc_nomeMae','vc_nomePai','vc_nBI','dt_dataNascimento','dt_dataEmissaoBilhete'];
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
}

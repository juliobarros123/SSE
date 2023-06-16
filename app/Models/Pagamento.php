<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;

class Pagamento extends Model
{
   
    use HasFactory;
    protected $fillable = [
        'mes',
        'id_tipo_pagamento',
        'id_aluno',
        'id_cabecalho',
        'id_ano_lectivo',
        'valor_final',
        'slug'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $hash_bcrypt = '';
            $hash_bcrypt = Hash::make(slug_gerar());
            $stringSemBarras = str_replace('/', '', $hash_bcrypt);
            $model->slug = $stringSemBarras;
            $model->id_cabecalho =Auth::User()->id_cabecalho;
        });
    }
}

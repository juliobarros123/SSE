<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class FundoCartao extends Model
{
    use HasFactory;
    protected $fillable = [
        'entidade',
        'fundo',
        'slug',
        'id_cabecalho',

    ];
    protected static function boot()
    {

        parent::boot();

        static::creating(function ($model) {
            $hash_bcrypt = '';
            $hash_bcrypt = Hash::make(slug_gerar());
            $stringSemBarras = str_replace('/', '', $hash_bcrypt);
            $model->slug = $stringSemBarras;
            $model->id_cabecalho = Auth::User()->id_cabecalho;

        });
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
;

class TipoPagamento extends Model
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
            $model->id_cabecalho = Auth::User()->id_cabecalho;
        });
    }
    protected $fillable = [
        'pagamento',
        'tipo',
        'dias_multa',
        'multa_valor',
        'valor',
        'id_classe',
        'id_cabecalho',
        'slug'
    ];


}
<?php

namespace App\Models;

use Auth;
                                    use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class MultaMensalidade extends Model
{

    
    use HasFactory;
    protected $fillable = [
        'dias_multa',
        'multa_valor',
        'id_classe',
        'id_cabecalho',
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
            $model->id_cabecalho = Auth::User()->id_cabecalho;

        });
    }
}
<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InicioTerminoAnoLectivo extends Model
{
    use HasFactory;
    use HasFactory;

    protected $fillable = [
        'mes_inicio',
        'mes_termino',
        'id_ano_lectivo',
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
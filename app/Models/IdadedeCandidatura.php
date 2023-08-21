<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class IdadedeCandidatura extends Model
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

    protected $table = 'idadesdecandidaturas';
    protected $fillable = ['id_cabecalho','slug', 
        'dt_limiteaesquerda',
        'dt_limitemaxima',
        'id_ano_lectivo',
        'it_estado_idadedecandidatura'
    ];
}

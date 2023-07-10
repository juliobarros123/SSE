<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Funcionario extends Model
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
    protected $table = 'funcionarios';
    protected $fillable = ['id_cabecalho','slug', 
        'vc_primeiroNome',
        'vc_ultimoNome',
        'vc_bi',
        'vc_foto',
        'vc_funcao',
        'ya_anoValidade',
        'dt_nascimento',
        'vc_agente',
        'vc_telefone',
        'it_estado_funcionario'

    ];
}

<?php

namespace App\Models;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ComponenteDisciplina extends Model
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

    protected $fillable = ['id_cabecalho', 'slug', 'id_disciplina', 'id_componente'];
    public function tem_registro($array)
    {
        $array_limpo = $array->except('_token', '_method');

        return fh_componentes_disciplinas()->where($array_limpo)->count();
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disciplinas extends Model
{
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

    protected $fillable = ['id_cabecalho','slug', 
        'vc_nome',
       /*  'it_curso',
        'it_classe', */
        'vc_acronimo',
        'it_estado_disciplina'

        ];
        public function curso()
        {
            return $this->belongsTo(Curso::class);
        }
        public function notas()
        {
            return $this->belongsToMany(Nota::class);
        }
        public function classes()
        {
            return $this->belongsToMany(Classe::class);
        }
        public function turmas_users(){
            return $this->hasMany(TurmaUser::class);
        }

}

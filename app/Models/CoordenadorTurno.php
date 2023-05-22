<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;
class CoordenadorTurno extends Model
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
    protected $fillable=[
        'turno',
        'id_user',
        'id_ano_lectivo',
        'estado_coordenador_turno'
    ];

    public  function todos()
    {
        $result = DB::table('coordenador_turnos')
        ->join('users','users.id','coordenador_turnos.id_user')
        ->join('anoslectivos','anoslectivos.id','coordenador_turnos.id_ano_lectivo')
        ->where('estado_coordenador_turno',1)
        ->select(
        
          'coordenador_turnos.*',
          'users.vc_primemiroNome',
          'users.vc_apelido',
          'anoslectivos.ya_inicio',
          'anoslectivos.ya_fim')
       ;
        return  $result;
      }

      public function tem_registro($array){
        $array_limpo = $array->except('_token','_method','id_user');
   
        return CoordenadorTurno::where($array_limpo)->where('estado_coordenador_turno',1)->count();
      
      }
    }

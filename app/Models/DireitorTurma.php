<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Exception;
class DireitorTurma extends Model
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
    protected $fillable = ['id_cabecalho','slug', 'id_turma','id_user','id','id_classe','id_curso','id_anoLectivo','it_estado_dt'];

    public function tem_registro($array){
        $array_limpo = $array->except('_token');
        return DireitorTurma::where($array_limpo)->where('it_estado_dt',1)->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }
      
      }
      public function turma_tem_director($id_turma){

      $estado=DireitorTurma::where('id_turma',$id_turma)->where('it_estado_dt',1)->count();
    
        if($estado){
         throw new Exception('Esta turma já tem director');
        }
      
      }
}

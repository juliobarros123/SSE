<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class Debito extends Model
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
    protected $fillable = ['id_cabecalho','slug', 
        'it_id_mes',
        'dc_valor',
        'vc_debito',
        'vc_descricao',
        'ya_ano'
    ];

    public function listarDebitos() {
        $dados = DB::table('debitos')->where('debitos.it_estado',1)
            ->join('mes', 'debitos.it_id_mes', '=', 'mes.id')
            ->select('mes.*', 'debitos.*')
            ->get();

            return $dados;
    }

    public function pegarDebito($id) {
        $dados = DB::table('debitos')->find($id)
            ->join('mes', 'debitos.it_id_mes', '=', 'mes.id')
            ->select('mes.*', 'debitos.*')
            ->get();

            return $dados;
    }
    
}

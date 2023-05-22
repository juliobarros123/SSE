<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class LogUser extends Model
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
    protected $table = 'logs';
    protected $fillable = ['id_cabecalho','slug', 
        'it_idUser',
        'vc_descricao',
    ];

    public  function LogsForSearch($anoLectivo, $utilizador)
    {

        $response['logs'] = DB::table('logs')
            ->join('users', 'users.id', '=', 'logs.it_idUser')
            ->select('logs.*', 'users.vc_primemiroNome', 'users.vc_apelido')
            ->whereYear('logs.created_at', '=', $anoLectivo)
            ->where([
                ['users.vc_apelido', '=', $utilizador]
            ]);
        if ($anoLectivo == 'Todos' && $utilizador == 'Todos') {
            $response['logs'] = DB::table('logs')
                ->join('users', 'users.id', '=', 'logs.it_idUser')
                ->select('logs.*', 'users.vc_primemiroNome', 'users.vc_apelido');
        } else if ($anoLectivo == 'Todos' && $utilizador) {

            $response['logs'] = DB::table('logs')
                ->join('users', 'users.id', '=', 'logs.it_idUser')
                ->select('logs.*', 'users.vc_primemiroNome', 'users.vc_apelido')
                ->where([
                    ['users.vc_apelido', '=', $utilizador]
                ]);
        } else if ($utilizador == 'Todos' && $anoLectivo) {
            $response['logs'] = DB::table('logs')
                ->join('users', 'users.id', '=', 'logs.it_idUser')
                ->select('logs.*', 'users.vc_primemiroNome', 'users.vc_apelido')
                ->whereYear('logs.created_at', '=', $anoLectivo);
        }

        return  $response['logs']->get();
    }
}

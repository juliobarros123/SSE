<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cabecalho extends Model
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
    protected $table = 'cabecalhos';
    protected $fillable = [ 
        'id', 'vc_logo', 'vc_ensignia', 'vc_escola', 'vc_acronimo', 'vc_nif', 'vc_republica', 'vc_ministerio',
        'vc_endereco', 'it_telefone', 'vc_email', 'vc_nomeDirector',
        'vc_nomeSubdirectorPedagogico', 'vc_nomeSubdirectorAdminFinanceiro','vc_tipo_escola','it_id_municipio',
        'vc_numero_escola','assinatura_director','director_municipal','estado_cabecalho'

    ];
}

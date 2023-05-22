<?php
/* Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
 abrigo do decreto executivo conjunto nº29/85 de 29 de Abril,
 dos Ministérios da Educação e dos Transportes e Comunicações,
publicado no Diário da República, 1ª série nº 35/85, nos termos
 do artigo 62º da Lei Constitucional.

contactos:
site:www.itel.gov.ao
Telefone I: +244 931 313 333
Telefone II: +244 997 788 768
Telefone III: +244 222 381 640
Email I: secretariaitel@hotmail.com
Email II: geral@itel.gov.ao*/
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Disciplinas extends Model
{

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

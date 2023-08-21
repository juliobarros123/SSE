<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classe extends Model
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
    protected $fillable = ['id_cabecalho','slug', 'vc_classe', 'it_estado_classe'];

    public function matriculas()
    {
        return $this->hasMany(Matricula::class);
    }
    public function turmas_users()
    {
        return $this->hasMany(TurmaUser::class);
    }

    public function postClasse($classe,$uri)
    {

            $post = [
                'vc_classe' => $classe->vc_classe,
                'it_estado' => $classe->it_estado_classe,
            ];
            $uriP ='http://192.168.1.63:8000/admin/classe/store';

            $ch = curl_init($uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

            // execute!
            $response = curl_exec($ch);

            // close the connection, release resources used
            curl_close($ch);

             // do anything you want with your response
             //   dd($response);

     //   dd("Terminou tudo");


    }

    public function allpost(){
        $classes = Classe::all();
            foreach($classes as $classe){
                $post = [
                    'vc_classe' => $classe->vc_classe,
                    'it_estado' => $classe->it_estado_classe,
                ];

                $ch = curl_init('http://192.168.1.63:8000/admin/classe/store');
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

                // execute!
                $response = curl_exec($ch);

                // close the connection, release resources used
                curl_close($ch);

                // do anything you want with your response
            //   dd($response);

            }
            dd("Terminou tudo");

    }
}

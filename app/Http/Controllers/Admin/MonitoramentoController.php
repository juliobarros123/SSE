<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use Illuminate\Http\Request;

class MonitoramentoController extends Controller
{
    public function postClasse($classe,$uri)
    {

            $post = [
                'vc_classe' => $classe->vc_classe,
                'it_estado' => '1',
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
          /*
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
        */

    }
}

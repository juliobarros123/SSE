<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InicioTerminoAnoLectivo;
class InicioTerminoAnoLectivoController extends Controller
{
    //
    public function criar()
    {
        $response['anos_lectivos'] = fh_anos_lectivos()->get();
        return view('admin.inicio-termino-ano-lectivo.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {
        // dd($request);

        try {
            $data = $request->all();
            // dd(auth()->id_cabecalho);
            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro já existe']);

            }

            InicioTerminoAnoLectivo::create($request->all());
            return redirect()->route('inicio-termino-ano-lectivo')->with('feedback', ['type' => 'success', 'sms' => 'Registro cadastrado com sucesso']);

        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request,$slug);

        try {
            $data = $request->all();

            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro já existe']);

            }
            //




            InicioTerminoAnoLectivo::where('slug', $slug)->update(
                $request->except(['_token', '_method'])
            );
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Registro actualizado com sucesso']);




        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }
    //
    public function editar($slug)
    {
        $inicio_termino_ano_lectivo = fh_inicio_termino_ano_lectivo()->where('inicio_termino_ano_lectivos.slug', $slug)->first();
        if ($inicio_termino_ano_lectivo):
            // dd($inicio_termino_ano_lectivo);
            $data['inicio_termino_ano_lectivo'] = $inicio_termino_ano_lectivo;
            $data['anos_lectivos'] = fh_anos_lectivos()->get();

          
            return view('admin.inicio-termino-ano-lectivo.editar.index', $data);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($array)
    {
        $array_limpo = $array->except(['_token', '_method']);
        // dd( $array_limpo);
        return fh_inicio_termino_ano_lectivo()->where($array_limpo)->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }

    }

    public function eliminar($slug)
    {


        $inicio_termino_ano_lectivo = InicioTerminoAnoLectivo::where('inicio_termino_ano_lectivos.slug', $slug)->first();
        if ($inicio_termino_ano_lectivo):
            InicioTerminoAnoLectivo::where('inicio_termino_ano_lectivos.slug', $slug)->delete();
            // $this->loggerData('Eliminou  director de turma com id  ', $director_turma->id);
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Registro eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }

    public function index()
    {
        $data['inicio_termino_ano_lectivo'] = fh_inicio_termino_ano_lectivo()->get();


        //  dd($data);
        return view('admin.inicio-termino-ano-lectivo.index', $data);
    }
}

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

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AnoLectivo;
use App\Models\Cabecalho;
use App\Models\Curso;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
 

    
    public function index()
    {

        $cursos = fh_cursos()->get();
        return view('admin/cursos/index/index', compact('cursos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('admin/cursos/create/index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->all();
        $storeData['id_cabecalho'] = Auth::User()->id_cabecalho;

        //$cursos = Curso::where('vc_nomeCurso', '=',  $request->vc_nomeCurso)->first();
        //if($cursos === null){
        try {

            $show = Curso::create($storeData);
            

            $this->loggerData("Adicionou Um Curso " . $request->vc_nomeCurso);

        }
        //}else{
        catch (QueryException $th) {
            return redirect()->back()->with('curso.existe', '1');
        }

        //}
        //$this->Logger->Log('info', 'Adicionou Um Curso');
        return redirect('Admin/cursos/index/index')->with('status', '1');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {

        $curso = Curso::get();

        return view('admin/cursos/show/index', compact('curso'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $curso = fh_cursos()->where('cursos.slug', $slug)->first();
        if ($curso):

            return view('admin/cursos/edit/index', compact('curso'));
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        endif;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {

        // $updateData 
        try {
            $request=$request->except(['_token','_method']);
            // dd($request);
            Curso::where('cursos.slug', $slug)->update($request);
            $this->loggerData("Actualizou Um Curso " . $request['vc_nomeCurso']);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Curso actualizado com sucesso']);

        } catch (QueryException $th) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);

        }

       
    }


    public function selecionar()
    {
        $response['cursos'] = Curso::where([['it_estado_curso', 1]])->get();
        return view('Admin/cursos_classes/create/index', $response);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Curso  $curso
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {

            $response = Curso::where('slug',$id)->first();
            Curso::where('slug',$id)->delete();
            $this->loggerData("Eliminou Um Curso " . $response->vc_nomeCurso);
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Curso eliminado com Sucesso']);

        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('curso.eliminar.error', '1');
        }
    }


    public function purgar($id)
    {
        try {

            $response = Curso::find($id);
            $response2 = Curso::find($id)->delete();
            $this->loggerData("Purgou o Curso " . $response->vc_nomeCurso);
            return redirect()->back()->with('curso.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('curso.purgar.error', '1');
        }
    }

    public function eliminadas()
    {


        $response['cursos'] = Curso::where([['it_estado_curso', 0]])->get();
        $response['eliminadas'] = "eliminadas";
        return view('admin.cursos.index.index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = Curso::find($id);
            $response->update(['it_estado_curso' => 1]);
            $this->loggerData("Recuperou Um Curso " . $response->vc_nomeCurso);

            return redirect()->back()->with('curso.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('curso.recuperar.error', '1');
        }
    }
}
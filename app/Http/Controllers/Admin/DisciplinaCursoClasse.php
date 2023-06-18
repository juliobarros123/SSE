<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Disciplinas;
use App\Models\Disciplina_Curso_Classe;
use App\Models\Logger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Exception;

class DisciplinaCursoClasse extends Controller
{
    private $Logger;
    private $disciplina_Curso_Classe;
    public function __construct()
    {
        $this->Logger = new Logger();
        $this->disciplina_Curso_Classe = new Disciplina_Curso_Classe();
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $response['disciplinas_cursos_classes'] = fh_disciplinas_cursos_classes()->get();
        return view('admin.disciplina_curso_classe.index', $response);
    }
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $response['cursos'] = fh_cursos()->get();
        $response['disciplinas'] = fh_disciplinas()->get();
        $response['classes'] = fh_classes()->get();



        return view('admin.disciplina_curso_classe.cadastrar.index', $response);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        try {
            $c = $this->tem_registro($request);
            // dd($c);
            if ($c) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro existe']);
            }
            $data = $request->except('_token', '_method');
            $data['id_cabecalho'] = Auth::User()->id_cabecalho;
            Disciplina_Curso_Classe::create($data);
            $this->loggerData('Adicionou um relacionamento de Disciplina, Curso, Classe');
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => ' Disciplinas/cursos/classes cadastrado com sucesso']);


        } catch (Exception $e) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }

    }

    public function tem_registro($array)
    {

        $array_limpo = $array->except('_token', '_method', 'terminal');

        return fh_disciplinas_cursos_classes()->where($array_limpo)->count();


    }
    public function tem_registro_apdate($array)
    {

        $array_limpo = $array->except('_token', '_method');
// dd( $array_limpo);
        return Disciplina_Curso_Classe::where($array_limpo)->count();


    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        //

        $response['disciplina_curso_classe'] = fh_disciplinas_cursos_classes()->where('disciplinas_cursos_classes.slug', $slug)->first();

        $response['cursos'] = fh_cursos()->get();
        $response['disciplinas'] = fh_disciplinas()->get();
        $response['classes'] = fh_classes()->get();
        return view('admin.disciplina_curso_classe.editar.index', $response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        //
        try {
            $c = $this->tem_registro_apdate($request);
            // dd($c );
            if ($c) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Registro existe']);
            }
            $data = $request->except('_token', '_method');
// dd("ola");
           $s= Disciplina_Curso_Classe::where('slug', $slug)->update($data);
        //    dd($s);
            $this->loggerData('Actualizou um relacionamento de Disciplina, Curso, Classe');
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => ' Disciplinas/cursos/classes actualizado com sucesso']);


        } catch (Exception $e) {
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

        try {

            $response = Disciplina_Curso_Classe::find($id);
            $response->update(['it_estado_dcc' => 0]);

            $this->loggerData('Eliminou o relacionamento de Disciplina, Curso, Classe');
            return redirect()->back()->with('disciplina_curso_classe.eliminar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.eliminar.error', '1');
        }
    }

    public function purgar($id)
    {
        try {

            $response = Disciplina_Curso_Classe::find($id);
            $response2 = Disciplina_Curso_Classe::find($id)->delete();
            $this->loggerData("Purgou o relacionamento de Disciplina, Curso, Classe");
            return redirect()->back()->with('disciplina_curso_classe.purgar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.purgar.error', '1');
        }
    }

    public function eliminadas(Disciplina_Curso_Classe $middle)
    {



        $response['respostas'] = $middle->disciplinas_cursos_classes2()->get();

        $response['eliminadas'] = "eliminadas";
        return view('admin.disciplina_curso_classe.index', $response);
    }

    public function recuperar($id)
    {
        try {

            $response = Disciplina_Curso_Classe::find($id);
            $response->update(['it_estado_dcc' => 1]);
            $this->loggerData("Recuperou o relacionamento de Disciplina, Curso, Classe");
            return redirect()->back()->with('disciplina_curso_classe.recuperar.success', '1');
        } catch (\Throwable $th) {
            //throw $th;
            return redirect()->back()->with('disciplina_curso_classe.recuperar.error', '1');
        }
    }
}
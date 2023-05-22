<?php
/* 
Este sistema esta protegido pelos direitos autoriais do Instituto de Telecomunicações criado ao
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
Email II: geral@itel.gov.ao
*/

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Classe;
use App\Models\Curso;
use App\Models\Politica_de_aprovacao as ModelsPolitica_de_aprovacao;
use Illuminate\Http\Request;
use App\Models\Logger;
use Disciplinas;
use Illuminate\Support\Facades\Auth;
class Politica_de_aprovacao extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Logger;
    public function __construct()
    {
        $this->Logger = new Logger();
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    public function index()
    {
        //
        $politicas = ModelsPolitica_de_aprovacao::all();
        return view('admin.politica_de_aprovacao.index', compact('politicas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.politica_de_aprovacao.cadastrar.index');
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

            ModelsPolitica_de_aprovacao::create([
                'it_idCurso'  => $request->it_idCurso,
                'it_idClasse'  => $request->it_idClasse,
                'it_idDisciplina'  => $request->it_idDisciplina,
                'it_maximo_cadeiras' => $request->it_maximo_cadeiras
            ]);
            $this->loggerData("Adicionou Política de Aprovação com os dados de curso: ".Curso::find($request->it_idCurso)->vc_nomeCurso.' Class :'.Classe::find($request->it_idClasse)->vc_classe.' maximo de cadeira'.$request->it_maximo_cadeiras.' Disiplina: ');
            //return redirect('/admin/cadeado_candidatura')->with('status', '1');
        } catch (\Exception $exception) {
            return redirect()->route('admin.politica_de_aprovacao.index')->with('status', '1');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        if ($response['politica'] = ModelsPolitica_de_aprovacao::find($id)) :
            return view('admin.idadedecandidatura.editar.index', $response);
        else :
            return redirect('/admin/politica_de_aprovacao/cadastrar')->with('idade', '1');

        endif;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        //
        ModelsPolitica_de_aprovacao::find($id)->update([
            'it_idCurso'  => $request->it_idCurso,
            'it_idClasse'  => $request->it_idClasse,
            'it_idDisciplina'  => $request->it_idDisciplina,
            'it_maximo_cadeiras' => $request->it_maximo_cadeiras
        ]);
        $this->loggerData('Actualizou Política de Aprovação ');
        return redirect()->route('admin.politica_de_aprovacao.index');
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
        ModelsPolitica_de_aprovacao::find($id)->delete();
        $this->Logger->Log('info','Eliminou Política de Aprovação ');
        return redirect()->route('admin.politica_de_aprovacao.index');
    }
}

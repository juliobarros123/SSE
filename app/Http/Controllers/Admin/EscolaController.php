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
use App\Models\Cabecalho;
use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Image;
class EscolaController extends Controller
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
        $cabecalhos = Cabecalho::leftjoin('municipios','cabecalhos.it_id_municipio','municipios.id')
        ->select('municipios.vc_nome as vc_nomeMunicipio','cabecalhos.*')
        ->get();
        return view('admin.escola.index', compact('cabecalhos'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $dados['municipios'] = Municipio::where([['it_estado_municipio', 1]])->get();
        $dados['provincias'] = Provincia::where([['it_estado_provincia', 1]])->get();
        return view('admin.escola.cadastrar.index',$dados);
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
        Cabecalho::create([

            'vc_logo' => "logo",
            'vc_ensignia' => "logo",
            'vc_escola' => $request->vc_escola,
            'vc_acronimo' => $request->vc_acronimo,
            'vc_nif' => $request->vc_nif,
            'vc_republica' => $request->vc_republica,
            'vc_numero_escola'=>$request->vc_numero_escola,
            'vc_ministerio' => $request->vc_ministerio, 
            'vc_endereco' => $request->vc_endereco,
            'it_telefone' => $request->it_telefone,
            'vc_email' => $request->vc_email,
            'vc_nomeDirector' => $request->vc_nomeDirector,
            'vc_nomeSubdirectorAdminFinanceiro' => $request->vc_nomeSubdirectorAdminFinanceiro,
            'vc_nomeSubdirectorPedagogico' => $request->vc_nomeSubdirectorPedagogico,
            'it_id_municipio' => $request->it_id_municipio,
            'vc_tipo_escola'=>$request->vc_tipo_escola
        ]);
        $this->Logger->Log('info','Adicionou Uma Escola');
        return redirect()->route('admin/escola');
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
        $cabecalho = Cabecalho::leftjoin('municipios','cabecalhos.it_id_municipio','municipios.id')
        ->select('municipios.vc_nome as vc_nomeMunicipio','cabecalhos.*')
        ->find($id);
        return view('admin.escola.visualizar.index', compact('cabecalho'));
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
        $dados['cabecalho'] = Cabecalho::
        leftjoin('municipios','cabecalhos.it_id_municipio','municipios.id')
        ->leftjoin('provincias','municipios.it_id_provincia','provincias.id')
        ->select('provincias.vc_nome as vc_nomeProvincia','municipios.vc_nome as vc_nomeMunicipio','municipios.it_id_provincia','cabecalhos.*')->find($id);

        $dados['municipios'] = Municipio::where([['it_estado_municipio', 1]])->get();

        $dados['provincias'] = Provincia::where([['it_estado_provincia', 1]])->get();

       // dd(  $dados['cabecalho']);
        return view('admin.escola.editar.index', $dados);
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
        if ($request->hasFile('vc_logo')) {

            $image = $request->file('vc_logo');
            $input['imagename'] = Cabecalho::find($id)->vc_nif. '.' . $image->extension();
            $destinationPath = public_path('/images/logotipo');
            $img = Image::make($image->path())->orientate();;
            $img->resize(333, 310, function ($constraint) {
            })->save($destinationPath . '/' . $input['imagename']);

            $dir = "images/logotipo";
            $dados['vc_logo'] = $dir . "/" . $input['imagename'];
        }
       
        Cabecalho::find($id)->update([
            'id' => $request->id,
            'vc_logo' =>  isset($dados['vc_logo'])?$dados['vc_logo']:Cabecalho::find($id)->vc_logo,
            'vc_ensignia' => "logo",
            'vc_escola' => $request->vc_escola,
            'vc_acronimo' => $request->vc_acronimo,
            'vc_nif' => $request->vc_nif,
            'vc_republica' => $request->vc_republica,
            'vc_numero_escola'=>$request->vc_numero_escola,
            'vc_ministerio' => $request->vc_ministerio,
            'vc_endereco' => $request->vc_endereco,
            'it_telefone' => $request->it_telefone,
            'vc_email' => $request->vc_email,
            'vc_nomeDirector' => $request->vc_nomeDirector,
            'vc_nomeSubdirectorAdminFinanceiro' => $request->vc_nomeSubdirectorAdminFinanceiro,
            'vc_nomeSubdirectorPedagogico' => $request->vc_nomeSubdirectorPedagogico,
            'it_id_municipio' => $request->it_id_municipio,
            'vc_tipo_escola'=>$request->vc_tipo_escola
        ]);
        $this->Logger->Log('info','Actualizou Uma Escola');
        return redirect()->route('admin/escola')->with('update',1);
    }

  
}

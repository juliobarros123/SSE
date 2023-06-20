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
use App\Models\Activador_da_candidatura;
use App\Models\AnoLectivo;
use App\Models\AnoLectivoPublicado;
use App\Models\Cabecalho;
use App\Models\Municipio;
use App\Models\Provincia;
use Illuminate\Http\Request;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;
use Image;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Curso;

class EscolaController extends Controller
{

    /**
     * 
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $Logger;
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
        //
        $cabecalhos = Cabecalho::leftjoin('municipios', 'cabecalhos.it_id_municipio', 'municipios.id')
            ->select('municipios.vc_nome as vc_nomeMunicipio', 'cabecalhos.*')
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
        return view('admin.escola.cadastrar.index', $dados);
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
            if ($request->hasFile('vc_logo')) {

                $image = $request->file('vc_logo');
                $input['imagename'] = $request->vc_nif . '.' . $image->extension();
                $destinationPath = public_path('/images/logotipo');
                $img = Image::make($image->path())->orientate();
                ;
                $img->resize(333, 310, function ($constraint) {
                })->save($destinationPath . '/' . $input['imagename']);

                $dir = "images/logotipo";
                $dados['vc_logo'] = $dir . "/" . $input['imagename'];
            } else {
                $dir = "images/logotipo/logo_modelo.jpg";
                $dados['vc_logo'] = $dir;
            }
            if ($request->hasFile('assinatura_director')) {

                $image = $request->file('assinatura_director');
                $input['imagename'] = $request->vc_nif . '.' . $image->extension();
                $destinationPath = public_path('/images/assinatura_director');
                $img = Image::make($image->path())->orientate();
                ;
                // Verificar se a pasta de destino existe
                if (!is_dir($destinationPath)) {
                    // Criar a pasta se ela não existir
                    mkdir($destinationPath, 0777, true);
                }

                $img->resize(333, 310, function ($constraint) {
                })->save($destinationPath . '/' . $input['imagename']);

                $dir = "images/assinatura_director";
                $dados['assinatura_director'] = $dir . "/" . $input['imagename'];
            } else {

                $dir = "images/assinatura_director/modelo.jpg";
      
            }

            $cab = Cabecalho::create([

                'vc_logo' => isset($dados['vc_logo']) ? $dados['vc_logo'] : Cabecalho::find($id)->vc_logo,
                'vc_ensignia' => "logo",
                'vc_escola' => $request->vc_escola,
                'vc_acronimo' => $request->vc_acronimo,
                'vc_nif' => $request->vc_nif,
                'vc_republica' => $request->vc_republica,
                'vc_numero_escola' => $request->vc_numero_escola,
                'vc_ministerio' => $request->vc_ministerio,
                'vc_endereco' => $request->vc_endereco,
                'it_telefone' => $request->it_telefone,
                'vc_email' => $request->vc_email,
                'vc_nomeDirector' => $request->vc_nomeDirector,
                'vc_nomeSubdirectorAdminFinanceiro' => $request->vc_nomeSubdirectorAdminFinanceiro,
                'vc_nomeSubdirectorPedagogico' => $request->vc_nomeSubdirectorPedagogico,
                'it_id_municipio' => $request->it_id_municipio,
                'vc_tipo_escola' => $request->vc_tipo_escola,
                'assinatura_director' => $dados['assinatura_director']
            ]);

            User::create(
                [
                    'vc_nomeUtilizador' => $request->vc_escola,
                    'vc_primemiroNome' => "Administrador",
                    'vc_apelido' => $request->vc_escola,
                    'vc_email' => $request->vc_email,
                    'email_verified_at' => now(),
                    'password' => bcrypt("12345678"),
                    // password
                    'vc_telefone' => "",
                    'vc_tipoUtilizador' => "Administrador",
                    'vc_genero' => "F",
                    'remember_token' => Str::random(10),
                    'id_cabecalho' => $cab->id,
                    'desenvolvedor' => 0
                ]
            );

            Activador_da_candidatura::create([
                'it_estado' => 1,
                'id_cabecalho' => $cab->id
            ]);
            $ano_lectivo = AnoLectivo::create([
                'ya_inicio' => date('Y') - 1,
                'ya_fim' => date('Y'),
                'id_cabecalho' => $cab->id
            ]);

            Curso::create([
                'vc_nomeCurso' => 'Ensino Fundamental',
                'vc_descricaodoCurso' => 'Ensino Fundamental',
                'vc_shortName' => 'Ensino Fundamental',
                'id_cabecalho' => $cab->id
            ]);
            AnoLectivoPublicado::create(
                [
                    'id_anoLectivo' => $ano_lectivo->id,
                    'ya_inicio' => $ano_lectivo->ya_inicio,
                    'ya_fim' => $ano_lectivo->ya_fim,
                    'id_cabecalho' => $cab->id
                ]
            );
            $this->Logger->Log('info', 'Adicionou Uma Escola ' . $request->vc_escola);
            return redirect()->route('admin/escola');
        } catch (\Exception $ex) {
            dd($ex);

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
        $cabecalho = Cabecalho::leftjoin('municipios', 'cabecalhos.it_id_municipio', 'municipios.id')
            ->select('municipios.vc_nome as vc_nomeMunicipio', 'cabecalhos.*')
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
            leftjoin('municipios', 'cabecalhos.it_id_municipio', 'municipios.id')
            ->leftjoin('provincias', 'municipios.it_id_provincia', 'provincias.id')
            ->select('provincias.vc_nome as vc_nomeProvincia', 'municipios.vc_nome as vc_nomeMunicipio', 'municipios.it_id_provincia', 'cabecalhos.*')->find($id);

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
            $input['imagename'] = Cabecalho::find($id)->vc_nif . '.' . $image->extension();
            $destinationPath = public_path('/images/logotipo');
            $img = Image::make($image->path())->orientate();
            ;
            $img->resize(333, 310, function ($constraint) {
            })->save($destinationPath . '/' . $input['imagename']);

            $dir = "images/logotipo";
            $dados['vc_logo'] = $dir . "/" . $input['imagename'];
        }
        $dir = null;
        if ($request->hasFile('assinatura_director')) {

            $image = $request->file('assinatura_director');
            $input['imagename'] = $request->vc_nif . '.' . $image->extension();
            $destinationPath = public_path('/images/assinatura_director');
            $img = Image::make($image->path())->orientate();
            ;
            $destinationPath = 'images/assinatura_director';
            // Verificar se a pasta de destino existe
            if (!is_dir($destinationPath)) {
                // Criar a pasta se ela não existir
                mkdir($destinationPath, 0777, true);
            }

            $img->resize(333, 310, function ($constraint) {
            })->save($destinationPath . '/' . $input['imagename']);

            $dir = "images/assinatura_director";
            $dados['assinatura_director'] = $dir . "/" . $input['imagename'];
        } else {
            $cab = Cabecalho::find($id);
            if ($cab->assinatura_director && $dir) {
                $dados['assinatura_director'] = $dir;
            } else if ($cab->assinatura_director) {
                $dados['assinatura_director'] = $cab->assinatura_director;
            } else {
                $dir = "images/assinatura_director/modelo.jpg";

            }

        }
        Cabecalho::find($id)->update([
            'id' => $request->id,
            'vc_logo' => isset($dados['vc_logo']) ? $dados['vc_logo'] : Cabecalho::find($id)->vc_logo,
            'vc_ensignia' => "logo",
            'vc_escola' => $request->vc_escola,
            'vc_acronimo' => $request->vc_acronimo,
            'vc_nif' => $request->vc_nif,
            'vc_republica' => $request->vc_republica,
            'vc_numero_escola' => $request->vc_numero_escola,
            'vc_ministerio' => $request->vc_ministerio,
            'vc_endereco' => $request->vc_endereco,
            'it_telefone' => $request->it_telefone,
            'vc_email' => $request->vc_email,
            'vc_nomeDirector' => $request->vc_nomeDirector,
            'vc_nomeSubdirectorAdminFinanceiro' => $request->vc_nomeSubdirectorAdminFinanceiro,
            'vc_nomeSubdirectorPedagogico' => $request->vc_nomeSubdirectorPedagogico,
            'it_id_municipio' => $request->it_id_municipio,
            'vc_tipo_escola' => $request->vc_tipo_escola,
            'assinatura_director' => $dados['assinatura_director']
        ]);
        $this->Logger->Log('info', 'Actualizou Uma Escola');
        return redirect()->route('admin/escola')->with('update', 1);
    }


}
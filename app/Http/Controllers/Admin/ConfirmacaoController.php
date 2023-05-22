<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Alunno;
use Illuminate\Http\Request;
use App\Models\AnoLectivo;
use App\Models\Curso;
use App\Models\Logger;
use Image;
use Illuminate\Support\Facades\Auth;

use App\Models\Classe;
use Exception;
use Illuminate\Support\Facades\DB;

class ConfirmacaoController extends Controller

{
    private $Logger;
    public function loggerData($mensagem)
    {
        $dados_Auth = Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido . ' Com o nivel de ' . Auth::user()->vc_tipoUtilizador . ' ';
        $this->Logger->Log('info', $dados_Auth . $mensagem);
    }

    public function __construct()
    {
        $this->provincia = [
            ['nome' => 'Bengo'],
            ['nome' => 'Benguela'],
            ['nome' => 'Bié'],
            ['nome' => 'Cabinda'],
            ['nome' => 'Cunene'],
            ['nome' => 'Huambo'],
            ['nome' => 'Huíla'],
            ['nome' => 'Kuando Kubango'],
            ['nome' => 'Kwanza Norte'],
            ['nome' => 'Kwanza Sul'],
            ['nome' => 'Luanda'],
            ['nome' => 'Lunda Norte'],
            ['nome' => 'Lunda Sul'],
            ['nome' => 'Malange'],
            ['nome' => 'Moxico'],
            ['nome' => 'Namibe'],
            ['nome' => 'Uíge'],
            ['nome' => 'Zaire']
        ];
        $this->Logger = new Logger();
    }

    public function actualizar_municipio()
    {
        try {
            // dd(vr_nif('007844560LA040'));
            ini_set('max_execution_time', 300);
            $classe = Classe::where('vc_classe', 13)->where('it_estado_classe', 1)->first();

            $alunos = Alunno::join('matriculas', 'alunnos.id', 'matriculas.it_idAluno')
                ->where('it_idClasse', $classe->id)
                ->where('vc_municipio', NULL)
                ->orWhere('vc_municipio', 1)->select("alunnos.*")->get();
            // dd(    $alunos );

            foreach ($alunos as $a) {
                if (isset(vr_nif($a->vc_bi)['ObterContribuinte']['contribuinte']['moradaPrincipal']['municipio'])) {
                    $mun = vr_nif($a->vc_bi)['ObterContribuinte']['contribuinte']['moradaPrincipal']['municipio'];
                    if ($mun) {
                        // dd(  Alunno::find($a->id));
                        Alunno::find($a->id)->update([
                            'vc_municipio' =>  $mun
                        ]);
                    }
                }
            }

            // Alunno::get();
            return redirect()->back()->with('aluno_actualizado', '1');
        } catch (Exception $ex) {
            dd($ex->getMessage());
        }
    }
    public function index2()
    {

        $endereco_ws = "https://itel.gov.ao/api/alunos/take";
        // abre a conexão
        $ch = curl_init();
        ini_set('max_execution_time', 300); // 5 minutes
        // define url
        curl_setopt($ch, CURLOPT_URL, $endereco_ws);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 700000);
        curl_setopt($ch, CURLOPT_TIMEOUT, 700000); //timeout in seconds
        // executa o post
        $resultado = curl_exec($ch);

        if (curl_error($ch)) {
            echo 'Erro:' . curl_error($ch);
            return false;
        }

        // dd($this->generateRandomString());
        // fecha a conexão
        curl_close($ch);

        $anoLectivo = AnoLectivo::where('it_estado_anoLectivo', [1])->first();
        if ($anoLectivo == null) {
            return redirect()->back()->with('anoLectivo', '1');
        }

        $data = (array) json_decode($resultado);

        // dd($data);
        foreach ($data as $a) {

            $data = Alunno::where("id", $a->it_processo)->first();
            if ($data === null) {
                //dd('aqui');
                if ($a->dt_emissao == "0000-00-00" || $a->dt_dataNascimento == "0000-00-00") {
                    $tokenKey = $this->generateRandomString();

                    $aluno = Alunno::create([
                        'vc_primeiroNome' => $a->vc_primeiroNome,
                        'vc_nomedoMeio' => $a->vc_nomedoMeio,
                        'vc_ultimoaNome' => $a->vc_ultimoaNome,
                        'it_classe' => $a->it_classe,
                        'foto' => $a->foto,
                        'id' => $a->it_processo,
                        'dt_emissao' => "1111-11-11",

                        'dt_dataNascimento' => "1111-11-11",


                        'vc_naturalidade' => $a->vc_naturalidade,
                        'vc_provincia' => $a->vc_provincia,
                        'vc_namePai' => $a->vc_namePai,
                        'vc_nameMae' => $a->vc_nameMae,
                        'vc_dificiencia' => $a->vc_dificiencia,
                        'vc_estadoCivil' => $a->vc_estadoCivil,
                        'vc_genero' => $a->vc_genero,
                        'it_telefone' => $a->it_telefone,
                        'vc_email' => $a->vc_email,

                        'vc_residencia' => $a->vc_residencia,
                        'vc_bi' => $a->vc_bi,



                        'vc_EscolaAnterior' => $a->vc_EscolaAnterior,
                        'ya_anoConclusao' => $a->ya_anoConclusao,
                        'vc_nomeCurso' => $a->vc_nomeCurso,
                        'vc_anoLectivo' => $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim,
                        'dt_anoCandidatura' => $a->dt_anoCandidatura,
                        'it_classe' => $a->it_classe,
                        'it_classeConclusao' => $a->it_classeConclusao,
                        'vc_localEmissao' => $a->vc_localEmissao,
                        'tokenKey' => $tokenKey,
                        'it_estado_aluno' => '1'

                    ]);
                    if ($a->foto != null) {
                        $this->donwloadImage($a->foto);
                    }
                } else {
                    $tokenKey = $this->generateRandomString();
                    // if(if){

                    // }
                    // dd('ali');
                    $aluno = Alunno::create([
                        'vc_primeiroNome' => $a->vc_primeiroNome,
                        'vc_nomedoMeio' => $a->vc_nomedoMeio,
                        'vc_ultimoaNome' => $a->vc_ultimoaNome,
                        'it_classe' => $a->it_classe,
                        'id' => $a->it_processo,

                        'foto' => $a->foto,

                        'dt_emissao' => $a->dt_emissao,

                        'dt_dataNascimento' => $a->dt_dataNascimento,


                        'vc_naturalidade' => $a->vc_naturalidade,
                        'vc_provincia' => $a->vc_provincia,
                        'vc_namePai' => $a->vc_namePai,
                        'vc_nameMae' => $a->vc_nameMae,
                        'vc_dificiencia' => $a->vc_dificiencia,
                        'vc_estadoCivil' => $a->vc_estadoCivil,
                        'vc_genero' => $a->vc_genero,
                        'it_telefone' => $a->it_telefone,
                        'vc_email' => $a->vc_email,
                        'id' => $a->it_processo,

                        'vc_residencia' => $a->vc_residencia,
                        'vc_bi' => $a->vc_bi,
                        'vc_EscolaAnterior' => $a->vc_EscolaAnterior,
                        'ya_anoConclusao' => $a->ya_anoConclusao,
                        'vc_nomeCurso' => $a->vc_nomeCurso,
                        'vc_anoLectivo' => $anoLectivo->ya_inicio . "-" . $anoLectivo->ya_fim,
                        'dt_anoCandidatura' => $a->dt_anoCandidatura,
                        'it_classe' => $a->it_classe,
                        'it_classeConclusao' => $a->it_classeConclusao,
                        'vc_localEmissao' => $a->vc_localEmissao,
                        'tokenKey' => $tokenKey,
                        'it_estado_aluno' => '1'

                    ]);
                    if ($a->foto != null) {
                        $this->donwloadImage($a->foto);
                    }
                }
            } else {
                continue;
            }
        }

        return redirect()->back();
    }

    public function donwloadImage(String $image)
    {

        /* Cria um novo arquivo e caso o arquivo exista, substitui */
        $file = fopen("confirmados/{$image}", "w+");
        ini_set('max_execution_time', 300); // 5 minutes
        /* Cria uma nova instância do cURL */
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 700000);
        curl_setopt($curl, CURLOPT_TIMEOUT, 700000); //timeout in seconds
        curl_setopt_array($curl, [
            /* Define a URL */
            CURLOPT_URL            => "https://itel.gov.ao/uploads/confirmacao/" . $image,

            /* Informa que você quer receber o retorno */
            CURLOPT_RETURNTRANSFER => true,

            /* Define o "resource" do arquivo (Onde o arquivo deve ser salvo) */
            CURLOPT_FILE           => $file,

            /* Desabilita a verificação do SSL */
            CURLOPT_SSL_VERIFYPEER => false
        ]);

        /* Envia a requisição e fecha as conexões em seguida */
        curl_exec($curl);
        curl_close($curl);
        fclose($file);
    }


    public function confirmar()
    {
        $data['cursos'] = Curso::all();
        $data['ano_lectivo'] =  AnoLectivo::where("it_estado_anoLectivo", ['1'])->first();
        $data['classes'] =  Classe::all();
        $data['provincias'] = $this->provincia;
        //dd($data);

        return view('site.admitido', $data);
    }

    public function confirmarStore(Request $request)
    {
        $tokenKey = $this->generateRandomString();
        try {
            $upload = "sem foto";

            if ($request->hasFile('foto')) {

                $image = $request->file('foto');
                $input['imagename'] =  $request->it_processo . '.' . $image->extension();
                $destinationPath = public_path('/confirmados');
                $img = Image::make($image->path());
                $img->resize(333, 310, function ($constraint) {
                })->save($destinationPath . '/' . $input['imagename']);

                $dir = "confirmados";
                $dados['foto'] = $input['imagename'];
            }
        //dd( $request->dt_anoCandidatura);

            $aluno = Alunno::create([
                'vc_primeiroNome' => $request->vc_primeiroNome,
                'vc_nomedoMeio' => $request->vc_nomedoMeio,
                'vc_ultimoaNome' => $request->vc_ultimoaNome,
                'it_classe' => $request->it_classe,

                'dt_emissao' => $request->dt_emissao,

                'dt_dataNascimento' => $request->dt_dataNascimento,


                'vc_naturalidade' => $request->vc_naturalidade,
                'vc_provincia' => $request->vc_provincia,
                'vc_namePai' => $request->vc_namePai,
                'vc_nameMae' => $request->vc_nameMae,
                'vc_dificiencia' => $request->vc_dificiencia,
                'vc_estadoCivil' => "Solteiro(a)",
                'vc_genero' => $request->vc_genero,
                'it_telefone' => $request->it_telefone,
                'vc_email' => $request->vc_email,
                'foto' =>   isset($dados['foto']) ? $dados['foto'] : 'sem',
                'vc_residencia' => $request->vc_residencia,
                'vc_bi' => $request->vc_bi,
                'id' => $request->it_processo,
                'ya_anoConclusao' => $request->ya_anoConclusao,
                'vc_nomeCurso' => $request->vc_nomeCurso,
                'vc_anoLectivo' => $request->dt_anoCandidatura,
                /* 'dt_anoCandidatura' => $request->dt_anoCandidatura, */
                'it_classe' => $request->it_classe,
                'it_classeConclusao' => $request->it_classeConclusao,
                'vc_localEmissao' => $request->vc_localEmissao,
                'tokenKey' => $tokenKey,
                'vc_tipo_aluno' => $request->vc_tipo_aluno,
                'it_estado_aluno' => '1'

            ]);

            if ($aluno) {
                $this->loggerData("Adicionou aluno com o estado <<$request->vc_tipo_aluno>>");
                // return redirect()->back();
                return redirect()->back()->with("aluno", '1');
            } else {
                return redirect()->back()->with('aviso', 1);
            }
            //     }
            // } else {
            // dd("erro");
            // return redirect()->back()->with('error', 1);
            // }
        } catch (\Exception $exception) {


            return redirect()->back()->with('aviso', 1);
        }
    }


    public function actualizar()
    {

        try {
            $anolectivo = AnoLectivo::orderBy('ya_fim', 'desc')->first();
            $alunos = DB::table('alunnos')->join('matriculas', 'matriculas.it_idAluno', '=', 'alunnos.id')
                ->join('classes', 'classes.id', 'matriculas.it_idClasse')
                ->where('classes.vc_classe', 13)->where('alunnos.vc_tipo_aluno', null)->select('alunnos.id', 'matriculas.vc_anoLectivo')->get();
            
      
          
            foreach ($alunos as $aluno) {
              
                $anos = explode( '-',$aluno->vc_anoLectivo);
             
                if ($anolectivo->ya_fim - $anos[1] >= 1) {
                    // dd($aluno);
                    Alunno::find($aluno->id)->update([
                        'vc_tipo_aluno' => 'Diplomado'
                    ]);
                }
            }
            $this->Logger->Log('info', 'Actualizou diplomados');
            return redirect()->back()->with('dip_actualizado', 1);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error_dip_actualizado', 1);
        }
    }

    function generateRandomString($size = 9)
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuwxyz0123456789";
        $randomString = '';
        for ($i = 0; $i < $size; $i = $i + 1) {
            $randomString .= $chars[mt_rand(0, 60)];
        }
        return $randomString;
    }
}

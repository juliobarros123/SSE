<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Patrimonios;
use App\Models\Logger;
use Illuminate\Support\Facades\Auth;

class PatrimoniosController extends Controller
{
  private $Logger;
  public function __construct()
  {
    $this->Logger = new Logger();
  }
  public function show()
  {
    $patrimonios = Patrimonios::where([['it_estado_patrimonio', 1]])->get();
    return view('admin.patrimonios.visualizar.index', compact('patrimonios'));
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
    return view('admin.patrimonios.cadastrar.index');
  }

  public function store(Request $request)
  {
    try {
      $dados = $request->all();
      $request->validate([
        'vc_nome' => 'required',
        'vc_estado' => 'required',
        'vc_descricao' => 'required',
        'it_quantidade' => 'required',
        'it_valor' => 'required',
        'it_numfactura' => 'required',
        'it_vidaUtil' => 'required',
        'vc_utilidade' => 'required',
        'vc_marca' => 'required',
        'vc_modelo' => 'required',
        'vc_localizacao'  => 'required'
      ]);

      if ($request->hasFile('vc_foto')) {
        $imagem = $request->file('vc_foto');
        $num = rand(1111, 9999);
        $dir = "images/patrimonios";
        $extensao = $imagem->guessClientExtension();
        $nomeImagem = 'vc_foto' . "_" . $num . "." . $extensao;
        $imagem->move($dir, $nomeImagem);
        $dados["vc_foto"] = $dir . "/" . $nomeImagem;
      }

      Patrimonios::create($dados);
      $this->loggerData('info', 'Adicionou Património '.$request->vc_nome.' de marca '.$request->vc_marca.' de modelo '.$request->vc_modelo);
      return redirect()->back()->with('status', '1');
    } catch (\Exception $exceptio) {
      return redirect()->back()->with('aviso', '1');
    }
  }
  public function edit($id)
  {
    if ($patrimonios = Patrimonios::where([['it_estado_patrimonio', 1]])->find($id)) :

      return view('admin.patrimonios.editar.index', compact('patrimonios'));
    else :
      return redirect('/admin/patrimonios/cadastrar')->with('patrimonio', '1');

    endif;
  }
  public function update(Request $request, $id)
  {
    //
    $dados = $request->all();
    $request->validate([
      'vc_nome' => 'required',
      'vc_estado' => 'required',
      'vc_descricao' => 'required',
      'it_quantidade' => 'required',
      'it_valor' => 'required',
      'it_numfactura' => 'required',
      'it_vidaUtil' => 'required',
      'vc_utilidade' => 'required',
      'vc_marca' => 'required',
      'vc_modelo' => 'required',
      'vc_localizacao'  => 'required'
    ]);

    if ($request->hasFile('vc_foto')) {
      $imagem = $request->file('vc_foto');
      $num = rand(1111, 9999);
      $dir = "images/patrimonios";
      $extensao = $imagem->getClientOriginalExtension();
      $nomeImagem = 'vc_foto' . "_" . $num . "." . $extensao;
      $imagem->move($dir, $nomeImagem);
      $dados["vc_foto"] = $dir . "/" . $nomeImagem;
      $cff =  Patrimonios::find($id);
      unlink($cff->vc_foto);
    }
    $cf = Patrimonios::find($id);
    $cf->update($dados);
    $this->loggerData('info', 'Eliminou Património '.$request->vc_nome.' de marca '.$request->vc_marca.' de modelo '.$request->vc_modelo);
    return redirect()->route('admin/patrimonios/visualizar');
  }
  public function destroy($id)
  {
    //
    //$response = Patrimonios::find($id);
    //$response->delete();
    //unlink($response->vc_foto);
    $response = Patrimonios::find($id);
    $response->update(['it_estado_patrimonio' => 0]);

    $this->loggerData('info', 'Eliminou Património '.$response->vc_nome.' de marca '.$response->vc_marca.' de modelo '.$response->vc_modelo);
    return redirect()->route('admin/patrimonios/visualizar');
  }
}

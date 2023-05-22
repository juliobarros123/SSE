<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ManutencaoDoServico;
use App\Models\Mes;
use App\Models\Servicos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Admin\TotalEntradaGastosRemanescenteController;
use Illuminate\Support\Facades\Auth;

class ManutecaoDeServicoController extends Controller
{
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }
    protected $manutecao,$balanco;
    public function __construct(ManutencaoDoServico $manutencao, TotalEntradaGastosRemanescenteController $balanco)
    {
        $this->manutencao=$manutencao;
        $this->balanco = $balanco;
       
    }

    public function paginaListar()
    {
        $dados = ManutencaoDoServico::All();
        $manutencoes=$this->manutencao->paginaManutecaoServicoMes();
        //dd($manutencoes);
        return view('admin.manutecaodeservicos.index', compact('manutencoes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function paginaCadastrar()
    {
        $meses = DB::table('mes')->get();
        $servicos = Servicos::all();
            return view('admin.manutecaodeservicos.cadastrar.index', compact('meses','servicos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cadastrar(Request $request)
    {

        //try {
            $dados = $request->all();
            Validator::make($dados, [ //vc_nomeFormador,vc_bI,vc_genero,vc_funcao
                'it_id_servicos' => ['required', 'string', 'max:255'],
                'it_id_mes' => ['required', 'string', 'max:255'],
                'dc_custo' => ['required', 'string', 'max:255'],
                'vc_descricao' => ['required', 'string', 'max:255'],
                'ya_ano'=> ['required', 'string', 'max:255'],
            ])->validate();

            //dd($dados);

            $manutecaodeservico = ManutencaoDoServico::create($dados);

            return redirect()->back()->with('status', '1');
        /* } catch (\Throwable $th) {
            return redirect()->back()->with('aviso', '1');
        } */
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paginaVer($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function paginaEditar($id)
    {
        $meses = DB::table('mes')->get();
        $servicos = Servicos::all();
           

        $manutencao = $this->manutencao->manutecaoServicoMes($id);
        $manutencao=$manutencao[0];
        return  view('admin.manutecaodeservicos.editar.index', compact('servicos','meses','manutencao'));       
        
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
         
        ManutencaoDoServico::find($id)->update([
            'it_id_servicos'=>$request->input('it_id_servicos'),
            'it_id_mes'=>$request->input('it_id_mes'),
            'dc_custo'=>$request->input('dc_custo'),
            'vc_descricao'=>$request->input('vc_descricao'),
            'ya_ano'=>$request->input('ya_ano')
        ]);
        //$this->balanco->editar($request->input('it_id_mes'),$request->input('ya_ano'));
        return redirect()->route('listarManutecaoServico')->with('status', '1');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function eliminar($id)
    {
        $manutencao=ManutencaoDoServico::find($id);
        $it_id_mes=$manutencao->it_id_mes;
        $ya_ano=$manutencao->ya_ano;

        ManutencaoDoServico::find($id)->delete();
        //$this->balanco->editar($it_id_mes,$ya_ano);
        return redirect()->back();
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TotalEntradaGastosRemanescente;
use App\Models\Mes;
use App\Models\FolhaSalarioFuncionario;
use App\Models\FolhaSalarioFormador;
use App\Models\Formacao;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TotalEntradaGastosRemanescenteController extends Controller
{
    protected $totalEntradaGastosRemanescente;
    protected $mes;
    public function __construct(TotalEntradaGastosRemanescente $totalEntradaGastosRemanescente, Mes $mes){
        $this->totalEntradaGastosRemanescente=$totalEntradaGastosRemanescente;
        $this->mes=$mes;
    }

    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function tt(){
        $valor_arrecadado=DB::table('formacaos')->where("it_id_mes",1)->sum('dc_valor_arrecadado');
        $salario_funcionario=DB::table('folha_salario_funcionarios')->where("it_id_mes",1)->sum('dc_salarioLiquido');
        $salario_formadores=DB::table('folha_de_salario_formadores')->sum('dc_salario_comissao');
        $total_manutencao=DB::table('manutecao_do_servicos')->where("it_id_mes",1)->sum('dc_custo');
        $totalTudo['valor_arrecadado']=$valor_arrecadado;
        $totalTudo['salario_funcionario']=$salario_funcionario;
        $totalTudo['salario_formadores']=$salario_formadores;
        $totalTudo['total_manutencao']=$total_manutencao;
        dd($totalTudo);
    }
    public function calacularEntradaMes($it_id_mes){
        $total=DB::table('creditos')->where("it_id_mes",$it_id_mes)->sum('dc_valor');
    }

    public function calacularSalarioFuncionariosMes($it_id_mes){
        $total=DB::table('folha_salario_funcionario_mensals')->where("it_id_mes",$it_id_mes)->sum('dc_salarioLiquido');
        
    }
   /* public function calacularSalarioFormadoresMes($it_id_mes){
        $total=DB::table('folha_salario_formadores')->where("it_id_mes",$it_id_mes)->sum('dc_salarioLiquido');
    }*/
    public function calacularServicosMes($it_id_mes){
        $total=DB::table('manutencao_do_servicos')->where("it_id_mes",$it_id_mes)->sum('dc_custo');
    }
    public function calacularSalarioTotalMes(){}
    /*public function calacularRemanescenteMes($it_id_mes){

    }*/

    public function paginaCadastrar(){
        $balancos=Mes::all();
        //dd( $mes);
        return view('admin.total_entrada_gastos_remanescentes.cadastrar.index', compact('balancos'));
    }

    public function paginaEditar($id){
        $c = TotalEntradaGastosRemanescente::find($id);
        if($response['TotalEntradaGastosRemanescente'] = TotalEntradaGastosRemanescente::find($id)):
        $totalEntradaGastosRemanescente =TotalEntradaGastosRemanescente::find($id);
        return view('admin.total_entrada_gastos_remanescentes.editar.index', compact('TotalEntradaGastosRemanescente'));
    else:
        return redirect('admin/total_entrada_gastos_remanescentes/cadastrar')->with('teste', '1');

       endif;
       
    }

    public function paginaListar(){

        $balancos=$this->totalEntradaGastosRemanescente->listar();
        return view('admin.total_entrada_gastos_remanescentes.index', compact('balancos'));
    }

    public function cadastrar(Request $request){

        $dc_total_entrada=DB::table('creditos')->where([["it_id_mes",$request->input('it_id_mes')],["ya_ano",$request->input('ya_ano')]])->sum('dc_valor');

        $dc_totalSalarioFuncionario=-DB::table('folha_salario_funcionario_mensals')->where([["it_id_mes",$request->input('it_id_mes')],["ya_ano",$request->input('ya_ano')]])->sum('dc_salarioLiquido');

     //   $dc_totalSalarioFormador=-DB::table('folha_de_salario_formadores')->where([["it_id_mes",$request->input('it_id_mes')],["ya_ano",$request->input('ya_ano')]])->sum('dc_salario_comissao');
       
        $dc_totalGastoManuntencao=-DB::table('manutencao_do_servicos')->where([["it_id_mes",$request->input('it_id_mes')],["ya_ano",$request->input('ya_ano')]])->sum('dc_custo');
        
       // $dc_totalSalarios=$dc_totalSalarioFuncionario+$dc_totalSalarioFormador;

        $dc_totalGastos=$dc_totalSalarioFuncionario+$dc_totalGastoManuntencao;
       
        $dc_remanescente=$dc_total_entrada+$dc_totalGastos;

        $totalTudo['dc_total_entrada']=$dc_total_entrada;
        $totalTudo['dc_totalSalarioFuncionario']=$dc_totalSalarioFuncionario;
        //$totalTudo['dc_totalSalarioFormador']=$dc_totalSalarioFormador;
        $totalTudo['dc_totalGastoManuntencao']=$dc_totalGastoManuntencao;
        //$totalTudo['dc_totalSalarios']=$dc_totalSalarios;
        $totalTudo['dc_totalGastos']=$dc_totalGastos;
        $totalTudo['dc_remanescente']=$dc_remanescente;
        //dd($totalTudo);
        //dd($totalTudo['dc_total_entrada']);

        try{
        $Total = TotalEntradaGastosRemanescente::create([
            'ya_ano'=>$request->input('ya_ano'),
            'it_id_mes'=>$request->input('it_id_mes'),
            'dc_total_entrada'=>$dc_total_entrada,
            'dc_totalSalarioFuncionario'=>$dc_totalSalarioFuncionario,
            //'dc_totalSalarioFormador'=>$dc_totalSalarioFormador,
            'dc_totalGastoManuntencao'=>$dc_totalGastoManuntencao,
            'dc_totalSalarios'=>$dc_totalSalarioFuncionario,
            'dc_totalGastos'=>$dc_totalGastos,
            'dc_remanescente'=>$dc_remanescente,
        ]);
        return redirect()->back()->with('status','1');

    }catch(Exception $exception)
    {
        return redirect()->back()->with('aviso','1');
    }

    }

    public function editar(Request $req, $id)
    {
        $dados[]=$req;
        
        TotalEntradaGastosRemanescente::find($id)->update([
            'vc_nomeTotalEntradaGastosRemanescente'=>$req->input('vc_nomeTotalEntradaGastosRemanescente'),
            'vc_bI'=>$req->input('vc_bI'),
            'vc_genero'=>$req->input('vc_genero'),
            'vc_funcao'=>$req->input('vc_funcao')
        ]);
        return redirect()->route('listarTotalEntradaGastosRemanescente')->with('status', '1');
        
        

    }

    public function eliminar($id){
        TotalEntradaGastosRemanescente::find($id)->delete();
        return redirect()->back();
    }

    public function estadoActual(){
        $dc_total_valor_arrecadado=DB::table('total_entrada_gastos_remanescentes')->sum('dc_total_entrada');
        $dc_total_gastos=DB::table('total_entrada_gastos_remanescentes')->sum('dc_totalGastos');
      //  $dc_ultimo_valor_arrecadado;
      //  $dc_ultima_saida_manuntencao;
      //  $dc_ultimo_total_gasto;
        $dc_remanescente=DB::table('total_entrada_gastos_remanescentes')->sum('dc_remanescente');

    }
}

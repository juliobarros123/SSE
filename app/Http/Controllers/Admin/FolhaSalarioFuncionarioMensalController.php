<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FolhaSalarioFuncionarioMensal;
use App\Models\Cabecalho;
use App\Models\FolhaSalarioFuncionario;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Mes;
use Illuminate\Support\Facades\Auth;

class FolhaSalarioFuncionarioMensalController extends Controller
{
    protected $folhaSalarioFuncionarioMensal;
    public function __construct(FolhaSalarioFuncionarioMensal $folhaSalarioFuncionarioMensal){
        $this->folhaSalarioFuncionarioMensal=$folhaSalarioFuncionarioMensal;
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function paginaEditar($id){
        $c = FolhaSalarioFuncionarioMensal::find($id);
        if($response['FolhaSalarioFuncionarioMensal'] = FolhaSalarioFuncionarioMensal::find($id)):
        $funcionario=$this->FolhaSalarioFuncionarioMensal->pegarFuncionarioSalario($id);
        $funcionario=$funcionario[0];
        return view('admin.folha_salario_funcionario_mensal.editar.index', compact('funcionario'));
    else:
        return redirect('admin/folha_salario_funcionario_mensal/cadastrar')->with('teste', '1');

       endif;

    }
    public function paginaVer(){
       //dd("aaaa");
        $meses=Mes::all();
        return view('admin.folha_salario_funcionario_mensal.ver.index', compact('meses'));
    }

    public function paginaListar(Request $req){
        //$it_id_mes,$ya_ano
        $folhaSalarioFuncionarios=$this->folhaSalarioFuncionarioMensal->pegarFuncionarioSalarioMensal($req['it_id_mes'],$req['ya_ano']);
        $mes=Mes::find($req['it_id_mes']);
        //$mes=$mes->vc_nome;
        $ano=$req['ya_ano'];
        $data['mes']=$mes->vc_nome;
        $data['m1']=$mes->id;
        $data['ano']=$ano;
        return view('admin.folha_salario_funcionario_mensal.index', compact('folhaSalarioFuncionarios','data'));
    }

    public function criarFolhaMensal(Request $req){
        $folhaSalarios=FolhaSalarioFuncionario::all();
        $it_id_mes=$req->input('it_id_mes');
        $ya_ano=$req->input('ya_ano');
       // dd($req);
       try{
        foreach( $folhaSalarios as $folhaSalario){
            $this->cadastrar($folhaSalario->it_id_funcionario,$it_id_mes,$ya_ano,$folhaSalario->dc_salarioLiquido);
        }

        return redirect()->back()->with('status','1');
    } catch(Exception $exception)
    {
        return redirect()->back()->with('aviso','1');
    }
    }

    public function cadastrar($it_id_funcionario,$it_id_mes,$ya_ano,$dc_salarioLiquido){
        try{

        $FolhaSalarioFuncionarioMensal = FolhaSalarioFuncionarioMensal::create([
            'it_id_funcionario'=>$it_id_funcionario,
            'it_id_mes'=>$it_id_mes,
            'dc_salarioLiquido'=>$dc_salarioLiquido,
            'ya_ano'=>$ya_ano,
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

        FolhaSalarioFuncionarioMensal::find($id)->update([
            'dc_salarioLiquido'=>$req->input('dc_salarioLiquido'),
        ]);
        return redirect()->route('listarFolhaSalarioFuncionarioMensal')->with('status', '1');

    }

    public function eliminar($id){
        FolhaSalarioFuncionarioMensal::find($id)->delete();
        return redirect()->back();
    }


    public function ImprimirFolha($it_id_mes,$ano){

    $response["bootstrap"] = file_get_contents(__full_path()."css/relatorio/bootstrap.min.css");
    $response["style"] = file_get_contents(__full_path()."css/relatorio/style.css");
    $response["pegaCabecalho"] =$pegaCabecalho=Cabecalho::find(1);
    $response["folhaSalarioFuncionarios"] =$folhaSalarioFuncionarios=$this->folhaSalarioFuncionarioMensal->pegarFuncionarioSalarioMensal($it_id_mes,$ano);


    $pdf= new \Mpdf\Mpdf();
    $imprimirFolhaSalarioMensal = view("admin.folha_salario_funcionario_mensal.pdf.index",$response/*compact('folhaSalarioFuncionarios','pegaCabecalho')/*,$dadosDinamicos,$dataAluno*/);
    $pdf->writeHTML($imprimirFolhaSalarioMensal);
    $pdf->Output();


    }
}

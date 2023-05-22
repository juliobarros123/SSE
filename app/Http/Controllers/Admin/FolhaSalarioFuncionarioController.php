<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FolhaSalarioFuncionario;
use App\Models\Mes;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FolhaSalarioFuncionarioController extends Controller
{
    protected $FolhaSalarioFuncionario;
    public function __construct(FolhaSalarioFuncionario $folhaSalarioFuncionario){
        $this->folhaSalarioFuncionario=$folhaSalarioFuncionario;
    }
    public function loggerData($mensagem){
        $dados_Auth = Auth::user()->vc_primemiroNome.' '.Auth::user()->vc_apelido.' Com o nivel de '.Auth::user()->vc_tipoUtilizador.' ';
        $this->Logger->Log('info', $dados_Auth.$mensagem);
    }

    public function paginaEditar($id){
        
        //$c = FolhaSalarioFuncionario::where('it_id_funcionario',$id)->get();
        //dd($c);
        if($folha = FolhaSalarioFuncionario::where('it_id_funcionario',$id)->get()){
            //dd($folha[0]->id);
            $funcionario=$this->folhaSalarioFuncionario->pegarFuncionarioSalario($folha[0]->id);
        $funcionario=$funcionario[0];
        return view('admin.folha_salario_funcionarios.editar.index', compact('funcionario'));
        }
        
    else
        return redirect('admin/folha_salario_funcionarios/cadastrar')->with('teste', '1');

       
       
    }

    public function paginaListar(/*$id_mes*/){ 
        $meses=Mes::all();
        $folhaSalarioFuncionarios=$this->folhaSalarioFuncionario->pegarFuncionariosSalario();
        return view('admin.folha_salario_funcionarios.index', compact('folhaSalarioFuncionarios','meses'));
    }

    public function cadastrar($id_funcionario){
        try{
       
        $folhaSalarioFuncionario = FolhaSalarioFuncionario::create([
            'it_id_funcionario'=>$id_funcionario,
            'dc_salarioLiquido'=>0,
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

        $folha = FolhaSalarioFuncionario::where('it_id_funcionario',$id)->get();
        
        FolhaSalarioFuncionario::find($folha[0]->id)->update([
            'dc_salarioLiquido'=>$req->input('dc_salarioLiquido'),
        ]);
        return redirect()->route('listarFolhaSalarioFuncionario')->with('status', '1');
        
        

    }

    public function eliminar($id){
        FolhaSalarioFuncionario::find($id)->delete();
        return redirect()->back();
    }
}

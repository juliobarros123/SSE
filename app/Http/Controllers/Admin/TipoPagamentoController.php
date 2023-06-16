<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TipoPagamento;
use Illuminate\Http\Request;

class TipoPagamentoController extends Controller
{
    //

    public function criar()
    {
        $response['classes'] = fh_classes()->get();
        return view('admin.tipos-pagamento.cadastrar.index', $response);

    }
    public function cadastrar(Request $request)
    {
        // dd($request);

        try {
            $data = $request->all();
            // dd(auth()->id_cabecalho);
            if ($this->tem_registro_2($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Tipo de pagamento já existe']);

            }

            TipoPagamento::create($request->all());
            return redirect()->route('tipos-pagamento')->with('feedback', ['type' => 'success', 'sms' => 'Tipo de pagamento cadastrado com sucesso']);

        } catch (Exception $e) {

            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }


    public function actualizar(Request $request, $slug)
    {
        // dd($request,$slug);

        try {
            $data = $request->all();

            if ($this->tem_registro($request)) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Tipo de pagamento já existe']);

            }
            //



            $tipo = fh_tipos_pagamento()->where('id_classe', $request->id_classe)
                ->where('tipo', $request->tipo)->first();
                if(  $tipo){
            if ($tipo->slug != $slug) {
                return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Tipo de pagamento já existe']);

            }
        }
            TipoPagamento::where('slug', $slug)->update(
                $request->except(['_token', '_method'])
            );
            return redirect()->back()->with('feedback', ['type' => 'success', 'sms' => 'Tipo de pagamento actualizado com sucesso']);




        } catch (Exception $e) {
            // dd($e);
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado, verifica os dados se estão corretos']);


        }
    }
    //
    public function editar($slug)
    {
        $tipo_pagamento = fh_tipos_pagamento()->where('tipo_pagamentos.slug', $slug)->first();
        if ($tipo_pagamento):
            // dd($tipo_pagamento);
            $data['tipo_pagamento'] = $tipo_pagamento;
            $data['classes'] = fh_classes()->get();

            return view('admin.tipos-pagamento.editar.index', $data);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;
    }

    public function tem_registro($array)
    {
        $cont = $this->tem_registro_2($array);

        if ($cont) {
            return 1;
        }
        $array_limpo = $array->except(['_token', '_method']);
        // dd( $array_limpo);
        return fh_tipos_pagamento()->where($array_limpo)->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }

    }
    public function tem_registro_2($array)
    {

        // dd( $array);
        return fh_tipos_pagamento()->where('id_classe', $array->id_classe)
            ->where('tipo', $array->tipo)->count();
        // if($estado){
        //     throw new Exception('Registro já existe!');
        //    }

    }
    public function turma_tem_director($id_turma)
    {

        return DireitorTurma::where('id_turma', $id_turma)->count();


    }
    public function cadastro_existe($dados)
    {
        return DB::table('coordenador_cursos')
            ->join('users', 'users.id', 'coordenador_cursos.id_user')
            ->join('cursos', 'cursos.id', 'coordenador_cursos.id_curso')
            ->where('coordenador_cursos.id_user', $dados->id_user)
            ->where('coordenador_cursos.id_curso', $dados->id_curso)
            ->count();
    }



    public function eliminar($slug)
    {


        $tipo_pagamento = TipoPagamento::where('tipo_pagamentos.slug', $slug)->first();
        if ($tipo_pagamento):
            TipoPagamento::where('tipo_pagamentos.slug', $slug)->delete();
            // $this->loggerData('Eliminou  director de turma com id  ', $director_turma->id);
            return redirect()->back()->with('feedback', ['status' => '1', 'sms' => 'Tipo de pagamento eliminado com sucesso']);
        else:
            return redirect()->back()->with('feedback', ['type' => 'error', 'sms' => 'Ocorreu um erro inesperado']);


        endif;


    }

    public function index()
    {
        $data['tipos_pagamentos'] = fh_tipos_pagamento()->get();


        //  dd($data);
        return view('admin.tipos-pagamento.index', $data);
    }
}
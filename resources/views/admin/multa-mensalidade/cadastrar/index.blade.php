@extends('layouts.admin')

@section('titulo', 'Cadastrar Multa-Mensalidade')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Multa-Mensalidade</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form form action="{{ route('multas-mensalidades.cadastrar') }}" method="post" class="row">
                @csrf

                @include('forms._formMulta-Mensalidade.index')

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>
  
    @include('admin.layouts.footer')

@endsection

@extends('layouts.admin')

@section('titulo', 'Cadastrar Fundo de Cartão')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Fundo de Cartão</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form enctype="multipart/form-data" action="{{ route('admin.fundos_cartoes.cadastrar') }}" method="post"
                class="row">
                @csrf

                @include('forms._form-fundo-cartao.index')

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Cadastrar">
                </div>
            </form>
        </div>
    </div>

    @include('admin.layouts.footer')

@endsection

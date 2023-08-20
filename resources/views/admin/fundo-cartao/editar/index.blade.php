@extends('layouts.admin')

@section('titulo', 'Editar Fundo de Cartão')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Fundo de Cartão</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.fundos_cartoes.actualizar', $fundo_cartao->slug) }}" e method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._form-fundo-cartao.index')

                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

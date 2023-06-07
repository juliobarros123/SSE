@extends('layouts.admin')

@section('titulo', 'Editar Tipo de Pagamento')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Tipo de Pagamento</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('tipos-pagamento.actualizar', $tipo_pagamento->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formTipo-Pagamento.index')

                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

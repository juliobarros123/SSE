@extends('layouts.admin')

@section('titulo', 'Declaração/Ver')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Ver Declarações</h3>
        </div>
    </div>

 
    <div class="card">
        <div class="card-body">

            <form method="post" action="{{ route('manipulaVisualizacaoLista') }}" class="row">
                @csrf
                @include('forms._formDeclaracoesSemNota.visualizar.index')
            </form>
        </div>
    </div>

<!-- Footer-->
@include('admin.layouts.footer')


@endsection


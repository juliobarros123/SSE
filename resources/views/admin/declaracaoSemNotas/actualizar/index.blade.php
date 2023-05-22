
@extends('layouts.admin')

@section('titulo', 'Declaração/Atualizar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Actualizar Declaração</h3>
        </div>
    </div>

 
    <div class="card">
        <div class="card-body">
        <form method="post" action="{{route('actualizar')}}" class="row">
            
                @csrf
                @include('forms._formDeclaracoesSemNota.actualizar.index')
               
            </form>
        </div>
    </div>

<!-- Footer-->
    @include('admin.layouts.footer')

@endsection


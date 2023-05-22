
@extends('layouts.admin')

@section('titulo', 'Home')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Erros</h3>
        </div>
    </div>

 
    <div class="card">
        <div class="card-body" >
        
        {{$erro}}
       
        </div>
    </div>

<!-- Footer-->
    @include('admin.layouts.footer')


@endsection


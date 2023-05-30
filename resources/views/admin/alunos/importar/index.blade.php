@extends('layouts.admin')

@section('titulo', 'Importar Alunos')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Importar Alunos</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form method="POST" class="row m-2" action="{{ route('admin.alunos.cadastrar') }}">
                @csrf
                @include('site.forms._formAluno.index')
                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Importar</button>
                </div>
            </form>
        </div>
    </div>



    @include('admin.layouts.footer')
@endsection

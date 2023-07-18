@extends('layouts.admin')

@section('titulo', 'Escola')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Escola</h3>
        </div>
    </div>



 

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('admin/escola/cadastrar') }}" method="post" class="row" enctype="multipart/form-data">
                @csrf
                @include('forms._formEscola.index')

                <div class="form-group col-sm-4">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
    @include('admin.layouts.footer')

@endsection


@extends('layouts.admin')

@section('titulo', 'Editar número de negativas admitidas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar números de negativas admitidas</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('configuracoes.pautas.n_negativas.actualizar', $n_negativa->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formN-negativa.index')



                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

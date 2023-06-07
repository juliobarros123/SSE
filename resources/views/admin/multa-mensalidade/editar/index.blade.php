@extends('layouts.admin')

@section('titulo', 'Editar Multa-Mensalidade')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Multa-Mensalidade</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('multas-mensalidades.actualizar', $multa_mensalidade->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formMulta-Mensalidade.index')


                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

@extends('layouts.admin')

@section('titulo', 'Editar Peso de Nota para Exame')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Peso de Nota para Exame</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('configuracoes.pautas.pesos_notas_exames.actualizar', $peso_nota_exame->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._form-peso-nota-exame.index')



                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

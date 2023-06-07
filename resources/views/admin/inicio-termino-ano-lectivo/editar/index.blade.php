@extends('layouts.admin')

@section('titulo', 'Editar Início e término do ano lectivo')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Início e término do ano lectivo</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('inicio-termino-ano-lectivo.actualizar', $inicio_termino_ano_lectivo->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formInicio-termino-ano-lectivo.index')


                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

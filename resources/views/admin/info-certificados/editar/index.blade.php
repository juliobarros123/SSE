@extends('layouts.admin')

@section('titulo', 'Editar Informações para o Certificado/Declaração')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Informações para o Certificado/Declaração</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.documentos.infos_certificado.actualizar', $info_certificado->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formInfo-Certificado.index')



                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>
            </form>
        </div>
    </div>
    
    @include('admin.layouts.footer')

@endsection

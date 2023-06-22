@extends('layouts.admin')

@section('titulo', 'Escola/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Escola <b>{{ $cabecalho->vc_escola }}</b></h3>
        </div>
    </div>



 
    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin/escola/atualizar', $cabecalho->id) }}" method="post" class="row" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID da Escola</label>
                    <input type="text" class="form-control" value="{{ isset($cabecalho->id) ? $cabecalho->id : '' }}" name="id">
                </div> --}}

                @include('forms._formEscola.index')
                <div class="form-group col-12 d-flex justify-content-center">
                 
                    <button class="btn btn-dark w-25" type="submit">Editar </button>
                </div>
            </form>

        </div>
    </div>
    @include('admin.layouts.footer')


@endsection


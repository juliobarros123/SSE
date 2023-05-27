@extends('layouts.admin')

@section('titulo', 'Municipio/Editar')

 @section('conteudo')
    <div class="card mt-3" >
        <div class="card-body">
            <h3>Editar Municipio <b>{{ $municipio->vc_nome }}</b></h3>
        </div>
    </div>




    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin.municipio.atualizar', $municipio->id) }}" method="post" class="row">
                @csrf
                @method('PUT')

                <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID da Municipio</label>
                    <input type="text" class="form-control" value="{{ isset($municipio->id) ? $municipio->id : '' }}" disabled>
                </div>

                @include('forms._formMunicipio.index')
                <div class="form-group col-sm-2">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Editar</button>
                </div>
            </form>

        </div>
    </div>

    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('municipio.actualizar.error'))
        <script>
            Swal.fire(
                'Erro ao Actualizar Municipio! ',
                '',
                'error'
            )
        </script>
    @endif
    @include('admin.layouts.footer')


    @endsection


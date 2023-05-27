@extends('layouts.admin')

@section('titulo', 'Província/Editar')

 @section('conteudo')
    <div class="card mt-3" >
        <div class="card-body">
            <h3>Editar Província <b>{{ $provincia->vc_nome }}</b></h3>
        </div>
    </div>




    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin.provincia.atualizar', $provincia->id) }}" method="post" class="row">
                @csrf
                @method('PUT')

                <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID da Província</label>
                    <input type="text" class="form-control" value="{{ isset($provincia->id) ? $provincia->id : '' }}" disabled>
                </div>

                @include('forms._formProvincia.index')
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
    @if (session('provincia.actualizar.error'))
        <script>
            Swal.fire(
                'Erro ao Actualizar Província! ',
                '',
                'error'
            )
        </script>
    @endif
    @include('admin.layouts.footer')


    @endsection


@extends('layouts.admin')

@section('titulo', 'Editar caminho')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar caminho</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('caminho'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'A caminho Já Existe',
        })
    </script>
@endif

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('caminho-files.actualizar', $caminho->id) }}" method="post" class="row">
                @csrf
                @method('PUT')

           

                @include('forms._formCaminho-file.index')
                <div class="form-group col-sm-2">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Editar</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


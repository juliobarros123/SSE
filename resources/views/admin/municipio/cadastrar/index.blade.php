@extends('layouts.admin')

@section('titulo', 'Municipio/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Municipio</h3>
        </div>
    </div>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('ano'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Municipio Inexistente',
            })
        </script>
    @endif




    <div class="card">
        <div class="card-body">


            <form action="{{ route('admin.municipio.cadastrar') }}" method="post" class="row">
                @csrf
                @include('forms._formMunicipio.index')
                <div class="form-group col-sm-4">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>

    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('municipio.cadastrar.error'))
        <script>
            Swal.fire(
                'Erro ao Cadastrar Municipio! ',
                '',
                'error'
            )
        </script>
    @endif
    @include('admin.layouts.footer')

@endsection

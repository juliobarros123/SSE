@extends('layouts.admin')

@section('titulo', 'Processo/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Editar Processo de <b>{{ $processo->it_processo }}</b></h3>
        </div>
    </div>


    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('id_aluno'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'O processo já existe ',
            })
        </script>
    @endif


    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ url('/Admin/processos/update', $processo->id) }}" class="row">
                @csrf
                @method('PUT')
                @include('forms._formProcessos.index')
                <div class="form-group col-md-3">
                    <label class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark" type="submit">Salvar
                        Alterações</button>
                </div>

            </form>
        </div>
    </div>


    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

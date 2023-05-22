@extends('layouts.admin')

@section('titulo', 'Turma/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Actualizar Turma <b>{{ isset($turma) ? $turma->vc_nomedaTurma : '' }}</b></h3>
        </div>
    </div>



    <div class="card">
        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-warning">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url("turmas/$turma->id/efectuarEdicaoDeTurma") }}" accept-charset="UTF-8"
                class="row">
                @method('PUT')
                @csrf
                @include('forms._formTurma.index')
                <div class="form-group col-md-3">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark form-control" type="submit">Salvar Alterações</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')
    @if (session('update'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Turma editata com sucesso',
        })
    </script>
    @endif

    
@endsection

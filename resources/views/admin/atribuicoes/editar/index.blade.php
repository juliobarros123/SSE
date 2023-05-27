@extends('layouts.admin')

@section('titulo', 'Editar Atribuiçao de Turma')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Atribuiçao de Turma ao Professor</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form form action="{{ route('admin.atribuicoes.atualizar', $atribuicao->slug) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formAtribuicao.index')
                <div class="col-md-5 py-1  text-center ">
                    <input type="submit" class="col-sm-6 btn btn-dark" value="Editar">
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Dados Actualizados com sucesso',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao actualizar os dados!',
                '',
                'error'
            )

        </script>
    @endif
    @if (session('error'))
    <script>
        Swal.fire(
            'Disciplina já tem professor!',
            '',
            'error'
        )

    </script>
@endif

    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

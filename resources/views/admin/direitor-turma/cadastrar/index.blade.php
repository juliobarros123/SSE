@extends('layouts.admin')

@section('titulo', 'Atribuir Turma')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Atribuir Direitor de Turma</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('atribuicao'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Atribuição Inexistente',
        })
    </script>
@endif
    <div class="card">
        <div class="card-body">
            <form form action="{{ route('turmas.efectuarCadastroDireitor') }}" method="post" class="row">
                @csrf

                @include('forms._formDireitorTurma.index')

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Atribuir">
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Turma atribuida com sucesso',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao atrtibuir turma!',
                '',
                'error'
            )

        </script>
    @endif


    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

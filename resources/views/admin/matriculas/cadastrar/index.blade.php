@extends('layouts.admin')

@section('titulo', 'Matricular/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Matricular</h3>
        </div>
    </div>


    <div class="card">

        <div class="card-body">

            <h5>No acto da Matricula tenha em atenção: <br>
                <ul>
                    <li>Ao selecionar a Turma, tem que corresponder com o curso e a classe da turma escolhida.</li>

                </ul>
            </h5>

            <form form action="{{ route('admin.matriculas.salvar') }}" method="post" class="row"
                enctype="multipart/form-data">
                @csrf

                @include('forms._formMatricula.index')

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Matricular">
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->


    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('alert'))
        <script>
            Swal.fire(
                ' Turma Indisponível',
                'Esta Turma não tem mais vagas!',
                'error'
            )

        </script>
    @endif
    @if (session('status'))
        <script>
            Swal.fire(
                'Aluno Matriculado',
                '',
                'success'
            )

        </script>
    @endif

    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao Matricular Aluno',
                'verifique o numero de processo!',
                'error'
            )

        </script>
    @endif
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('ExisteSelecionado'))
        <script>
            Swal.fire(
                'Falha ao Matricular Aluno',
                'Aluno já foi Matriculado no corrente ano lectivo!',
                'error'
            )

        </script>
    @endif

    @if (session('matricula'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Aluno Inexistente',
            })

        </script>
    @endif

    <!-- Footer-->
    @include('admin.layouts.footer')



@endsection

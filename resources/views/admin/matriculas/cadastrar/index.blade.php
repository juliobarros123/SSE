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

            <h5>As turmas dependem do curso do aluno<br>

            </h5>
            
           
            <form form action="{{ route('admin.matriculas.salvar') }}" method="post" class="row"
                enctype="multipart/form-data">
                @csrf

                @include('forms._formMatricula.index')

                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->


    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

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
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
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

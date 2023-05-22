
@extends('layouts.admin')

@section('titulo', 'Selecionado/cadastrar')

@section('conteudo')

<div class="card mt-3">
        <div class="card-body">
            <h3>Selecionar Candidato à Matrícula</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('aluno'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Candidato Inexistente',
        })
    </script>
@endif
    <div class="card">
        <div class="card-body">
            <form method="POST" class="row m-2" action="{{ route('admin.alunos.recebeBI') }}">
                @csrf
                <div class="col-8">
                    <label for="bi" class="form-label">Introduza o número de inscrição do candidato</label>
                    <input type="" autocomplete="off" name="searchBI"
                        placeholder="Introduzir o número de inscrição do candidato" class="form-control" id="bi" required>
                </div>
                <div class="col-4">
                    <label class="form-label text-white">.</label><br>
                    <button id="btn_consulta" class="form-control col-4 btn btn-dark">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card" id="result">
        <div class="card-body">
            <form form action="{{ route('admin.alunos.cadastrar') }}" method="post" class="row">
                @csrf

                @isset($alunos)
                    @foreach ($alunos as $aluno)
                        @include('forms._formAluno.index')

                        <div class="col-sm-12 mt-2 text-center">
                            <input type="submit" class=" col-sm-3 btn btn-success" value="Selecionar Candidato">
                        </div>
                    @endforeach
                @else
                    @if (session('aviso'))
                        <h6 class="text-center col-12 text-danger"><i>{{ session('aviso') }}</i></h6>
                    @else
                        <h6 class="text-center col-12"><i>Introduza o número de inscrição do candidato para proceder
                                com a
                                selecção</i></h6>
                    @endif
                @endisset
            </form>

        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Selecção efectuada com sucesso!',
                '',
                'success'
            )

        </script>
    @endif

    @include('admin.layouts.footer')
 @endsection


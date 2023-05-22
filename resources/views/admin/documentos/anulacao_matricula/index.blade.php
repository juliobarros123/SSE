@extends('layouts.admin')

@section('titulo', 'Anulação de Matricula/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Anulação de Matricula </h3>
        </div>
    </div>
    @if ($errors->any())
        <div class="card">
            <div class="card-body">

                <div class="text-center">

                    @foreach ($errors->all() as $error)
                        <i>
                            <p class="text-danger text-center">{{ $error }}</p>
                        </i>
                    @endforeach

                </div>



            </div>
        </div>
    @endif
    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('documentos.anulacao_matricula.imprimir') }}" target="_blank"
                class="row">
                @csrf
                <div class="form-group col-6">
                    <label for="processo" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="processo"
                        placeholder="Número de processo" value="" id="processo" required>
                </div>
                <div class="form-group col-6">
                    <label for="processo" class="form-label">Modelo</label>
                    <select name="modelo" id="" class="form-control" required>
                        <option selected disabled>Selecciona a opção</option>
                        <option value="Dinâmico">Dinâmico</option>
                        <option value="Estático">Estático</option>
                        <option value="Puro">Puro</option>
                    </select>

                </div>
                <div class="form-group col-12 d-flex justify-content-center">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark " type="submit">Emitir </button>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

    <!-- Footer-->
    @include('admin.layouts.footer')

    @if (session('anulacao_matricula.imprimir.error'))
        <script>
            Swal.fire(
                'Erro ao Emitir Anulação de Matrícula! ',
                '',
                'error'
            )
        </script>
    @endif
    @if (session('anulacao_matricula.aluno.inexistente'))
        <script>
            Swal.fire(
                'Erro ao Emitir Anulação de Matrícula! ',
                'Aluno não encontrado',
                'error'
            )
        </script>
    @endif
@endsection

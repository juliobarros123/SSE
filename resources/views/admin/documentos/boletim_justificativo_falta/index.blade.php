@extends('layouts.admin')

@section('titulo', 'Boletim de Justificativo de Faltas/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Boletim de Justificativo de Faltas </h3>
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
            <form method="POST" action="{{ route('documentos.boletim_justificativo_falta.imprimir') }}" target="_blank"
                class="row">
                @csrf
                <div class="form-group col-md-6">
                    <label for="processo" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="processo"
                        placeholder="Número de processo" value="" id="processo" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="processo" class="form-label">Modelo</label>
                    <select name="modelo" id="" class="form-control" required>
                        <option selected disabled>Selecciona a opção</option>
                        <option value="Dinâmico">Dinâmico</option>
                        <option value="Estático">Estático</option>
                        <option value="Puro">Puro</option>
                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label for="faltas" class="form-label">Faltas</label>
                    <select name="faltas[]" id="" class="form-control js-example-basic-multiple-faltas multiple"
                        multiple required>
                        {{--   <option selected disabled>Selecciona a opção</option> --}}
                        @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                            @foreach ($desd as $row)
                                <option value="{{ $row->vc_nome }}">{{ $row->vc_nome }}</option>
                            @endforeach
                        @else
                        @foreach ($disciplinas as $disciplina)
                        <option value="{{ $disciplina->vc_nome }}">{{ $disciplina->vc_nome }}</option>
                        @endforeach
                        @endif

                    </select>

                </div>

                <div class="form-group col-md-4">
                    <label for="motivo" class="form-label">Motivo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="motivo"
                        placeholder="" value="" id="motivo" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="data" class="form-label">Data:</label>
                    <input type="date" class="form-control border-secondary col-sm-12" name="data"
                        placeholder="" value="" id="data" required>
                </div>

                <div class="form-group col-md-12 d-flex justify-content-center">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark " type="submit">Emitir </button>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

    <!-- Footer-->
    @include('admin.layouts.footer')

    @if (session('boletim_justificativo_falta.imprimir.error'))
        <script>
            Swal.fire(
                'Erro ao Emitir Boletim de Justificativo de Faltas! ',
                '',
                'error'
            )
        </script>
    @endif
    @if (session('boletim_justificativo_falta.aluno.inexistente'))
        <script>
            Swal.fire(
                'Erro ao Emitir Boletim de Justificativo de Faltas! ',
                'Aluno não encontrado',
                'error'
            )
        </script>
    @endif

@endsection

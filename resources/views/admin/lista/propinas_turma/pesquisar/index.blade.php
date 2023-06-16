@extends('layouts.admin')
@section('titulo', 'Imprimir Lista de  propinas por turma(Alunos) ')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Imprimir Lista de  propinas por turma(Alunos)</h3>
        </div>
    </div>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('teste'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Candidato Inexistente',
            })
        </script>
    @endif

    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('listas.propinas_turmas.imprimir') }}" class="row" method="POST">
                @csrf
              
                <div class="col-sm-5">
                    <div class="form-group">

                        <label>Turma</label>
                        {{-- <select name="it_idTurma" class="form-control buscarTurma"> --}}
                        <select name="id_turma" id="id_turma" class="form-control select-dinamico" required>

                            <option value="">Seleciona a turma</option>
                            
                            @isset($turmas)
                                @foreach ($turmas as $turma)
                                    <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                                        {{ $turma->vc_classe }}ª
                                        classe/{{ $turma->vc_nomeCurso }}/{{ $turma->vc_turnoTurma }}({{ $turma->ya_inicio }}/{{ $turma->ya_fim }})
                                    </option>
                                @endforeach
                            @endisset
                        </select>

                    </div>
                </div>
                <div class="form-group col-md-3">
                    <label for="mes" class="form-label">Meses:</label>
                    <select name="mes" id="mes" class="form-control" required>
                        <option value="">Selecciona o mês</option>

                        @foreach (fh_meses() as $mes)
                            <option value="{{ $mes }}">
                                {{ $mes }}
                            </option>
                        @endforeach
                    </select>

                </div>
           
                <div class="form-group col-md-3">
                    <label for="estado" class="form-label">Estado:</label>
                    <select name="estado" id="estado" class="form-control" required>
                        <option value="">Selecciona o estado</option>

                     
                            <option value="Pagas">
                                Pagas
                            </option>
                            <option value="Não Pagas">
                                Não Pagas
                            </option>
                    </select>

                </div>


                <div class=" d-flex justify-content-center w-100">
                    <button class="form-control btn btn-dark w-25">Imprimir</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection

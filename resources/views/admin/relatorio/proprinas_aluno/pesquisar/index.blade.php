@extends('layouts.admin')
@section('titulo', 'Imprimir Relatório propinas por aluno ')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Imprimir Relatório propinas por aluno</h3>
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
            <form action="{{ route('relatorios.propinas.alunos.imprimir') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                    @if (isset($ano_lectivo_publicado))
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
                            <option value="Todos">Todos</option>
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                </div>


                <div class="form-group col-md-4">
                    <label for="mes" class="form-label">Meses:</label>
                    <select name="mes" id="mes" class="form-control">
                        <option value="Todos">Todos</option>
                        @foreach (fh_meses() as $mes)
                            <option value="{{ $mes }}">
                                {{ $mes }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-4">
                    <label for="id_classe" class="form-label">Classe:</label>
                    <select name="id_classe" id="id_classe" class="form-control">
                        <option value="Todas">Todas</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ª classe
                            </option>
                        @endforeach
                    </select>

                </div>


                <div class=" d-flex justify-content-center w-100">
                    <button class="form-control btn btn-dark col-md-3">Imprimir</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection

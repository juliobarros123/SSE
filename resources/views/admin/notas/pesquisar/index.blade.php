@extends('layouts.admin')
@section('titulo', 'Nota/Ver')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Notas</h3>
        </div>
    </div>



    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.notas.recebePesquisaNotas') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-3">
                    <label for="vc_anolectivo">Ano Lectivo:</label>
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control border-secondary" required>
                        <option value="" disabled selected>Selecione o Ano Lectivo</option>
                        @foreach ($anoslectivos as $anolectivo)
                            <option value='{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}'>
                                {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label>Trimestre</label>
                    <select name="vc_nomeT" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione o Trimestre</option>
                        <option value="I">Iºtrimestre</option>
                        <option value="II">IIºtrimestre</option>
                        <option value="III">IIIºtrimestre</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <label for="classe">Classe:</label>
                    <select name="classe" id="classe" class="form-control border-secondary" required>
                        <option value="" selected disabled>selecione a Classe</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->vc_classe }}">
                                {{ $classe->vc_classe }}ªclasse
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-3">
                    <label for="vc_nomedaTurma" class="form-label">Turma:</label>
                    <select name="vc_nomedaTurma" id="vc_nomedaTurma" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione a Turma</option>
                        @foreach ($turmas as $turma)
                            <option value="{{ $turma->vc_nomedaTurma }}">
                                {{ $turma->vc_nomedaTurma }}
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-3">
                    <label>Disciplina</label>
                    <select name="vc_disciplina" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione a disciplina</option>
                        @foreach ($disciplinas as $disciplina)
                            <option value="{{ $disciplina->id }}">{{ $disciplina->vc_nome }} | {{$disciplina->vc_nomeCurso}} | {{$disciplina->vc_classe}}ª classe</option>
                        @endforeach
                    </select>

                </div>
                

                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection

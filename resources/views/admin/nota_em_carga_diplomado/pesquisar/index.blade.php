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

    {{-- <div class="card">
        <div class="card-body">
            <form action="{{ route('nota_em_carga_diplomado.ver') }}" class="row" method="POST">
                @csrf
                <div class="form-group col-md-3">
                    <label for="id_anolectivo">Ano Lectivo:</label>
                    <select name="id_anolectivo" id="id_anolectivo" class="form-control border-secondary" required>
                        <option value="" disabled selected>Selecione o Ano Lectivo</option>
                        @foreach ($anoslectivos as $anolectivo)
                            <option value='{{ $anolectivo->id}}'>
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
                    <select name="id_classe" id="classe" class="form-control border-secondary" required>
                        <option value="" selected disabled>selecione a Classe</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ªclasse
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-3">
                    <label for="vc_nomedaTurma" class="form-label">Turma:</label>
                    <select name="id_turma" id="vc_nomedaTurma" class="form-control border-secondary" required>
                        <option value="" disabled selected>selecione a Turma</option>
                        @foreach ($turmas as $turma)
                            <option value="{{ $turma->id }}">
                                {{ $turma->vc_nomedaTurma }}
                            </option>
                        @endforeach
                    </select>

                </div>
               
                <div class="form-group col-md-3">
                    <label>Disciplina</label>
                    <select name="id_disciplina" class="form-control border-secondary" required>
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
    </div> --}}











    <div class="card">
        <div class="card-body">
            <form method="POST" class="row" action="{{ route('nota_em_carga_diplomado.ver') }}">
                @csrf
                <div class="col-sm-4">
                    <div class="form-group">
                        <label>Turma|Disciplina</label>

                        <select name="id_turma_user" class="form-control select-dinamico" required>
                            @foreach ($turmasUser as $turmaUser)
                                <option value="{{ $turmaUser->id_turma_user }}">
                                    {{ $turmaUser->vc_cursoTurma }}||{{ $turmaUser->vc_classe }}
                                    ªClasse||{{ $turmaUser->vc_nomedaTurma }}||{{ $turmaUser->vc_nome }} </option>
                            @endforeach
                        </select>

                    </div>
                </div>




                <div class="col-md-4">
                    <label for="vc_tipodaNota" class="form-label">Trimestre ou Tipo da Nota</label>
                    <select name="vc_tipodaNota" id="vc_tipodaNota" class="form-control border-secondary" required>
                        <option value="" selected disabled>seleciona o trimestre ou tipo da nota</option>
                        <option value="Final">Final</option>
                        {{-- @foreach ($permissoesNota as $permissaoNota)
                            @if ($permissaoNota->vc_trimestre == 'I' && $permissaoNota->estado == 1)
                                <option value="I">Iºtrimestre</option>
                            @endif

                            @if ($permissaoNota->vc_trimestre == 'II' && $permissaoNota->estado == 1)
                                <option value="II">IIºtrimestre</option>
                            @endif

                            @if ($permissaoNota->vc_trimestre == 'III' && $permissaoNota->estado == 1)
                                <option value="III">IIIºtrimestre</option>
                            @endif
                        @endforeach --}}



                        {{-- <option value="EE">Exame Especial</option>
                    <option value="EP" >Exame Provincial</option> --}}

                    </select>
                </div>


              

                <div class="col-md-4">
                    <label for="id_anoLectivo" class="form-label">Ano Lectivo actual</label>





                  
                        @if (isset($ano_lectivo_publicado))
                        <select name="id_anoLectivo" id="id_anoLectivo" class="form-control border-secondary" readonly required>
                            <option value="{{ $id_anoLectivo_publicado }}">{{ $ano_lectivo_publicado }}</option>
                        </select>
                            <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                        @else
                            @isset($anoActual->id)
                            <select name="id_anoLectivo" id="id_anoLectivo" class="form-control border-secondary" readonly required>
                                <option value="{{ $anoActual->id }}">{{ $anoActual->ya_inicio . '-' . $anoActual->ya_fim }}
                                </option>
                            </select>
                            @endisset
                        @endif
                   





                </div>

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Buscar" id="inserir">
                </div>
            </form>

        </div>
    </div>
    @include('admin.layouts.footer')



@endsection

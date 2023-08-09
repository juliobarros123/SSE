@extends('site.layouts.app')
@section('titulo', 'Minha Pauta')
@section('conteudo')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">Minha Pauta </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form form action="{{ route('painel.alunos.pauta') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex">
                    <div class="form-group col-md-4">
                        <label for="">Ano Lectivo</label>


                            <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" required>
                                <option value="" >
                                    Selecione o ano lectivo</option>
                                @foreach (fh_anos_lectivos()->get() as $anolectivo)
                                    <option value="{{ $anolectivo->id }}">
                                        {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                    </option>
                                @endforeach
                            </select>
                   

                    </div>
                    <div class="form-group col-md-4">
                        <label for="">Trimestre</label>
                        <select name="trimestre" id="trimestre" class="form-control" required>
                            <option value="" selected>
                                Selecciona o Trimestre
                            </option>
                            <option value="I">
                                I
                            </option>
                            <option value="II">
                                II
                            </option>

                            <option value="III">
                                III
                            </option>
                            <option value="Todos">
                                Todos
                            </option>

                        </select>
                    </div>
                </div>
                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn-sm btn-dark pl-4 pr-4 ">Ver</button>
                </div>
            </form>
        </div>
    </div>
@isset($matricula)
    

    <div class="row ">
        @isset($disciplinas)
            @if ($trimestre != 'Todos')
              
            @else
                @foreach ($disciplinas as $disciplina)
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Disciplina: {{ $disciplina->vc_nome }}({{ $trimestre }}-{{$matricula->ya_inicio}}/{{$matricula->ya_fim}})</h5>
                                <p class="card-text">Notas:</p>
                                <div class="row">
                                    @php
                                                                            $ca = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);

                                    @endphp


                             
                                    <div class="col-md-4">
                                        CA=<span style="color:<?php echo $ca >= 10 ? 'blue' : 'red'; ?>">{{ $ca }}</span>
                                    </div>

                                    @php
                                        $disciplina_curso_classe_actual = fh_disciplinas_cursos_classes()
                                            ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                                            ->where('disciplinas.id', $disciplina->id)
                                            ->where('classes.vc_classe', $turma->vc_classe)
                                            ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                                            ->orderBy('classes.vc_classe', 'desc')
                                            ->first();
                                        
                                        $classes = fh_disciplinas_cursos_classes()
                                            ->where('disciplinas_cursos_classes.it_curso', $turma->it_idCurso)
                                            ->where('disciplinas.id', $disciplina->id)
                                            ->where('classes.vc_classe', '<', $turma->vc_classe)
                                            ->select('classes.*', 'disciplinas.vc_nome', 'disciplinas_cursos_classes.terminal')
                                            ->orderBy('classes.vc_classe', 'desc')
                                            ->get();
                                        /* dd(    $classes ); */
                                        $ca_classe_anterior = 0;
                                    @endphp

                        


                                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso))
                                        @php
                                            $cfd = fha_cfd_ext($matricula->processo, $disciplina->id, $turma->it_idClasse);
                                        @endphp
                                        <div class="col-md-4">
                                            CFD=<span style="color:<?php echo $cfd >= 10 ? 'blue' : 'red'; ?>">{{ $cfd }}</span>
                                        </div>
                                    @endif
                                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso) && $turma->vc_classe > 9)
                                        @php
                                                                       $rec = fh_nota_recurso_v2($aluno->processo, $disciplina->id,$turma->it_idClasse);

                                        @endphp
                                        <div class="col-md-4">
                                            REC=<span style="color:<?php echo $rec >= 10 ? 'blue' : 'red'; ?>">{{ $rec }}</span>
                                        </div>
                                    @endif


                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <div class="col-lg-12 d-flex justify-content-center ">
                    <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title">
                                @php
                                    $media = fhap_media_geral($matricula->processo, $turma->it_idClasse, $turma->it_idAnoLectivo);
                                @endphp
                                <div>

                                    MÉDIA:<span
                                        style="{{ $media >= 10 ? 'color:blue' : 'color:red' }}">{{ $media }}</span>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 d-flex justify-content-center ">
                    <div class="card ">
                        <div class="card-body">
                            <h5 class="card-title">
                                @php
                                    
                                    $color = 'red';
                                    $resultados = fhap_aluno_resultato_pauta($matricula->processo, $turma->it_idCurso, $turma->it_idClasse, $turma->it_idAnoLectivo);
                                    
                                    if ($resultados[0] == 'TRANSITA' || $resultados[0] == 'TRANSITA/DEFICIÊNCIA') {
                                        $color = 'blue';
                                    }
                                    
                                @endphp

                                <div>

                                    OBS:<span style="color:<?php echo $color; ?>">{{ $resultados[0] }}</span>
                                </div>
                            </h5>
                        </div>
                    </div>
                </div>
            @endif

        @endisset

    </div>

    @endisset
@endsection

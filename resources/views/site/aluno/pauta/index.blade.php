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
                @foreach ($disciplinas as $disciplina)
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Disciplina: {{ $disciplina->vc_nome }}({{ $trimestre }}-{{$matricula->ya_inicio}}/{{$matricula->ya_fim}})</h5>
                                <p class="card-text">Notas:</p>
                                <div class="row">
                                    @php
                                        $mac = fha_mac_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $nota1 = fha_nota1_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $nota2 = fha_nota2_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $media = fha_media_trimestral_geral($matricula->processo, $disciplina->id, [$trimestre], $turma->it_idAnoLectivo);
                                        
                                    @endphp
                                    <div class="col-md-4">
                                        MAC=<span style="color:<?php echo $mac >= 10 ? 'blue' : 'red'; ?>">{{ $mac }}</span>

                                    </div>
                                    <div class="col-md-4">
                                        P1=<span style="color:<?php echo $nota1 >= 10 ? 'blue' : 'red'; ?>">{{ $nota1 }}</span>

                                    </div>
                                    <div class="col-md-4">
                                        P2=<span style="color:<?php echo $nota2 >= 10 ? 'blue' : 'red'; ?>">{{ $nota2 }}</span>

                                    </div>
                                    <div class="col-md-4">
                                        Média=<span style="color:<?php echo $media >= 10 ? 'blue' : 'red'; ?>">{{ $media }}</span>

                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                @foreach ($disciplinas as $disciplina)
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Disciplina: {{ $disciplina->vc_nome }}({{ $trimestre }}-{{$matricula->ya_inicio}}/{{$matricula->ya_fim}})</h5>
                                <p class="card-text">Notas:</p>
                                <div class="row">
                                    @php
                                        $mac = fha_mac_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $nota1 = fha_nota1_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $nota2 = fha_nota2_trimestre_por_ano($matricula->processo, $disciplina->id, $trimestre, $turma->it_idAnoLectivo);
                                        $media = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);
                                        
                                    @endphp


                                    @php
                                        $mt1 = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['I'], $turma->it_idAnoLectivo);
                                        $mt2 = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['II'], $turma->it_idAnoLectivo);
                                        $mt3 = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['III'], $turma->it_idAnoLectivo);
                                        /* dd($matricula->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo) */
                                        $ca = fha_media_trimestral_geral($matricula->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);
                                    @endphp
                                    <div class="col-md-4">
                                        MT1=<span style="color:<?php echo $mt1 >= 10 ? 'blue' : 'red'; ?>">{{ $mt1 }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        MT2=<span style="color:<?php echo $mt2 >= 10 ? 'blue' : 'red'; ?>">{{ $mt2 }}</span>
                                    </div>
                                    <div class="col-md-4">
                                        MT3=<span style="color:<?php echo $mt3 >= 10 ? 'blue' : 'red'; ?>">{{ $mt3 }}</span>
                                    </div>
                                    @if (fha_disciplina_exame($turma->it_idClasse, $disciplina->id))
                                        @php
                                            $mft = fha_mfd_sem_exame($matricula->processo, $disciplina->id, $turma->it_idAnoLectivo);
                                            
                                            $exame = fha_nota_exame($matricula->processo, $disciplina->id, $turma->it_idAnoLectivo);
                                        @endphp
                                        <div class="col-md-4">
                                            MFT=<span style="color:<?php echo $mft >= 10 ? 'blue' : 'red'; ?>">{{ $mft }}</span>
                                        </div>
                                        <div class="col-md-4">
                                            EXAME=<span style="color:<?php echo $exame >= 10 ? 'blue' : 'red'; ?>">{{ $exame }}</span>
                                        </div>
                                    @endif
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

                                    @if (
                                        $cabecalho->vc_tipo_escola == 'Técnico' &&
                                            $turma->vc_classe >= 10 &&
                                            $disciplina_curso_classe_actual->terminal == 'Terminal')
                                        @foreach ($classes as $classe)
                                            @php
                                                $ca_classe_anterior = fha_ca($matricula->processo, $disciplina->id, ['I', 'II', 'III'], $classe->id);
                                            @endphp
                                            <div class="col-md-4">
                                                {{ $classe->vc_classe }}ª Classe=<span
                                                    style="color:<?php echo $ca_classe_anterior >= 10 ? 'blue' : 'red'; ?>">{{ $ca_classe_anterior }}</span>
                                            </div>
                                        @endforeach
                                    @endif



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
                                            $rec = fh_nota_recurso($matricula->processo, $disciplina->id);
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

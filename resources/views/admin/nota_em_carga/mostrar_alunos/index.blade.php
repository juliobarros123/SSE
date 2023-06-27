@extends('layouts.admin')

@section('titulo', 'Inserir Notas')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir Notas</h3>
            <div class="dates">
                <strong>Turma:</strong>
                {{$turma->vc_nomedaTurma}}
                &nbsp;
                <strong>Turno:</strong>
                {{$turma->vc_turnoTurma}}
                &nbsp;
                <strong>Classe:</strong>
                {{$turma->vc_classe}}ª
                &nbsp;
                <strong>Curso:</strong>
                {{$turma->vc_shortName}}
                &nbsp;
                
                <strong>Ano Lectivo:</strong>
                {{$turma->ya_inicio.'/'.$turma->ya_fim}}
                <strong>Trimestre:</strong>
                {{$trimestre}}
                
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="" target="_blank" action="{{ url('nota_em_carga/inserir') }}">
                @csrf
                <input type="text" name="trimestre" value="{{ $trimestre }}" hidden>
                <input type="text" name="slug_turma_professor" value="{{ $turma_professor->slug }}" hidden>

                <?php $contador = 1; ?>
              
                <table class="table table-hover " id="example">
                    <thead>
                        <tr>
                            <th scope="col">Nº </th>
                            <th scope="col">PROCESSO</th>
                            <th scope="col">NOME COMPLETO</th>
                            {{-- <th scope="col">ÚLTIMO NOME</th> --}}
                            <th scope="col">MAC</th>
                            <th scope="col">NPP</th>
                            <th scope="col " id="col-nota2">NPT</th>

                            <th scope="col">INDIVÍDUO </th>
                        </tr>
                    </thead>











                    <tbody>
                        @if ($alunos)
                            @foreach ($alunos as $aluno)
                                <div class="modal fade" id="exampleModal{{ $aluno->processo }}" tabindex="-1"
                                    role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class=" d-flex justify-content-center">
                                                <div class="modal-header">
                                                    <h3 class="modal-title" id="exampleModalLabel">
                                                        {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_apelido }}
                                                    </h3>

                                                </div>
                                            </div>
                                            <div class="modal-body">
                                                <div class="col mx-auto text-center">
                                                    <img class="img-circle" src="{{ asset('/' . $aluno->vc_imagem) }}"
                                                        width="250" height="250">
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-primary"
                                                    data-dismiss="modal">Close</button>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <tr>
                                    <td><?php echo $contador++; ?></td>
                                    <th scope="row">{{ $aluno->processo }}</th>
                                    <td> {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                        {{ $aluno->vc_apelido }}</td>
                                        @php
                                        $mac = fha_mac_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                                        $nota1 = fha_nota1_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                                        $nota2 = fha_nota2_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                                        $media = fha_media_trimestre_por_ano($aluno->processo, $turma_professor->id_disciplina, $trimestre, $turma->it_idAnoLectivo);
                                        
                                    @endphp
                                    <td>

                                     
                                            <input type="number" min="0" max="20" step="any"
                                                class="form-control border-secondary  " placeholder="MAC"
                                                name="fl_mac_{{ $aluno->processo }}" 
                                                style="color:<?php echo $mac >= 10 ? 'blue' : 'red'; ?>!important" value="{{ $mac}}" >

                                    </td>
                                    <td>

                                        <input type="number" min="0" max="20" step="any"
                                            class="form-control border-secondary  " placeholder="Nota 1"
                                            name="fl_nota1_{{ $aluno->processo }}" 
                                            style="color:<?php echo $nota1 >= 10 ? 'blue' : 'red'; ?>!important"
                                            value="{{ $nota1}}" >

                                    </td>
                                    <td class="nota2">
                                        <input type="number" min="0" max="20" step="any"
                                            class="form-control border-secondary  " placeholder="Nota 2"
                                            name="fl_nota2_{{ $aluno->processo }}" value="{{ $nota2}}"
                                            style="color:<?php echo $nota2>= 10 ? 'blue' : 'red'; ?>!important">
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <button type="button" class="btn btn-primary" data-toggle="modal"
                                                data-target="#exampleModal{{ $aluno->processo }}">
                                                FOTOGRÁFIA
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                    </tbody>
                </table>

                @endif










                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Inserir" id="inserir">
                </div>
            </form>

        </div>
    </div>

    <!-- sweetalert -->

    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>

    <script></script>

    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('ExisteNota'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Nota do Aluno já foi introduzida',
                'error'
            )
        </script>
    @endif

    @if (session('status'))
        <script>
            Swal.fire(
                'Nota inserida ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Verifica o relacionamento da disciplina com curso',
                'error'
            )
        </script>
    @endif


    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

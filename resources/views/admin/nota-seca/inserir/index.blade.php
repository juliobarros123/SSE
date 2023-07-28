@extends('layouts.admin')

@section('titulo', 'Inserir Notas Finais')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir Notas Finais</h3>
            <div class="dates">
                <strong>Turma:</strong>
                {{ $turma->vc_nomedaTurma }}
                &nbsp;
                <strong>Turno:</strong>
                {{ $turma->vc_turnoTurma }}
                &nbsp;
                <strong>Classe:</strong>
                {{ $turma->vc_classe }}ª
                &nbsp;
                <strong>Curso:</strong>
                {{ $turma->vc_shortName }}
                &nbsp;

                <strong>Ano Lectivo:</strong>
                {{ $turma->ya_inicio . '/' . $turma->ya_fim }}
                <strong>Trimestre:Todos</strong>


            </div>
       
            @if (!$turmas_disciplinas_dcc->count())
            <br>
            <h4 class="text-warning"> Víncula disciplinas com curso para está classe</h4>
                
            @endif
        </div>
    </div>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('ano'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Municipio Inexistente',
            })
        </script>
    @endif




    <div class="card">
        <div class="card-body">


            <form method="POST" class="" target="_blank"
                action="{{ route('notas-finais.cadastrar', ['slug_turma' => $turma->slug]) }}">
                @csrf


                <table  class="display table table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Nº </th>
                            <th scope="col">PROCESSO</th>
                            <th scope="col">NOME COMPLETO</th>
                     
                            @foreach ($turmas_disciplinas_dcc as $disciplina)
                                <th scope="col">{{ $disciplina['vc_acronimo'] }}</th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                            <tr>
                                <td>{{$loop->index+1}}</td>
                                <th scope="row">{{ $aluno->processo }}</th>
                                <td> {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                    {{ $aluno->vc_apelido }}</td>
                                @foreach ($turmas_disciplinas_dcc as $dcc)
                                    <td>
                                        {{-- @dump($dcc) --}}
                                        <div class="form-group ">
                                            @php
                                                $ca=fha_media_trimestral_geral($aluno->processo,  $dcc->id_disciplina, ['I','II','III'], $turma->it_idAnoLectivo);
                                            //    dd( $ca);
                    //                             if($aluno->processo==2 && $dcc->id_dcc==3){
                    //                               $n=  fh_notas()
                    // ->where('alunnos.processo',$aluno->processo)
               
                    // ->where('notas.id_disciplina_curso_classe', $dcc->id_dcc)
                   
             
                    // ->where('notas.id_ano_lectivo', $turma->it_idAnoLectivo)->get();
                    // dd(   $n);
                    // }
                                           @endphp
                                         
                                            <input type="number" min="0" max="{{nota_limit($turma->vc_classe)}}" step="any"
                                            class="form-control " 
                                            placeholder="Nota"
                                            style="color:<?php echo $ca >= nota_positiva($turma->vc_classe) ? 'blue' : 'red'; ?>!important"
                                            name="idDCC_{{ $dcc->id_dcc }}_{{ $aluno->processo }}"
                                            value="{{$ca }}">
                                          
                                            
                                                
                                        </div>
                                    </td>
                                @endforeach\
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Inserir" id="inserir">
                </div>
            </form>

        </div>
    </div>

    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('municipio.cadastrar.error'))
        <script>
            Swal.fire(
                'Erro ao Cadastrar Municipio! ',
                '',
                'error'
            )
        </script>
    @endif
    @include('admin.layouts.footer')

@endsection

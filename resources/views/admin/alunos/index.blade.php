@extends('layouts.admin')

@section('titulo', 'Alunos/Listar')

<script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
@if (session('editarAluno'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Funcionário Inexistente',
        })
    </script>
@endif


@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="row col-md-12">
                    <div class="col-md-6">
                        <h3>Alunos</h3>
                    </div>

                </div>

            </div>
        </div>
    </div>







    <div class="table-responsive">
        <table id="example" class="display table table-hover">
            <thead class="">
                <tr >
                    <th>PROCESSO</th>
                    <th>FOTOGRAFIA</th>
                    <th>NOME COMPLETO</th>

                    <th>CURSO</th>
                    <th>CLASSE</th>


                    <th>ACÇÕES</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($alunos as $aluno)
                    <td>{{ $aluno->processo }}</td>
                    <td> <img src="{{ asset('/' . $aluno->vc_imagem) }}" width="25" height="25" alt=""></td>
                    <td class="text-left">
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                    </td>
                    <td>{{ $aluno->vc_nomeCurso }}</td>
                    <td>{{ $aluno->vc_classe }}ª Classe</td>





                    <td>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" type="button" data-toggle="modal"
                                    data-backdrop="static"
                                    data-target=".bd-example-modal-lg-{{ $aluno->id }}">Expandir</a>

                               
                                {{-- <a class="dropdown-item" href="{{ route('aluno.update', $aluno->id) }}">Editar imagem</a> --}}
                                {{-- @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                    <a class="dropdown-item" href="{{ route('aluno.delete', $aluno->slug) }}"
                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>

                                @endif --}}
                            </div>
                        </div>


                    </td>
                    </tr>
{{-- @dump( $aluno) --}}
                    <div class="modal fade bd-example-modal-lg-{{ $aluno->id }}" tabindex="-1" role="dialog"
                        aria-labelledby="myLargeModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Processo: <b>{{ $aluno->processo }}</b></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <h5 class="text-left mb-2 ml-2"><b>Dados Pessoais</b></h5>
                                    <p class="ml-4">
                                        <b>Nome Completo:
                                        </b>{{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}<br>

                                        <b>Data de Nascimento: </b>
                                        {{ date('d-m-Y', strtotime($aluno->dt_dataNascimento)) }}<br>
                                        <b>Idade: </b>
                                        {{ calcularIdade($aluno->dt_dataNascimento)}} anos<br>

                                        <b>Nome do Pai: </b>
                                        {{ $aluno->vc_nomePai }}<br>
                                        <b>Nome da Mãe: </b>
                                        {{ $aluno->vc_nomeMae }}<br>
                                        <b>Genero: </b>
                                        {{ $aluno->vc_genero }}<br>
                                        <b>Deficiênte Físico?: </b>
                                        {{ $aluno->vc_dificiencia }}<br>
                                        <b>Estado Civil: </b>
                                        {{ $aluno->vc_estadoCivil }}<br>
                                        <b>Telefone: </b>
                                        {{ $aluno->it_telefone }}<br>
                                        <b>Email: </b>
                                        {{ $aluno->vc_email }}<br>
                                        <b>Residência: </b>
                                        {{ $aluno->vc_residencia }}<br>
                                        <b>Naturalidade: </b>
                                        {{ $aluno->vc_naturalidade }}<br>
                                        <b>Município: </b>
                                        {{ $aluno->vc_municipio }}<br>
                                        <b>Provincia: </b>
                                        {{ $aluno->vc_provincia }}<br>
                                        <b>Bilhete de Identidade Nº: </b>
                                        {{ $aluno->vc_bi }}<br>
                                        <b>Data de emissão do bilhete de Identidade/Cédula Pessoal de Identificação:</b>
                                        {{ date('d-m-Y', strtotime($aluno->dt_emissao)) }}<br>
                                        <b>Local de emissão do Bilhete de Identidade: </b>
                                        {{ $aluno->vc_localEmissao }}<br>
                                    </p>
                                    {{-- <h5 class="text-left mb-2 mt-2 ml-2"><b>Dados Acadêmicos</b></h5> --}}
                                    <p class="ml-4">
                                        <b>Escola Anterior: </b>
                                        {{ $aluno->vc_EscolaAnterior }}<br>

                                        <b>Ano de Conclusão: </b>
                                        {{ $aluno->ya_anoConclusao }}
                                    </p>
                                    {{-- <h5 class="text-left mt-2 ml-2"><b>Dados da Nova Escola</b></h5> --}}
                                    <p class="ml-4">
                                        <b>Curso escolhido: </b>
                                        {{ $aluno->vc_nomeCurso }}<br>
                                        <b>Classe Inicial: </b>
                                        {{ $aluno->vc_classe}}ªClasse<br>
                                        {{-- <b>Ano Lectivo de Inscrição: </b>
                                        {{ $aluno-> }} --}}
                                    </p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach


            </tbody>

        </table>
    </div>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('aluno_actualizado'))
        <script>
            Swal.fire(
                ' Dados actualizados com sucesso ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('dip_actualizado'))
        <script>
            Swal.fire(
                ' Diplomados actualizados ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('error_dip_actualizado'))
        <script>
            Swal.fire(
                'Erro ao actualizar diplomandos ',
                '',
                'error'
            )
        </script>
    @endif
    <script>
        $(document).ready(function() {

            //start delete
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#confirm-delete').length) {
                    $('table').append(
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
                    );
                }
                $('#dataConfirmOk').attr('href', href);
                $('#confirm-delete').modal({
                    shown: true
                });
                return false;

            });
            //end delete
        });
    </script>

    @if (session('aluno.eliminar.success'))
        <script>
            Swal.fire(
                'Aluno Eliminado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('aluno.eliminar.error'))
        <script>
            Swal.fire(
                'Erro ao Eliminar Aluno! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('aluno.purgar.success'))
        <script>
            Swal.fire(
                'Aluno Purgado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('aluno.purgar.error'))
        <script>
            Swal.fire(
                'Erro ao Purgar Aluno! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('aluno.recuperar.success'))
        <script>
            Swal.fire(
                'Aluno Recuperado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('aluno.recuperar.error'))
        <script>
            Swal.fire(
                'Erro ao Recuperar Aluno! ',
                '',
                'error'
            )
        </script>
    @endif


    @include('admin.layouts.footer')



@endsection

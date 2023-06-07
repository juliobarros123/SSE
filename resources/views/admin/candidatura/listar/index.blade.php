@extends('layouts.admin')

@section('titulo', 'Candidato/Listar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">

            <div class="d-flex justify-content-between">
                <div class="row col-md-12">
                    <div class="col-md-10">
                        <h3>Lista de Candidatos</h3>
                    </div>
                    <!-- <div class="col-md-2">
                                                <a type="submit" href="{{ route('admin.candidatos-api.create') }}"
                                                    class="btn btn-primary">Atualizar</a>

                                                </div>-->
                </div>


            </div>
        </div>
    </div>

    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        {{-- <div class="d-flex justify-content-end mb-3">

            <a class="btn btn-dark ml-1" href="{{ route('admin.candidatos.eliminadas') }}">
                <strong class="text-light">Eliminados</strong>
            </a>


        </div> --}}
    @endif




    <div class="table-responsive">
        <table id="example" class="display table table-hover">
            <thead class="">
                <tr>
                    <th>INSCRIÇÃO Nº</th>
                    <th>NOME COMPLETO</th>
                    <th>B.I/CÉDULA</th>
                    
                    <th>IDADE</th>
                    <th>CURSO</th>
                    <th>CLASSE</th>
 
                    <th>GÊNERO</th>
                    <th>MÉDIA</th>
               
                    <th>ESTADO</th>
                    <th>ACÇÕES</th>
                </tr>
            </thead>
            <tbody class="bg-white">

                <?php foreach ($candidatos as $candidato):?>

                <tr class="">
                    <td>{{ $candidato->id }}</td>
                    <td >
                        {{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }}
                    </td>
                    <td>{{ $candidato->vc_bi }}</td>
                 
                    <td>{{ calcularIdade($candidato->dt_dataNascimento) }} anos</td>

                    <td>{{ $candidato->vc_nomeCurso }}</td>
                    <td>{{ $candidato->vc_classe }}ª Classe</td>
                  
                    <td>{{ $candidato->vc_genero }}</td>

                    <td>{{ $candidato->media }}</td>

                
                    @if (candidado_transferido($candidato->id))
                        <td class="text-green">Transferido</td>
                    @else
                        <td id="cnt{{ $candidato->id }}" class="text-danger">Não Selecionado</td>
                    @endif

                    <td>

                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item" target="_blank"
                                    href='{{ url("candidatos/$candidato->slug/imprimir_ficha") }}'>Ficha</a>
                                <a class="dropdown-item" href='{{ url("candidatos/$candidato->slug/edit") }}'>Editar</a>
                                @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                <a class="dropdown-item" href="#" type="button" data-toggle="modal"
                                data-backdrop="static"
                                data-target=".bd-example-modal-lg-{{ $candidato->id }}">Expandir</a>
                                <a class="dropdown-item" href='{{ url("candidatos/$candidato->slug/eliminar") }}'
                                        data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                @endif

                      
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                            Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                                            Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico')

                                        @if (!candidado_transferido($candidato->id))
                                            <a style="cursor: pointer;" id_candidato="{{ $candidato->id }}"
                                                class="dropdown-item cand_para_aluno">Transferir</a>
                                        @endif

                                @endif
                            </div>
                        </div>


                    </td>
                </tr>
                <div class="modal fade bd-example-modal-lg-{{ $candidato->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Nº de Inscrição: <b>{{ $candidato->id }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h5 class="text-left mb-2 ml-2"><b>Dados Pessoais</b></h5>
                                <p class="ml-4">
                                    <b>Nome Completo:
                                    </b>{{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }}<br>

                                    <b>Data de Nascimento: </b>
                                    {{ date('d-m-Y', strtotime($candidato->dt_dataNascimento)) }}<br>
                                    <b>Idade: </b>
                                    {{ calcularIdade($candidato->dt_dataNascimento)}} anos<br>

                                    <b>Nome do Pai: </b>
                                    {{ $candidato->vc_nomePai }}<br>
                                    <b>Nome da Mãe: </b>
                                    {{ $candidato->vc_nomeMae }}<br>
                                    <b>Genero: </b>
                                    {{ $candidato->vc_genero }}<br>
                                    <b>Deficiênte Físico?: </b>
                                    {{ $candidato->vc_dificiencia }}<br>
                                    <b>Estado Civil: </b>
                                    {{ $candidato->vc_estadoCivil }}<br>
                                    <b>Telefone: </b>
                                    {{ $candidato->it_telefone }}<br>
                                    <b>Email: </b>
                                    {{ $candidato->vc_email }}<br>
                                    <b>Residência: </b>
                                    {{ $candidato->vc_residencia }}<br>
                                    <b>Naturalidade: </b>
                                    {{ $candidato->vc_naturalidade }}<br>
                                    <b>Município: </b>
                                    {{ $candidato->vc_municipio }}<br>
                                    <b>Provincia: </b>
                                    {{ $candidato->vc_provincia }}<br>
                                    <b>Bilhete de Identidade Nº: </b>
                                    {{ $candidato->vc_bi }}<br>
                                    <b>Data de emissão do bilhete de Identidade: </b>
                                    {{ date('d-m-Y', strtotime($candidato->dt_emissao)) }}<br>
                                    <b>Local de emissão do Bilhete de Identidade: </b>
                                    {{ $candidato->vc_localEmissao }}<br>
                                </p>
                                {{-- <h5 class="text-left mb-2 mt-2 ml-2"><b>Dados Acadêmicos</b></h5> --}}
                                <p class="ml-4">
                                    <b>Escola Anterior: </b>
                                    {{ $candidato->vc_EscolaAnterior }}<br>

                                    <b>Ano de Conclusão: </b>
                                    {{ $candidato->ya_anoConclusao }}
                                </p>
                                {{-- <h5 class="text-left mt-2 ml-2"><b>Dados da Nova Escola</b></h5> --}}
                                <p class="ml-4">
                                    <b>Curso escolhido: </b>
                                    {{ $candidato->vc_nomeCurso }}<br>
                                    <b>Classe Inicial: </b>
                                    {{ $candidato->vc_classe}}ªClasse<br>
                                    {{-- <b>Ano Lectivo de Inscrição: </b>
                                    {{ $candidato-> }} --}}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>

                        </div>
                    </div>
                </div>
                <?php endforeach;?>


            </tbody>

        </table>
    </div>

    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
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
    @include('admin.layouts.footer')
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('up'))
        <script>
            Swal.fire(
                'Candidato transferido!',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire(
                'Candidato já foi transferido!',
                '',
                'error'
            )
        </script>
    @endif


    @if (session('candidato.eliminar.success'))
        <script>
            Swal.fire(
                'Candidato Eliminado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('candidato.eliminar.error'))
        <script>
            Swal.fire(
                'Erro ao Eliminar Candidato! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('candidato.purgar.success'))
        <script>
            Swal.fire(
                'Candidato Purgado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('candidato.purgar.error'))
        <script>
            Swal.fire(
                'Erro ao Purgar Candidato! ',
                '',
                'error'
            )
        </script>
    @endif

    @if (session('candidato.recuperar.success'))
        <script>
            Swal.fire(
                'Candidato Recuperado Com Sucesso! ',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('candidato.recuperar.error'))
        <script>
            Swal.fire(
                'Erro ao Recuperar Candidato! ',
                '',
                'error'
            )
        </script>
    @endif
@endsection

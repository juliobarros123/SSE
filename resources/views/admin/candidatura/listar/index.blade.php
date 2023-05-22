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
        <div class="d-flex justify-content-end mb-3">

            <a class="btn btn-dark ml-1" href="{{ route('admin.candidatos.eliminadas') }}">
                <strong class="text-light">Eliminados</strong>
            </a>


        </div>
    @endif




   <div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>INSCRIÇÃO Nº</th>
                <th>NOME COMPLETO</th>
                <th>BILHETE DE IDENTIDADE</th>
                @if (Auth::user()->vc_tipoUtilizador != 'Comissão')
                    <th>IDADE</th>
                @endif
                <th>CURSO</th>
                <th>VEZES CANDIDATADO</th>
                <th>DATA DE CANDIDATURA</th>
                <th>GÊNERO</th>
                @if (Auth::user()->vc_tipoUtilizador != 'Comissão')
                    <th>MÉDIA</th>
                @endif
                <th>TELEFONE</th>
                <th>ESTADO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php foreach ($candidatos as $candidato):?>
            <tr class="text-center">
                <td>{{ $candidato->id }}</td>
                <td class="text-left">
                    {{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }}
                </td>
                <td>{{ $candidato->vc_bi }}</td>
                @if (Auth::user()->vc_tipoUtilizador != 'Comissão')
                    <td>{{ date('Y') - date('Y', strtotime($candidato->dt_dataNascimento)) }} anos</td>
                @endif
                <td>{{ $candidato->vc_nomeCurso }}</td>
                <td>{{ $candidato->vc_vezesdCandidatura }}</td>
                <td>{{ date('d-m-Y', strtotime($candidato->created_at)) }}</td>
                <td>{{ $candidato->vc_genero }}</td>
                @if (Auth::user()->vc_tipoUtilizador != 'Comissão')
                    <td>{{ $candidato->media }}</td>
                @endif
                <td>{{ $candidato->it_telefone }}</td>

                @if ($candidato->state == 0)
                    <td id='ok{{ $candidato->id }}' class="text-green">Transferido</td>
                @else
                    <td id='no{{ $candidato->id }}' class="text-danger">Não Selecionado</td>
                @endif

                <td>
                    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        @if (isset($eliminadas))
                            <div class="dropdown">
                                <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a href="{{ route('admin.candidatos.recuperar', $candidato->id) }}"
                                        class="dropdown-item ">Recuperar</a>
                                    <a href="{{  url("candidatos/$candidato->id/pulgar") }}" class="dropdown-item "
                                        data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                </div>
                            </div>
                        @else
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item"
                                        href='{{ url("candidatos/$candidato->id/visualizar") }}'>Ver</a>
                                    <a class="dropdown-item" target="_blank"
                                        href='{{ url("candidatos/$candidato->id") }}'>Ficha</a>
                                    <a class="dropdown-item" href='{{ url("candidatos/$candidato->id/edit") }}'>Editar</a>
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                        <a class="dropdown-item" href='{{ url("candidatos/$candidato->id/eliminar") }}'
                                            data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>


                                        <a class="dropdown-item" href='{{ url("candidatos/$candidato->id/pulgar") }}'
                                            data-confirm="Tem certeza que deseja purgar?">Purgar</a>
                                    @endif

                                    @if ($candidato->state === 1)
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                                                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico')
                                            <a style="cursor: pointer;" codigo='{{ $candidato->id }}'
                                                id="tag<%={{ $candidato->id }}%>"
                                                class="dropdown-item p{{ $candidato->id }} candidato">transferir</a>
                                        @endif
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif


                </td>
            </tr>

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

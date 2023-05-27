@extends('layouts.admin')

@section('titulo', 'Nota/Ver')


@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">

            <h3>Visualizar Notas</h3>
            <h6>
                Ano Lectivo: {{ $titulo_anoLectivo }} <b>|</b>
                {{ $titulo_trimestre }}º Trimestre <b>|</b>
                {{ $titulo_classe }}ª Classe <b>|</b>
                Turma: {{ $titulo_turma }}
            </h6>
        </div>
    </div>




    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>NOME</th>
                <th>DISCIPLINA</th>
                <th>CLASSE</th>
                <th>MAC</th>
                <th>NOTA 1</th>
                <th>NOTA 2</th>
                <th>MÉDIA</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($notas as $nota)

                <tr class="text-center">
                    <input type="hidden" class="delete_input" value="{{ $nota->id }}">

                    <td>{{ $nota->vc_primeiroNome . ' ' . $nota->vc_nomedoMeio . ' ' . $nota->vc_ultimoaNome }}</td>
                    <td>{{ $nota->vc_nome }}</td>
                    <td>{{ $nota->it_classe }}ª classe</td>
                    @if ($nota->fl_mac <= 9)
                        <td class="text-danger">{{ $nota->fl_mac }}</td>
                    @else
                        <td class="text-primary">{{ $nota->fl_mac }}</td>
                    @endif
                    @if ($nota->fl_nota1 <= 9)
                        <td class="text-danger">{{ $nota->fl_nota1 }}</td>
                    @else
                        <td class="text-primary">{{ $nota->fl_nota1 }}</td>
                    @endif
                    @if ($nota->fl_nota2 <= 9)
                        <td class="text-danger">{{ $nota->fl_nota2 }}</td>
                    @else
                        <td class="text-primary">{{ $nota->fl_nota2 }}</td>
                    @endif
                    @if ($nota->fl_media <= 9)
                        <td class="text-danger">{{ $nota->fl_media }}</td>
                    @else
                        <td class="text-primary">{{ $nota->fl_media }}</td>
                    @endif
                    <td class="text-center">

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone " aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" type="button" data-toggle="modal" data-backdrop="static"
                                    data-target=".bd-example-modal-lg-{{ $nota->id }}">Expandir</a>
                                <a href="{{ route('admin.notas.editar.index', $nota->id) }}"
                                    class="dropdown-item ">Editar</a>
                                <a href="{{ route('admin.eliminarNota', $nota->id) }}"
                                    data-confirm="Tem certeza que deseja eliminar?" class="dropdown-item ">Eliminar</a>

                            </div>
                        </div>

                        @endif


                    </td>
                </tr>
                <!--Modal-->
                <div class="modal fade bd-example-modal-lg-{{ $nota->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Nome:
                                    <b>{{ $nota->vc_primeiroNome . ' ' . $nota->vc_nomedoMeio . ' ' . $nota->vc_ultimoaNome }}</b>
                                </h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">


                                <div class="card-body row">
                                    <div class="form-group col-md-4 ">
                                        <label for="">Nº de processo</label>
                                        <input type="text" value=" {{ $nota->it_idAluno }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Disciplina</code></label>
                                        <input type="text" value=" {{ $nota->vc_nome }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Classe</code></label>
                                        <input type="text" value=" {{ $nota->it_classe }}ªclasse"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Turma</code></label>
                                        <input type="text" value="  {{ $nota->vc_nomedaTurma }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Trimestre</code></label>
                                        <input type="text" value=" {{ $nota->vc_tipodaNota }}ºtrimestre"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Ano lectivo</code></label>
                                        <input type="text" value=" {{ $nota->vc_anolectivo }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nota 1</code></label>
                                        <input type="text" value=" {{ $nota->fl_nota1 }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="">Nota 2</code></label>
                                        <input type="text" value=" {{ $nota->fl_nota2 }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>

                                    <div class="form-group col-md-4">
                                        <label for="">Media</code></label>
                                        <input type="text" value=" {{ $nota->fl_media }}"
                                            class="form-control form-control-border " id="" readonly>
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!--Modal-->
            @endforeach
        </tbody>
    </table>

    <!-- Footer-->
    @include('admin.layouts.footer')

    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

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
@endsection

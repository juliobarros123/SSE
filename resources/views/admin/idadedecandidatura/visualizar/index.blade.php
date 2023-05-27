@extends('layouts.admin')
@section('titulo', 'Idade Candidatura/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Idades de admissão</h3>
        </div>
    </div>



    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ url('/admin/idadedecandidatura/cadastrar') }}">
            <strong class="text-light">Cadastrar Idade de Candidatura</strong>
        </a>
    </div>
@endif
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>IDADE MÍNIMA</th>
                <th>IDADE MÁXIMA</th>
                <th>ANO LECTIVO QUE SE APLICOU</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($idadesdecandidaturas as $idadedecandidatura)
                <tr>
                    <td>{{ $idadedecandidatura->id }}</td>
                    <td>{{ date('Y') - date('Y', strtotime($idadedecandidatura->dt_limiteaesquerda)) }} Anos</td>
                    <td>{{ date('Y') - date('Y', strtotime($idadedecandidatura->dt_limitemaxima)) }} Anos</td>
                    <td>{{ $idadedecandidatura->ya_inicio }}/{{ $idadedecandidatura->ya_fim }}</td>
                    <td>

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item"
                                    href="{{ route('admin/idadedecandidatura/editar', $idadedecandidatura->slug) }}">Editar
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/idadedecandidatura/eliminar', $idadedecandidatura->slug) }}"  data-confirm="Tem certeza que deseja eliminar?">Eliminar
                                </a>
                            </div>
                        </div>

                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
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

    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Idade de Candidatura cadastrada',

            })

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection


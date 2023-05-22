@extends('layouts.admin')

@section('titulo', 'Lista Coordernador|Turno')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de coordenadores de turno</h3>
        </div>
    </div>

    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')


    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ url('coordernadores_turno/criar') }}">
            <strong class="text-light">Cadastrar Coordenador de Turno</strong>
        </a>
    </div>
@endif
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>FUNCIONÁRIO</th>
                <th>TURNO</th>
                <th>ANO LECTIVO</th>
                <th>AÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach ($coordenadores_turno as $item)

                <tr class="text-center">
                    <td>{{ $item->id }}</td>
                    <th>{{ $item->vc_primemiroNome . ' ' . $item->vc_apelido }}</th>
                    <td>{{ $item->turno}}</td>
                    <td> {{ $item->ya_inicio }}-{{ $item->ya_fim}}</td>

                    <td>
                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @if (Auth::user()->vc_tipoUtilizador !='Professor')
                                    <a href="{{ route('coordernadores_turno.editar', $item->id) }}"
                                        class="dropdown-item">Editar</a>
                                    <a href="{{ route('coordernadores_turno.eliminar', ['id' => $item->id]) }}"
                                        class="dropdown-item" data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                              @endif
                                    </div>
                            </div>

                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>


<script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>
<!-- sweetalert -->
<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

@if (session('cadastrado'))
<script>
    Swal.fire(
        'Dados cadastrado com sucesso',
        '',
        'success'
    )

</script>
@endif
@if (session('actualizado'))
<script>
    Swal.fire(
        'Dados actualizado com sucesso',
        '',
        'success'
    )

</script>
@endif
@if (session('existe'))
<script>
    Swal.fire(
        'Dados já existem',
        '',
        'error'
    )

</script>
@endif


@if (session('eliminado'))
<script>
    Swal.fire(
        'Dados eliminado com sucesso',
        '',
        'success'
    )

</script>
@endif

@if (session('error'))
<script>
    Swal.fire(
        'Houve algum  erro',
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
                    '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende elimInar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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
<!-- Footer-->
@include('admin.layouts.footer')

@endsection

@extends('layouts.admin')
@section('titulo', 'Ano Lectivo/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Anos Lectivos</h3>
        </div>
    </div>


    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ url('/admin/anolectivo/cadastrar') }}">
            <strong class="text-light">Cadastrar Ano Lectivo</strong>
        </a>

        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
                <a class="btn btn-dark ml-1" href="{{route('admin.anolectivo.eliminadas')}}">
                    <strong class="text-light">Eliminados</strong>
                </a>
    
        @endif
    </div>
@endif

<div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>INICIO</th>
                <th>FIM</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($anoslectivos as $anolectivo)
                <tr>
                    @if(isset($id_anoLectivo_publicado) && $anolectivo->id==$id_anoLectivo_publicado)
                    <td style="color: green">{{ $anolectivo->id }}</td>
                    <td style="color: green">{{ $anolectivo->ya_inicio }}</td>
                    <td style="color: green">{{ $anolectivo->ya_fim }}</td>
                    @else
                    <td>{{ $anolectivo->id }}</td>
                    <td>{{ $anolectivo->ya_inicio }}</td>
                    <td>{{ $anolectivo->ya_fim }}</td>
                    @endif
                    <td>


                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')

                        @if (isset($eliminadas))
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.anolectivo.recuperar', $anolectivo->id) }}"
                                    class="dropdown-item ">Recuperar</a>
                                <a href="{{ route('admin.anolectivo.purgar', $anolectivo->id) }}"
                                    class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
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
                                    href="{{ route('admin/anolectivo/editar', $anolectivo->id) }}">Editar </a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/anolectivo/visualizar', $anolectivo->id) }}">Visualizar</a>

                                    @if(isset($id_anoLectivo_publicado) && $anolectivo->id==$id_anoLectivo_publicado)
                                    <a class="dropdown-item"
                                    href="{{ route('admin.configurar.ano_lectivo.ocultar',$anolectivo->id) }}"  >Ocultar</a>
                                    @else
                                    <a class="dropdown-item"
                                    href="{{ route('admin.configurar.ano_lectivo.disponibilizar',$anolectivo->id) }}"  >Disponibilizar</a>
                                    @endif
                                    <a class="dropdown-item"
                                    href="{{ route('admin/anolectivo/eliminar', $anolectivo->id) }}"  data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>

                                    <a href="{{ route('admin.anolectivo.purgar', $anolectivo->id) }}"
                                        class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                                    
                            </div>
                        </div>
                        @endif
                        @endif

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>
     <!-- sweetalert -->
   <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
 @if (session('status'))
        <script>
            Swal.fire(
                'Ano lectivo inserido ',
                '',
                'success'
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
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende elimnar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
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



@if (session('anolectivo.eliminar.success'))
<script>
    Swal.fire(
        'Ano Lectivo Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('anolectivo.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Ano Lectivo! ',
        '',
        'error'
    )
</script>
@endif

@if (session('anolectivo.purgar.success'))
<script>
    Swal.fire(
        'Ano Lectivo Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('anolectivo.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Ano Lectivo! ',
        '',
        'error'
    )
</script>
@endif

@if (session('anolectivo.recuperar.success'))
<script>
    Swal.fire(
        'Ano Lectivo Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('anolectivo.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Ano Lectivo! ',
        '',
        'error'
    )
</script>
@endif
    @include('admin.layouts.footer')

 @endsection

@extends('layouts.admin')

@section('titulo', 'Disciplinas relacionadas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Listar Disciplinas relacionadas</h3>
        </div>
    </div>


    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')


    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ route('admin.disciplina_curso_classe.create') }}">
            <strong class="text-light">Relacionar Disciplina</strong>
        </a>

        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
        Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
        Auth::user()->vc_tipoUtilizador == 'Preparador')
       

            <a class="btn btn-dark ml-1" href="{{route('admin.disciplina_curso_classe.eliminadas')}}">
                <strong class="text-light">Eliminados</strong>
            </a>

    @endif
    </div>
@endif
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>DISCIPLINA</th>
                <th>NOME CURTO</th>
                <th>CURSO</th>
                <th>CLASSE</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach ($respostas as $row)
                <tr class="text-center">
                    <td>{{ $row->id }}</td>
                    <td>{{ $row->vc_nome }}</td>
                    <td>{{ $row->vc_acronimo }}</td>
                    <td>{{ $row->vc_nomeCurso }}</td>
                    <td>{{ $row->vc_classe }}ª Classe</td>

                    <td class="text-center">

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')

                        @if (isset($eliminadas))
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.disciplina_curso_classe.recuperar', $row->id) }}"
                                    class="dropdown-item ">Recuperar</a>
                                <a href="{{ route('admin.disciplina_curso_classe.purgar', $row->id) }}"
                                    class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                            </div>
                        </div>
                         @else
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone " aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.disciplina_curso_classe.edit', $row->id) }}"
                                    class="dropdown-item ">Editar</a>
                                <a href="{{ route('admin.disciplina_curso_classe.destroy', $row->id) }}" class="dropdown-item"
                                    data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>
                                
                                    <a href="{{ route('admin.disciplina_curso_classe.purgar', $row->id) }}"
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


    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Disciplina inserida ',
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
@if (session('disciplina_curso_classe.eliminar.success'))
<script>
    Swal.fire(
        'Relacionamento Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('disciplina_curso_classe.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Relacionamento! ',
        '',
        'error'
    )
</script>
@endif

@if (session('disciplina_curso_classe.purgar.success'))
<script>
    Swal.fire(
        'Relacionamento Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('disciplina_curso_classe.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Relacionamento! ',
        '',
        'error'
    )
</script>
@endif

@if (session('disciplina_curso_classe.recuperar.success'))
<script>
    Swal.fire(
        'Relacionamento Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('disciplina_curso_classe.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Relacionamento! ',
        '',
        'error'
    )
</script>
@endif
    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection

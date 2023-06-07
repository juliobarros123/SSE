@extends('layouts.admin')

@section('titulo', 'Meus Directores de turmas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Meus Directores de turmas</h3>
        </div>
    </div>





    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>PROFESSOR</th>
                <th>TURMA</th>
                <th>TURNO</th>
                <th>CURSO</th>
                <th>CLASSE</th>
            
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($directores)
                @foreach ($directores as $dt)
                {{-- @dump($dt) --}}
                    <tr class="text-center">
                        <th>{{ $dt->id }}</th>
                        <th>{{ $dt->director }}</th>
                        <td>{{ $dt->turma }}</td>
                        <td>{{ $dt->turno }}</td>
                 
                        <td>{{ $dt->curso }}</td>
                        <td>{{ $dt->classe }}ª classe</td>
                     
                     
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
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
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

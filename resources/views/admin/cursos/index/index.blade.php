@extends('layouts.admin')

@section('titulo', 'Curso/Listar')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de curso</h3>
        </div>
    </div>



    @if (session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('Admin/cursos/create/index') }}">
                <strong class="text-light">Cadastrar Curso</strong>
            </a>
            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Coordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
           
    
              
    
        @endif
        </div>
    @endif
    <div class="responsive-table">
        <table id="example" class="display table table-hover">
               <thead class="">
            <tr>

                <th>ID</th>
                <th>CURSO</th>
                <th>FORMA CURTA</th>
                <th>DESCRIÇÃO</th>
           
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($cursos as $curso)
                <tr>

                    <td>{{ $curso->id }}</td>
                    <td>{{ $curso->vc_nomeCurso }}</td>
                    <td>{{ $curso->vc_shortName }}</td>
                    <td>{{ $curso->vc_descricaodoCurso }}</td>
                
                    <td>

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')

                            <div class="dropdown">
                                <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-clone" aria-hidden="true"></i>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                   
                                    <a class="dropdown-item"
                                        href="{{ url('Admin/cursos/edit/index', $curso->slug) }}">@lang('Editar')
                                    </a>
                                    <a class="dropdown-item"
                                        href="{{ route('cursos.destroy', $curso->slug) }}">@lang('Eliminar')
                                    </a>
                             

                                </div>
                            </div>
                      
                        @endif

                    </td>
                </tr>


          
            @endforeach


        </tbody>

    </table>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Dados de Curso adicionado ',
                '',
                'success'
            )
        </script>
    @endif




@if (session('curso.eliminar.success'))
<script>
    Swal.fire(
        'Curso Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Curso! ',
        '',
        'error'
    )
</script>
@endif

@if (session('curso.purgar.success'))
<script>
    Swal.fire(
        'Curso Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Curso! ',
        '',
        'error'
    )
</script>
@endif

@if (session('curso.recuperar.success'))
<script>
    Swal.fire(
        'Curso Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('curso.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Curso! ',
        '',
        'error'
    )
</script>
@endif


    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection

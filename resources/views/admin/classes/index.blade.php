@extends('layouts.admin')
@section('titulo', 'Classe/Listar')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de classes</h3>
        </div>
    </div>




    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Coordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            <a class="btn btn-dark" href="{{ url('/admin/classes/cadastrar') }}">
                <strong class="text-light">Cadastrar Classe</strong>
            </a>

          
        </div>
    @endif
    <div class="responsive-table">
        <table id="example" class="display table table-hover">
               <thead class="">
                <tr class="text-center">
                    <th>ID</th>
                    <th>CLASSE</th>

                    <th>ACÇÕES</th>
                </tr>
            </thead>
            <tbody class="bg-white">

          
                    @foreach ($classes as $classe)
                        <tr class="text-center">
                            <td>{{ $classe->id }}</td>
                            <td>{{ $classe->vc_classe }}ªclasse</td>
                          
                            <td>

                                @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                   
                                        <div class="dropdown">
                                            <button class="btn btn-dark dropdown-toggle" type="button"
                                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                <i class="fa fa-clone" aria-hidden="true"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                                <a class="dropdown-item"
                                                    href="{{ route('admin/classes/editar', $classe->slug) }}">Editar </a>
                                              
                                                <a class="dropdown-item"
                                                    href="{{ route('admin/classes/eliminar', $classe->slug) }}"
                                                    data-confirm="Tem certeza que deseja eliminar?">Eliminar </a>

                                            </div>
                                        </div>
                               
                                @endif

                            </td>
                        </tr>
                    @endforeach
                
            </tbody>
        </table>
    </div>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>
    <!-- sweetalert -->
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

  
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

@extends('layouts.admin')
@section('titulo', 'Escola/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Escolas</h3>
        </div>
    </div>


    @if (acc_admin_desenvolvedor())
   
    <div class="d-flex justify-content-end mb-3">
        <a class="btn btn-dark" href="{{ url('admin/escola/cadastrar') }}">
            <strong class="text-light">Cadastrar</strong>
        </a>
       
    </div>
@endif

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>ESCOLA</th>
                <th>ACRONIMO</th>
                <th>DIRECTOR(A)</th>
                <th>EMAIL</th>
                <th>TELEFONE</th>
                <th>NIF</th>
                <th>MUNICIPIO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white text-center">
            @foreach ($cabecalhos as $cabecalho)
                <tr>
                    <td>{{ $cabecalho->id }}</td>
                    <td>{{ $cabecalho->vc_escola }}</td>
                    <td>{{ $cabecalho->vc_acronimo }}</td>
                    <td>{{ $cabecalho->vc_nomeDirector }}</td>
                    <td>{{ $cabecalho->vc_email }}</td>
                    <td>{{ $cabecalho->it_telefone }}</td>
                    <td>{{ $cabecalho->vc_nif }}</td>
                    <td>{{ $cabecalho->vc_nomeMunicipio }}</td>
                    <td>

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                <a class="dropdown-item" href="{{ route('admin/escola/editar', $cabecalho->id) }}">Editar
                                </a>
                                <a class="dropdown-item"
                                    href="{{ route('admin/escola/visualizar', $cabecalho->id) }}">Visualizar
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

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('update'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Escola editada com sucesso',
            })

        </script>
    @endif
    @include('admin.layouts.footer')

@endsection


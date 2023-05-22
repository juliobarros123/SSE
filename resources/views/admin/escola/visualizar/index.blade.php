@extends('layouts.admin')
@section('titulo', 'Escola/Ver')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Escola <b>{{ $cabecalho->vc_escola }}</b></h3>
        </div>
    </div>




    <table id="example" class="display table table-hover table-responsive">
           <thead class="">
            <tr>
                <th>ID</th>
                <th>ESCOLA</th>
                <th>ACRONIMO</th>
                <th>DIRECTOR(A)</th>
                <th>DIRECTOR(A) PEDAGÓGICO</th>
                <th>DIRECTOR(A) ADMIN.FINANCEIRA</th>
                <th>MINISTÉRIO</th>
                <th>REPÚBLICA</th>
                <th>EMAIL</th>
                <th>TELEFONE</th>
                <th>NIF</th>
                <th>ENDEREÇO</th>
                <th>MUNICIPIO</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE ACTUALIZAÇÃO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr>
                <td>{{ $cabecalho->id }}</td>
                <td>{{ $cabecalho->vc_escola }}</td>
                <td>{{ $cabecalho->vc_acronimo }}</td>
                <td>{{ $cabecalho->vc_nomeDirector }}</td>
                <td>{{ $cabecalho->vc_nomeSubdirectorPedagogico}}</td>
                <td>{{ $cabecalho->vc_nomeSubdirectorAdminFinanceiro}}</td>
                <td>{{ $cabecalho->vc_ministerio }}</td>
                <td>{{ $cabecalho->vc_republica }}</td>
                <td>{{ $cabecalho->vc_email }}</td>
                <td>{{ $cabecalho->it_telefone }}</td>
                <td>{{ $cabecalho->vc_nif }}</td>
                <td>{{ $cabecalho->vc_endereco }}</td>
                <td>{{ $cabecalho->vc_nomeMunicipio }}</td>
                <td>{{ $cabecalho->created_at }}</td>
                <td>{{ $cabecalho->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    @include('admin.layouts.footer')

@endsection


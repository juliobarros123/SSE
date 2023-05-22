@extends('layouts.admin')
@section('titulo', 'Municipio/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Municipio <b>{{ $municipio->vc_nome }}</b></h3>
        </div>
    </div>

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>PROVÍNCIA</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE ACTUALIZAÇÃO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr>
                <td>{{ $municipio->id }}</td>
                <td>{{ $municipio->vc_nome }}</td>
                <td>{{ $municipio->vc_nomeProvincia }}</td>
                <td>{{ $municipio->created_at }}</td>
                <td>{{ $municipio->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    @include('admin.layouts.footer')

@endsection


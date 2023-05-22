@extends('layouts.admin')
@section('titulo', 'Província/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Província <b>{{ $provincia->name }}</b></h3>
        </div>
    </div>

    <table id="example" class="display table table-hover">
           <thead class="">
            <tr>
                <th>ID</th>
                <th>NOME</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE ACTUALIZAÇÃO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr>
                <td>{{ $provincia->id }}</td>
                <td>{{ $provincia->vc_nome }}</td>
                <td>{{ $provincia->created_at }}</td>
                <td>{{ $provincia->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    @include('admin.layouts.footer')

@endsection


@extends('layouts.admin')
@section('titulo', 'Classe/Listar')
 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar <b>{{ $classes->vc_classe }}ªclasse</b></h3>
        </div>
    </div>

 


    <table id="example" class="display table table-hover">
           <thead class="">
            <tr>
                <th>ID</th>
                <th>CLASSE</th>
                <th>DATA DE REGISTRO</th>
                <th>DATA DE ACTUALIZAÇÃO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <tr>
                <td>{{ $classes->id }}</td>
                <td>{{ $classes->vc_classe }}ªclasse</td>
                <td>{{ $classes->created_at }}</td>
                <td>{{ $classes->updated_at }}</td>
            </tr>
        </tbody>
    </table>
    
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection


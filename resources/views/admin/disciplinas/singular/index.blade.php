@extends('layouts.admin')

@section('titulo', 'Disciplina')


@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Disciplinas do Curso de {{ $cursos->vc_nomeCurso }}</h3>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <a href="{{ url('disciplina/ver') }}">Voltar</a>/{{ $cursos->vc_nomeCurso }}
        </div>
    </div>





    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>DISCIPLINA</th>
                <th>NOME CURTO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($disciplinas as $disciplina)
                <tr class="text-center">
                    <td>{{ $disciplina->vc_nome }}</td>
                    <td>{{ $disciplina->vc_acronimo }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

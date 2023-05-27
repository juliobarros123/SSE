@extends('layouts.admin')

@section('titulo', 'Alunos/Editar')

@section('conteudo')
<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('editarAluno'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados Editados com Sucesso!',
        })
    </script>
@endif
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar dados do candidato selecionado</h3>
        </div>
    </div>





    <div class="card">
        <div class="card-body">
            <div>
            <img src="{{asset('confirmados/'.$aluno->foto)}}" class="img-fluid shadow-lg mb-3 border-1 rounded" style="max-width: 200px;min-width: 200px;max-height: 210px;min-height: 210px;" width="300px" alt="">
            </div>
            <form action="{{ route('aluno.update', $aluno->id) }}" method="post" class="row" enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formAluno.index')
                <div class="col-sm-12 mt-2 text-center">
                    <input type="submit" class=" col-sm-3 btn btn-success" value="Editar">
                </div>
            </form>
        </div>
    </div>

@include('admin.layouts.footer')

 @endsection

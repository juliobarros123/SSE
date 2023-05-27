@extends('layouts.admin')

@section('titulo', 'Alunos/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar dados do candidato selecionado</h3>
        </div>
    </div>





    <div class="card">
        <div class="card-body">
            <form action="{{ route('selecionado.update', $aluno->id) }}" method="post" class="row">
                @method('put')
                @csrf
                @include('forms._formselecionado.index')
                <div class="col-sm-12 mt-2 text-center">
                    <input type="submit" class=" col-sm-3 btn btn-success" value="Editar">
                </div>
            </form>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('up'))
        <script>
            Swal.fire(
                'Dados actualizado com sucesso!',
                '',
                'success'
            )

        </script>
    @endif
@include('admin.layouts.footer')

 @endsection

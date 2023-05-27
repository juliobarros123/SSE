@extends('layouts.admin')

@section('titulo', 'Actualizar Salário')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Actualizar Salário do Funcionário</h3>
        </div>
    </div>


    <div class="card">
        <div class="card-body">
            <form method="post" form action="{{ route('editarFolhaSalarioFuncionario', $funcionario->id) }}"  class="row">
                @method('post')
                @csrf
                @include('forms._formFolha_salario_funcionario.index')
                <div class="col-md-12 py-1  text-center  d-flex justify-content-left">
                    <input type="submit" class="col-md-2 btn btn-dark" value="Editar">
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Dados Actualizados com sucesso',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao actualizar os dados!',
                '',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

@extends('layouts.admin')

@section('titulo', 'Funcionário(a)/Cadastrar')

 @section('conteudo')
<div class="card mt-3">
    <div class="card-body">
        <h3>Cadastrar dados do(a) Funcionário(a)</h3>
    </div>
</div>




    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ url('admin/funcionario/cadastrar') }}" class="row" method="POST" enctype="multipart/form-data">
                @csrf
                @include('forms._formFuncionario.index')
                <div class="col-md-12 text-center mt-4">
                    <button class="btn btn-success col-md-3 form-control" type="submit">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>

    @include('admin.layouts.footer')
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Funcionario(a) Cadastrado(a)',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                ' Falha ao Cadastrar Funcionario(a)',
                'A fotografia é obrigatória',
                'error'
            )

        </script>
    @endif
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('funcionario'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Funcionário(a) Inexistente',
        })
    </script>
@endif

@endsection



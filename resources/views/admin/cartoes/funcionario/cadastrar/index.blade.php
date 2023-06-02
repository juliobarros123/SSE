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
            
                <div class="form-group col-sm-12 d-flex justify-content-center mt-2">
                       
                    <button class="form-control btn btn-dark w-25">Cadastrar</button>
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



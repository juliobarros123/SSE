@extends('layouts.admin')

@section('titulo', 'Gerar Folha de Sálario Mensal Dos Formadors')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h2>Gerar Folha de Sálario Mensal Dos Formadors</h2>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('teste'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Folha Inexistente',
        })
    </script>
@endif


    <div class="card">
        <div class="card-body">
            <form action="{{ route('cadastrarFolhaSalarioFormador')}}" method="post" class="row">
                @csrf

                @include('forms._formFolha_salario_formador.index')

                <div class=" col-md-12 text-center d-flex justify-content-left ">
                    <button type="submit" class=" col-md-2 text-center btn btn-dark"> Gerar</button>
                </div>

            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Curso Cadastrado',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao Gerar Folha de Sálario Mensal Dos Formadors!',
                'Email existente ou senhas diferentes ',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

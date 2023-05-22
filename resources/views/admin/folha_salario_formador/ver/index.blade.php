@extends('layouts.admin')

@section('titulo', 'Ver Folha de Sálario Formador')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h2>Ver Folha de Sálario Formador</h2>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('teste'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Folha de Sálario Inexistente',
        })
    </script>
@endif


    <div class="card">
        <div class="card-body">
            <form action="{{route('listarFolhaSalarioFormador')}}" method="post" class="row">
                @csrf

                @include('forms._formFolha_salario_formador.index')

                <div class=" col-md-12 text-center d-flex justify-content-left ">
                    <button type="submit" class=" col-md-2 text-center btn btn-dark"> Ver Folha</button>
                </div>
                <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao Ver Folha de Sálario Formador!',
                'Email existente ou senhas diferentes ',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

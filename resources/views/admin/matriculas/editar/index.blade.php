@extends('layouts.admin')

@section('titulo', 'Matrícula/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Matrícula</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('editMatricula'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados Editados com Sucesso!',
        })
    </script>
@endif
    <div class="card">
        <div class="card-body">
            <form form action="{{ route('admin.matriculas.atualizar', $matricula->id) }}" method="post" class="row"
                enctype="multipart/form-data">
                @method('put')
                @csrf
                @include('forms._formMatricula.index')
                <div class="col-md-5 py-1  text-center ">
                    <input type="submit" class="col-sm-6 btn btn-dark" value="Confirmar alterações">
                </div>
            </form>
        </div>
    </div>
     <!-- sweetalert -->
     <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
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


@extends('layouts.admin')

@section('titulo', 'Editar Coordernador|Curso')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Coodernador do Curso</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('classe'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'A classe já Existe',
        })
    </script>
@endif



    <div class="card">
        <div class="card-body">


            <form action="{{ route('coordernadores_cursos.actualizar',$id_coord_curso) }}" method="post" class="row">
                @csrf
                @method('PUT')
                @include('forms._formCoordenador_curso.index')
                <div class="form-group col-sm-4">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Efectuar edição</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


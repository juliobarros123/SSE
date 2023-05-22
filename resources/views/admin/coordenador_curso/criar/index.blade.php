@extends('layouts.admin')

@section('titulo', 'Cadastrar Coordernador|Curso')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Coodernador do Curso</h3>
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


            <form action="{{ route('coordernadores_cursos.cadastrar') }}" method="post" class="row">
                @csrf
                @include('forms._formCoordenador_curso.index')
                <div class="form-group col-sm-4">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


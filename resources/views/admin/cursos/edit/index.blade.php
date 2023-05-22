@extends('layouts.admin')

@section('titulo', 'Curso/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Editar Curso de <b>{{ $curso->vc_nomeCurso }}</b></h3>
        </div>
    </div>


    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('curso'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'O curso já existe ',
            })
        </script>
    @endif


    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ url('/Admin/cursos/update', $curso->id) }}" class="row">
                @csrf
                @method('PUT')
                @include('forms._formCursos.edit')
                <div class="form-group col-md-3">
                    <label class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark" type="submit">Salvar
                        Alterações</button>
                </div>

            </form>
        </div>
    </div>


<!-- Footer-->
@include('admin.layouts.footer')


@endsection


@extends('layouts.admin')

@section('titulo', 'Disciplina/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Disciplinas</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('disciplina'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Disciplina já existe',
            })

        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('admin.disciplinas.editar.index', $disciplina->slug) }}" method="POST">
                @method('PUT')
                @csrf
            
                @include('forms._formDisciplina.index')
                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn btn-dark w-25 ">Editar</button>
                </div>

            </form>
        </div>
    </div>

<!-- Footer-->
@include('admin.layouts.footer')
@endsection




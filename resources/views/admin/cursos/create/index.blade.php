@extends('layouts.admin')

@section('titulo', 'curso/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar novo Curso</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('curso.existe'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'O curso já existe ',
            })
        </script>
    @endif

    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ url('Admin/cursos/store') }}" class="row">
                @csrf
                @include('forms._formCursos.create')
                <div class="form-group col-md-4">
                    <label class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark" title="@lang('Cadastrar')" type="submit">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>

 <!-- Footer-->

 @include('admin.layouts.footer')
@endsection


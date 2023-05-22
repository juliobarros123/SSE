@extends('layouts.admin')

@section('titulo', 'Disciplina/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Disciplina</h3>
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
            <form action="{{ route('admin.disciplinas.cadastrar.index') }}" method="POST" class="row">
                @csrf

                @include('forms._formDisciplina.index')
                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control  btn btn-dark">Cadastrar</button>

                </div>
            </form>
        </div>
    </div>


    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection

@extends('layouts.admin')

@section('titulo', 'Editar componente disciplina')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar componente disciplina</h3>
        </div>
    </div>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>


    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ route('admin.documentos.componentes-disciplinas.actualizar', $componente_disciplina->slug) }}" class="row">
                @csrf
                @method('PUT')
                @include('forms._form_componente_disciplina.index')


                <div class="d-flex justify-content-center col-sm-12 ">
                    <button class="form-control w-25 btn btn-dark" title="@lang('Actualizar')"
                        type="submit">Actualizar</button>
                </div>



            </form>
        </div>
    </div>

    <!-- Footer-->

    @include('admin.layouts.footer')
@endsection

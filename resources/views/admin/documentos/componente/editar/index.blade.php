@extends('layouts.admin')

@section('titulo', 'Editar componente')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar componente</h3>
        </div>
    </div>
    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>


    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ route('admin.documentos.componentes.actualizar', $componente->id) }}" class="row">
                @csrf
                @method('PUT')
                @include('forms._form_componente.index')


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

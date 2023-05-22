@extends('layouts.admin')

@section('titulo', 'Criar coordenador de turno')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>editar coordenador de turno</h3>
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


            <form method="POST" action="{{ url('coordernadores_turno/actualizar',$coordenador_turno->id) }}" class="row">
                @csrf
               @method('PUT')
                @include('forms._form_coordenador_turno.index')

                  <div class="d-flex justify-content-center col-sm-12 ">
                    <button class="form-control w-25 btn btn-dark" title="@lang('Actualizar')" type="submit">Actualizar</button>
                      </div>



            </form>
        </div>
    </div>

 <!-- Footer-->

 @include('admin.layouts.footer')
@endsection


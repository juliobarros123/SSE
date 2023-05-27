@extends('layouts.admin')

@section('titulo', 'Editar Disciplina Terminal')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Disciplina Terminal</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('DTEdit'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Disciplina terminal editada com sucesso',
            })

        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ route('admin.disciplinaTerminal.editar.put', $dt->id) }}" method="POST">

                @csrf
                @method('PUT')
                <div class="form-group col-md-1">
                    <input class="form-control border-secondary" name="id"
                        value="{{ isset($dt->id) ? $dt->id : '' }}" id="id" disabled />
                </div>
                @include('forms._formDisciplinaTerminal.index')

                <div class="form-group col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Editar</button>
                </div>

            </form>
        </div>
    </div>

<!-- Footer-->
@include('admin.layouts.footer')
@endsection




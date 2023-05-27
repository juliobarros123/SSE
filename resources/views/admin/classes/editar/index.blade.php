@extends('layouts.admin')

@section('titulo', 'Classe/Editar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar <b>{{ $classe->vc_classe }}ªclasse</b></h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('classe'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'A classe Já Existe',
        })
    </script>
@endif

    <div class="card">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <form action=" {{ route('admin/classes/atualizar', $classe->slug) }}" method="post" class="row">
                @csrf
                @method('PUT')

                <div class="form-group col-sm-2">
                    <label for="" class="form-label">ID Classe</label>
                    <input type="text" class="form-control" value="{{ isset($classe->id) ? $classe->id : '' }}" disabled>
                </div>

                @include('forms._formClasse.index')
                <div class="form-group col-sm-2">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Editar</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


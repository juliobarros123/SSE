
@extends('layouts.admin')

@section('titulo', 'Declaração/Criar')

 @section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3> Criar Declarações</h3>
        </div>

        <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
        @if (session('declaracao'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Declaração Inexixtente',
            })
        </script>
    @endif
    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{route('cadastrar')}}" class="row">
                @csrf
                @include('forms._formDeclaracoesSemNota.criar.index',$classes)
                <div class="form-group col-md-4">
                    <label class="form-label text-white"></label>
                    <button class="form-control btn btn-dark" title="@lang('Criar declaração')" type="submit">Criar declaração</button>
                </div>
            </form>
        </div>
    </div>

<!-- Footer-->
    @include('admin.layouts.footer')

@endsection

@extends('layouts.admin')

@section('titulo', 'Permissao/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Permissão de selecão</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('dado'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Permissão já existe',
            })
        </script>
    @endif

    <div class="card">
        <div class="card-body">
            <form class="row" action="{{ url('/admin/permissao_selecao/update', $dado->id) }}" method="POST">
                @method('PUT')
                @csrf
                @include('forms._formPermissaoSelecao.index')

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

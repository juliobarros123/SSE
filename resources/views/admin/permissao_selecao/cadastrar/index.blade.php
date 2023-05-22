@extends('layouts.admin')

@section('titulo', 'Permissao/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar nota e idade para Candidatura</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Permissão cadastrada com sucesso',
            })
        </script>
    @endif



    <div class="card">
        <div class="card-body">
            <form action="{{ route('permissao_selecao.cadastrar') }}" method="POST" class="row">
                @csrf
                @include('forms._formPermissaoSelecao.index')
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

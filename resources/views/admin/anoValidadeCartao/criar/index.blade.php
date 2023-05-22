@extends('layouts.admin')

@section('titulo', 'Cadastrar  ano de validade de cartão')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar  ano de validade de cartão</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>


    <div class="card">
        <div class="card-body">
            <form form action="{{ route('anos-validade-cartao.cadastrar') }}" method="post" class="row">
                @csrf

                @include('forms._form_anoValidadeCartao.index')

                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Atribuir">
                </div>
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Turma atribuida com sucesso',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao atrtibuir turma!',
                '',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

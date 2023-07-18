@extends('layouts.admin')

@section('titulo', 'Configurar cadeado de pautas')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Configurar cadeado de pautas</h3>
        </div>
    </div>
    <script src="/js/sweetalert2.all.min.js"></script>
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


            <form method="POST" action="{{ route('admin.cadeado-pautas.cadastrar') }}" class="row">
                @csrf
                @include('forms._formCadeado-pauta.index')
                <<div class="form-group col-md-12 d-flex justify-content-center ">

                    <button class="form-control btn btn-dark col-md-4" title="@lang('Cadastrar')"
                        type="submit">Cadastrar</button>
        </div>


        </form>
    </div>
    </div>

    <!-- Footer-->
    <script src="/js/sweetalert2.all.min.js"></script>
    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Configuração realizada com sucesso',
            })
        </script>
    @endif
    @include('admin.layouts.footer')
@endsection

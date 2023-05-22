@extends('layouts.admin')

@section('titulo', 'Cadastrar Entrada')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h2>Cadastrar Entrada</h2>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('teste'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Entrada Inexistente',
        })
    </script>
@endif


    <div class="card">
        <div class="card-body">
            <form action="{{ route('cadastrarCredito')}}" method="post" class="row">
                @csrf

                @include('forms._formCredito.index')

                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control  btn btn-dark">Cadastrar</button>

                </div>
                {{-- <div class="form-group row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Register') }}
                        </button>
                    </div>
                </div> --}}
            </form>
        </div>
    </div>
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire(
                'Entrada Cadastrado',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao cadastrar Entrada!',
                'Email existente ou senhas diferentes ',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection

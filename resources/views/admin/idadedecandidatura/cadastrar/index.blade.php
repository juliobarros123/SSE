@extends('layouts.admin')

@section('titulo', 'Idade Candidatura/Cadastrar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Idade de Candidatura</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('idade'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Idade de Candidatura Inexistente',
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

            <form action="{{ route('admin/idadedecandidatura/cadastrar') }}" method="post" class="row">
                @csrf
                @include('forms._formIdadedeCandidatura.index')
                <div class="form-group col-sm-3">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
    @if (session('aviso'))
        <script>
            Swal.fire(
                'Falha ao inserir a idade de candidatura !',
                'idade mínima tem que ser menor que a idade máxima',
                'error'
            )

        </script>
    @endif
    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection


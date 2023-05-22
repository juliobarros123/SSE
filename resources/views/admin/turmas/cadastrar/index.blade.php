@extends('layouts.admin')

@section('titulo', 'Turma/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Turma</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('turma'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'A Turma Já Existe',
        })
    </script>
    @endif

    @if (session('status'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Turma cadastrada com sucesso',
        })
    </script>
    @endif

    <div class="card">
        <div class="card-body">


            @if ($errors->any())
                <div class="alert alert-warning ml-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ url('/turmas/efectuarCadastroDaTurmas') }}" accept-charset="UTF-8" class="row">
                @csrf
                @include('forms._formTurma.index')
                <div class="form-group col-md-3">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark form-control" type="submit">Cadastrar</button>
                </div>
            </form>
        </div>
    </div>


    <!-- Footer-->
    @include('admin.layouts.footer')

@endsection



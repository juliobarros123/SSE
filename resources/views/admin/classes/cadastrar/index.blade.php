@extends('layouts.admin')

@section('titulo', 'Classe/Cadastrar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar classe</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('classe'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'A classe já Existe',
        })
    </script>
@endif



    <div class="card">
        <div class="card-body">


            <form action="{{ route('admin/classes/cadastrar') }}" method="post" class="row">
                @csrf
                @include('forms._formClasse.index')
                <div class="form-group col-sm-4">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection


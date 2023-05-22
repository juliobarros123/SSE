@extends('layouts.admin')

@section('titulo', 'Cadastrar caminho')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar caminho</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
 



    <div class="card">
        <div class="card-body">


            <form action="{{ route('caminho-files.cadastrar') }}" method="post" class="row">
                @csrf
                @include('forms._formCaminho-file.index')
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


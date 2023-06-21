@extends('layouts.admin')
@section('titulo', 'Cadastrar Informações para o Certificado')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cadastrar Informações para o Certificado</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('teste'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Candidato Inexistente',
            })
        </script>
    @endif

    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.documentos.infos_certificado.cadastrar') }}" class="row" method="POST">
                @csrf
             
              
                @include('forms._formInfo-Certificado.index')
                

                <div class=" d-flex justify-content-center w-100">
                    <button class="form-control btn btn-dark w-25">Cadastrar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection

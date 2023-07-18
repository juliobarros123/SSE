@extends('layouts.admin')
@section('titulo', 'Candidatura/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Candidato -
                <b> {{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }}
                </b>
            </h3>
        </div>
    </div>



    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form method="POST" action="{{ url("candidatos/$candidato->slug/update") }}" accept-charset="UTF-8" class="row">
                @method('PUT')
                @csrf
                @include('site.forms._formCandidatura.index')
                <div class="form-group col-sm-12 d-flex justify-content-center">
                       
                    <button class="form-control btn btn-dark col-md-3">Editar</button>
                </div>
            </form>
        </div>
    </div>

    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Candidato actualizado com sucesso',
            })

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Candidato Não atualizado',
            })

        </script>
    @endif


    @include('admin.layouts.footer')



@endsection

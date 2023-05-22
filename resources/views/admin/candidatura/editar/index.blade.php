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
            <form method="POST" action="{{ url("candidatos/$candidato->id/update") }}" accept-charset="UTF-8" class="row">
                @method('PUT')
                @csrf
                @include('forms._formCandidato.index')
                <div class="form-group col-md-12 text-center">
                    <label for="" class="text-white form-label">.</label>
                    <button type="submit" class="form-control mt-2 col-3 btn btn-success"><i
                            class="fas fa-fw fa-check-circle"></i> Salvar Alterações</button>
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

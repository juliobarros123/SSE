@extends('layouts.admin')
@section('titulo', 'Home')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Candidato -
                <b> {{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }} </b>
            </h3>
        </div>
    </div>


 


    <div class="card">
        <div class="card-body">
            <form class="row">
                @include('forms._formCandidato.index')
                <div class="form-group col-md-12 text-center">
                    <label for="" class="text-white form-label">.</label>
                    <a href="{{url('/candidatos/pesquisar')}}" class="form-control col-2 btn btn-dark"><i class="fas fa-fw fa-arrow-alt-circle-left"></i> VOLTAR</a>
                </div>
            </form>
        </div>
    </div>

@include('admin.layouts.footer')



@endsection




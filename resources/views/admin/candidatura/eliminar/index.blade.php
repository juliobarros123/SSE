@extends('layouts.admin')
@section('titulo', 'Candidatura/Eliminar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Eliminar Candidato -
                <b> {{ $candidato->vc_primeiroNome . ' ' . $candidato->vc_nomedoMeio . ' ' . $candidato->vc_apelido }} </b>
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
            <form action="{{ url("candidatos/$candidato->id/destroy") }}" accept-charset="UTF-8" class="row">
       
                @csrf
                @include('forms._formCandidato.index')
                <div class="form-group col-md-12 text-center">
                    <label for="" class="text-white form-label">.</label>
                    <button type="submit" class="form-control mt-2 col-2 btn btn-danger"><i
                            class="fas fa-fw fa-check-circle"></i> Eliminar Candidatura</button>
                </div>
            </form>
        </div>
    </div>

   

     @include('admin.layouts.footer')
@endsection




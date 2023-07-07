
@extends('site.layouts.app')
@section('titulo', 'Alunos/Listar')
@section('conteudo')
<div class="card mb-3">
  <div class="card-body">
    <div class="card-title">Seja Bem vindo</div>
  </div>
</div>



<div class="row ">
    <div class=" mb-3 col-md-12">
        <div class="card-body">
    <div class="card-title">Disciplinas para o ano letivo atual:</div>

        </div>
      </div>
    @foreach ($disciplinas as $item)
        <div class="col-md-3">
            {{-- @dump($item) --}}
            <div class="card">

                <img src="{{asset('images/300.png')}}" alt="Disciplina 1" class="card-img-top">
                <div class="card-body">
                 
                        <p class="card-text">Disciplinas: {{$item->disciplina}}</p>
                      
                </div>
            </div>
        </div>
    @endforeach

</div>

@endsection

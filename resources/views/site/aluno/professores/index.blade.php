@extends('site.layouts.app')
@section('titulo', 'Professores')
@section('conteudo')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">Professores </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form form action="{{ route('painel.alunos.professores') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex">


                    <div class="form-group col-md-12">
                        <label for="vc_anolectivo" class="form-label">Selecciona a Turma:</label>


                        <select name="id_turma" id="id_turma" class="form-control" required>
                            <option value="">Selecciona a Turma</option>
                            @foreach ($turmas as $turma)
                                <option value="{{ $turma->it_idTurma }}">
                                    {{ $turma->vc_nomedaTurma }}/{{ $turma->vc_classe }}ª
                                    Classe/{{ $turma->ya_inicio . '-' . $turma->ya_fim }}
                                </option>
                            @endforeach
                        </select>



                    </div>


                </div>
                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn-sm btn-dark pl-4 pr-4 ">Ver</button>
                </div>
            </form>
        </div>
    </div>
    @isset($professores)



    <div class="row ">
        @foreach ($professores as $item)
            <div class="col-md-3">
                {{-- @dump($item) --}}
                <div class="card">
                    <img src="{{asset('images/user.png')}}" alt="Professor 1" class="card-img-top" style="height: 300px;">
                    <div class="card-body">
                        
                        <h5 class="card-title">Nome:{{$item->vc_primemiroNome . ' ' . $item->vc_apelido }}</h5>
                        <p class="card-text mb-0">Turma:{{$item->vc_nomedaTurma }}</p>
                            <p class="card-text">Disciplinas: {{$item->disciplina}}</p>
                          
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    @endisset
@endsection

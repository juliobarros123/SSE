<div class="col-md-12">
    <div class="card " id="card_aluno"style="width: 18rem;">
        @isset($matricula)
            <img class="card-img-top" src="{{ asset($matricula->vc_imagem) }}" alt="Card image cap">
            <div class="card-body">
                <h5 class="card-title">Nome:{{ $matricula->vc_primeiroNome }}
                    {{ $matricula->vc_nomedoMeio }} {{ $matricula->vc_apelido }}</h5>
                <p class="card-text">Curso:{{ $matricula->vc_shortName }}</p>
            </div>
        @endisset
    </div>
</div>
<div class="col-md-4">
    <div class="form-group ">
        <label for="aluno">Processo:</label>
        <input id="processo" class="form-control" required type="text" placeholder="Digite o numero de Processo"
            name="processo" value="{{ isset($matricula->processo) ? $matricula->processo : '' }}" autocomplete="off">


    </div>
</div>

<div class="col-sm-5">
    <div class="form-group">

        <label>Turma</label>
        {{-- <select name="it_idTurma" class="form-control buscarTurma"> --}}
        <select name="it_idTurma" id="id_turma" class="form-control select-dinamico" required>
            @isset($matricula)
                <option value="{{ $matricula->it_idTurma }}">{{ $matricula->vc_nomedaTurma }}/
                    {{ $matricula->vc_classe }}ª
                    classe/{{ $matricula->vc_nomeCurso }}/{{ $matricula->vc_turnoTurma }}({{ $matricula->ya_inicio }}/{{ $matricula->ya_fim }})
                </option>
            @else
                <option>seleciona a turma</option>
            @endisset
            @isset($turmas)
                @foreach ($turmas as $turma)
                    <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                        {{ $turma->vc_classe }}ª
                        classe/{{ $turma->vc_nomeCurso }}/{{ $turma->vc_turnoTurma }}({{ $turma->ya_inicio }}/{{ $turma->ya_fim }})
                    </option>
                @endforeach
            @endisset
        </select>

    </div>
</div>



<div class="col-md-3">
    <div class="form-group ">
        <label for="aluno">Seleciona uma imagem:</label>
        <input id="vc_imagem" class="form-control buscarProcesso processo_aprovacao " type="file" name="vc_imagem"
            value="{{ isset($matricula->vc_imagem) ? $matricula->vc_imagem : '' }}" autocomplete="off">
    </div>
</div>

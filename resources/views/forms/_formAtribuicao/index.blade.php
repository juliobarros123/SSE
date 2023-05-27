<div class="col-sm-4">
    <div class="form-group">
        <label>Turma</label>
        <select name="it_idTurma" class="form-control" required>
            @isset($turma)
                <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                    {{ $turma->vc_classe }}ª
                    classe/{{ $turma->vc_nomeCurso }}/{{ $turma->vc_turnoTurma }}({{ $turma->ya_inicio }}/{{ $turma->ya_fim }})
                </option>
            @else
                <option>Seleciona a turma</option>
            @endisset
            @foreach ($turmas as $turma)
                <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                    {{ $turma->vc_classe }}ª
                    classe/{{ $turma->vc_nomeCurso }}/{{ $turma->vc_turnoTurma }}({{ $turma->ya_inicio }}/{{ $turma->ya_fim }})
                </option>
            @endforeach
        </select>

    </div>
</div>

{{-- <div class="col-sm-3">
    <div class="form-group">
        <label>Classe</label>
        <select name="it_idClasse" class="form-control">
            @isset($classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}</option>
            @else
                <option>seleciona a classe</option>
            @endisset
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}</option>
            @endforeach
        </select>

    </div>
</div> --}}
{{-- @dump($disciplinas) --}}
{{-- @dump($disciplina) --}}
<div class="col-sm-4">
    <div class="form-group">
        <label>Disciplina</label>
        <select name="it_idDisciplina" class="form-control " required>
            @isset($disciplina)
                <option selected value="{{ $disciplina->id }}">{{ $disciplina->vc_nome }}</option>
            @else
                <option>Seleciona a disciplina</option>
            @endisset
            @foreach ($disciplinas as $disciplina)
                <option value="{{ $disciplina->id }}">{{ $disciplina->vc_nome }}</option>
            @endforeach
        </select>

    </div>
</div>
<div class="col-sm-4">
    <div class="form-group ">
        <label>Professor</label>
        <select name="it_idUser" class="form-control  " required>
            @isset($user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @else
                <option>seleciona o professor</option>
            @endisset
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @endforeach
        </select>
    </div>
</div>
<style>
    .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
    }

    .file-input label {
        display: block;
        position: relative;
        height: 50px;
        border-radius: 6px;
        background: linear-gradient(40deg, #343a41, #343a41);
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform .2s ease-out;
        top: 3px;
        width: auto;
    }
</style>
<script>
    var msg = '{{ Session::get('
        alert ') }}';
    var exist = '{{ Session::has('
        alert ') }}';
    if (exist) {
        alert(msg);
    }
</script>

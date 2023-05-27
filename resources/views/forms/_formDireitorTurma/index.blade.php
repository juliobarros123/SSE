<div class="col-sm-6">
    <div class="form-group">
        <label>Turma</label>
     {{-- @dump($director_turma) --}}
        <select name="id_turma" class="form-control  "   required>
            @isset($director_turma)
            <option selected value="{{ $director_turma->id_turma }}">{{ $director_turma->vc_nomedaTurma }}/
                {{ $director_turma->vc_classe }}ª
                classe/{{ $director_turma->vc_nomeCurso }}/{{ $director_turma->vc_turnoTurma }}({{ $director_turma->ya_inicio }}/{{ $director_turma->ya_fim }})
            </option>
            @else
                <option  selected disabled>Seleciona a turma</option>
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






<div class="col-sm-6">
    <div class="form-group ">
        <label>Professor</label>
        <select name="id_user" class="form-control " required>
            @isset($director_turma)
                <option selected value="{{ $director_turma->id_user}}">{{ $director_turma->vc_primemiroNome }} {{ $director_turma->vc_apelido }}</option>
            @else
                <option>Seleciona o professor</option>
            @endisset
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @endforeach
        </select>
    </div>
</div>


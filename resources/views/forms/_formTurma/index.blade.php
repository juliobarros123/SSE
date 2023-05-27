<div class="form-group col-md-3">
    <label class="form-label" for="vc_nomedaTurma">Turma:</label>
    <input class="form-control border-secondary" name="vc_nomedaTurma" id="vc_nomedaTurma" type="text"
        value="{{ isset($turma) ? $turma->vc_nomedaTurma : '' }}" autocomplete="off"
        placeholder="Digita o nome da turma">
</div>


<div class="form-group col-md-3">
    <label class="form-label" for="vc_classeTurma">Classe:</label>
    <select class="form-control " name="vc_classeTurma" id="vc_classeTurma" required>

        <option value="{{ isset($turma) ? $turma->it_idClasse : '' }}" selected>
            {{ isset($turma) ? $turma->vc_classe.'ª classe' : 'Selecione a classe:' }}</option>
        @foreach ($classes as $classe)
            <option value="{{ $classe->id }}">{{ $classe->vc_classe }}ª classe </option>
            </option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-3">
    <label class="form-label" for="vc_turnoTurma">Turno:</label>
    <select class="form-control " name="vc_turnoTurma" id="vc_turnoTurma" required>
        @if (isset($turma))
            <option selected class="text-primary" value="{{ $turma->vc_turnoTurma }}">{{ $turma->vc_turnoTurma }}
            </option>
        @else
            <option selected disabled value="">Selecione o turno da turma</option>
        @endif

        <option value="DIURNO">Diurno(manhã e tarde)</option>
        <option value="NOITE">Noite</option>
        <option value="MANHÃ">Manhã</option>
        <option value="TARDE">Tarde</option>
        <option value="Sabática">Sabática</option>
    </select>
</div>

<div class="form-group col-md-3">
    <label class="form-label" for="vc_salaTurma">Sala:</label>
    <input class="form-control border-secondary" name="vc_salaTurma" id="vc_salaTurma" type="text"
    value="{{ isset($turma) ? $turma->vc_salaTurma : '' }}" autocomplete="off"
    placeholder="Digita a sala da turma">
</div>
{{-- 
@dump($cursos) --}}
{{-- @dump($turma) --}}
<div class="form-group col-md-3">
    <label class="form-label">Curso:</label>
    <select class="form-control " name="vc_cursoTurma" required>
        <option value="{{ isset($turma) ? $turma->it_idCurso : '' }}" selected>
            {{ isset($turma) ? $turma->vc_shortName: 'Selecione o curso:' }}</option>
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }} </option>
      
        @endforeach
    </select>
</div>


<div class="form-group col-md-4">
    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>

    @if (isset($ano_lectivo_publicado))
        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
            <option value="{{ $id_anoLectivo_publicado }}">
                {{ $ano_lectivo_publicado }}
            </option>
        </select>
        <p class="text-danger  " > Atenção: Ano lectivo publicado</p>

    @else
        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
            <option value="{{ isset($turma) ? $turma->it_idAnoLectivo : '' }}" selected>
                {{ isset($turma) ? $turma->vc_anoLectivo : 'Selecione o ano lectivo:' }}</option>
            @foreach ($ano_letivos as $anolectivo)
                <option value="{{ $anolectivo->id}}">
                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                </option>
            @endforeach
        </select>
    @endif
</div>


<div class="form-group col-md-3">
    <label class="form-label" for="totaldealunos"> Quantidades de alunos:</label>
    <input class="form-control border-secondary" name="it_qtdeAlunos" type="number"
        value="{{ isset($turma) ? $turma->it_qtdeAlunos : '' }}" placeholder="Digita a quantidade de alunos"
        required>
</div>

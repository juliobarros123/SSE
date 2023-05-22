<div class="form-group col-md-3">
    <label for="it_curso">Curso</label>
    <select name="it_curso" id="it_curso" class="form-control border-secondary buscarCurso" required>
        @if (!isset($resposta->it_curso))
            <option value="" selected disabled>selecione o curso</option>
        @endif
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}" @if (isset($resposta->it_curso) && $resposta->it_curso == $curso->id) selected @endif>{{ $curso->vc_nomeCurso }}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label for="it_classe">Classe</label>
    <select class="form-control border-secondary buscarClasse" name="it_classe" id="it_classe" required>
        @if (!isset($resposta->it_classe))
            <option value="" selected disabled>Selecione a classe</option>
        @endif
        @foreach ($classes as $classe)
            <option value="{{ $classe->id }}" @if (isset($resposta->it_classe) && $resposta->it_classe == $classe->id) selected @endif>{{ $classe->vc_classe }}ªclasse</option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-3">
    <label for="it_disciplina">Disciplina</label>
    <select class="form-control  border-secondary buscarDisciplina" name="it_disciplina" id="it_disciplina" required>
        @if (!isset($resposta->it_disciplina))
            <option value="" selected disabled>Selecione disciplina
            </option>
        @endif
        @foreach ($disciplinas as $row)
            <option value="{{ $row->id }}" @if (isset($resposta->it_disciplina) && $resposta->it_disciplina == $row->id) selected @endif>{{ $row->vc_nome }}</option>
        @endforeach
    </select>
</div>

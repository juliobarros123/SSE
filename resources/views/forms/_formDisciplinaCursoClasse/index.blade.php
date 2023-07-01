{{-- @dump($cursos) --}}
<div class="form-group col-md-3">
    <label for="it_curso">Curso</label>
    <select name="it_curso" id="it_curso" class="form-control border-secondary " required>
        @if (!isset($disciplina_curso_classe->it_curso))
            <option value="" selected disabled>Seleccione o curso</option>
        @endif
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}" 
                @if (isset($disciplina_curso_classe->it_curso)
                 && $disciplina_curso_classe->it_curso == $curso->id)
                  selected
               

                  @endif>
                {{ $curso->vc_nomeCurso }}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-3">
    <label for="it_classe">Classe</label>
    <select class="form-control border-secondary  select-dinamico" name="it_classe" id="it_classe" required>
        @if (!isset($disciplina_curso_classe->it_classe))
            <option value="" selected disabled>Selecione a classe</option>
        @endif
        @foreach ($classes as $classe)
            <option value="{{ $classe->id }}" @if (isset($disciplina_curso_classe->it_classe)
             && $disciplina_curso_classe->it_classe == $classe->id) selected  @endif>
                {{ $classe->vc_classe }} ªclasse</option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-3">
    <label for="it_disciplina">Disciplina</label>
    <select class="form-control  border-secondary select-dinamico" name="it_disciplina" id="it_disciplina" required>
        @if (!isset($disciplina_curso_classe->it_disciplina))
            <option value="" selected disabled>Selecione disciplina
            </option>
        @endif
        @foreach ($disciplinas as $row)
            <option value="{{ $row->id }}" @if (isset($disciplina_curso_classe->it_disciplina) && $disciplina_curso_classe->it_disciplina == $row->id) selected @endif>{{ $row->vc_nome }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-3">
    <label for="terminal">Terminal</label>
    <select name="terminal" id="terminal" class="form-control" required>
        @if (isset($disciplina_curso_classe->terminal))
            <option value="{{ $disciplina_curso_classe->terminal }}">{{$disciplina_curso_classe->terminal}}</option>
        @else
            <option value="" selected disabled>Selecione uma opção</option>
        @endif
        <option value="Não Terminal">Não Terminal</option>

        <option value="Terminal">Terminal</option>
    </select>
</div>
<div class="form-group col-md-3">
    <label for="pap">P.A.P</label>
    <select class="form-control  border-secondary " name="pap" id="pap" required>
        @if (isset($disciplina_curso_classe))
            <option value="{{$disciplina_curso_classe->pap}}" selected disabled>{{$disciplina_curso_classe->pap}}
            </option>
        @endif
    
            <option value="Não" >Não</option>
            <option value="Sim" >Sim</option>
       
    </select>
</div>
<div class="form-group col-md-4">
    <label>Disciplinas</label>
    <select name="id_disciplina" class="form-control buscarDisciplina" id="selectT" >
        @isset($disciplinas)
            <option value=""> </option>
        @else
          
            <option selected value="{{ isset($dt) ? $dt->id_disciplina : '0' }}">
                {{ isset($dt) ? $dt->vc_nome : 'Seleciona a disciplina' }}
            </option>
        @endisset
       
    </select>
</div>


<div class="form-group col-md-4">
    <label>Classes</label>
    <select name="id_classe" class="form-control buscarClasse " id="selectTw" >
        @isset($classes)
            <option value=""> </option>
        @else
        <option selected value="{{ isset($dt) ? $dt->id_classe : '0' }}">
            {{ isset($dt) ? $dt->vc_classe : 'Seleciona a classe' }}
        </option>
        @endisset
       
    </select>
</div>


<div class="form-group col-md-3">
    <label class="form-label">Curso:</label>
    <select class="form-control buscarCurso" name="it_idCurso" required >
        <option value="{{ isset($dt) ? $dt->it_idCurso : '' }}" selected>
            {{ isset($dt) ? $dt->vc_nomeCurso : 'Selecione o curso:' }}</option>
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }} </option>
            </option>
        @endforeach
    </select>
</div>


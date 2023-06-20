
<div class="form-group col-md-3">
    <label class="form-label">Componente:</label>
    <select class="form-control " name="id_componente" required >
        <option value="{{ isset($componente_disciplina) ? $componente_disciplina->id_componente : '' }}" selected>
            {{ isset($componente_disciplina) ? $componente_disciplina->vc_componente : 'Selecione a componente:' }}</option>
        @foreach (fh_componentes()->get() as $componente)
            <option value="{{ $componente->id }}">{{ $componente->vc_componente }} </option>
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4">
    <label>Disciplinas</label>
    <select name="id_disciplina" class="form-control mySelect  "  >
        @isset($componente_disciplina)
       
            <option selected value="{{ isset($componente_disciplina) ? $componente_disciplina->id_disciplina : '0' }}">
                {{ isset($componente_disciplina) ? $componente_disciplina->vc_nome : 'Seleciona a disciplina' }}
            </option>
        @endisset
        @foreach (fh_disciplinas()->get() as $disciplina)
        <option value="{{ $disciplina->id }}">
            {{ $disciplina->vc_nome }}</option>
    @endforeach
       
    </select>
</div>






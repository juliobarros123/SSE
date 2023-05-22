<div class="form-group col-md-2">
    <label>Classe</label>
    <input type="text" class="form-control border-secondary " readonly placeholder="classe" name="classe"
        value="{{ isset($search->vc_classe) ? $search->vc_classe : '' }}">

</div>
<div class="form-group col-md-3">
    <label>Turma</label>
    <input type="text" class="form-control border-secondary " readonly placeholder="Turma" name="vc_nomedaTurma"
        value="{{ isset($search->vc_nomedaTurma) ? $search->vc_nomedaTurma : '' }}">
</div>

<div class="form-group col-md-3">
    <label for="vc_anolectivo">Ano Lectivo</label>
    <input type="text" class="form-control border-secondary " readonly placeholder="Ano lectivo" name="vc_anolectivo"
        value="{{ isset($search->vc_anoLectivo) ? $search->vc_anoLectivo : '' }}">

</div>
<div class="form-group col-md-4">
    <label for="it_disciplina">Disciplina</label>
    <select name="it_disciplina" id="it_disciplina" class="form-control border-secondary buscarDisciplina" required>
        <option value="" selected disabled>seleciona a disciplina</option>
        @foreach ($disciplinas as $disciplina)
            <option value="{{ $disciplina->id }}">{{ $disciplina->vc_nome }}</option>
        @endforeach
    </select>

</div>
<div class="form-group col-md-3">
    <label for="vc_tipodaNota" class="form-label">Trimestre ou Tipo da Nota</label>
    <select name="vc_tipodaNota" id="vc_tipodaNota" class="form-control border-secondary" required>
        <option value="" selected disabled>seleciona o trimestre ou tipo da nota</option>
        <option value="I">Iºtrimestre</option>
        <option value="II">IIºtrimestre</option>
        <option value="III">IIIºtrimestre</option>

       {{--  <option value="EE">Exame Especial</option>
        <option value="EP" >Exame Provincial</option> --}}

    </select>
</div>
<div class="form-group col-md-2" id="mac" >
    <label>MAC</label>
    <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="MAC"
        name="fl_mac" value="{{ isset($notas->fl_mac) ? $notas->fl_mac : '' }}">
</div>
<div class="form-group col-md-2">
    <label>Nota 1</label>
    <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="Nota 1"
        name="fl_nota1" value="{{ isset($notas->fl_nota1) ? $notas->fl_nota1 : '' }}" required>
</div>
<div class="form-group col-md-2" id="provadois" >
    <label>Nota 2</label>
    <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="Nota 2"
        name="fl_nota2" value="{{ isset($notas->fl_nota2) ? $notas->fl_nota2 : '' }}">
</div>



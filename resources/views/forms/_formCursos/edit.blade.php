<div class="form-group col-md-6">
    <label for="vc_nomeCurso" class="form-label">Nome do Curso</label>
    <input type="text" class="form-control border-secondary" name="vc_nomeCurso" placeholder="Nome do Curso"
        id="vc_nomeCurso" value="{{ $curso->vc_nomeCurso }}" required>
</div>

<div class="form-group col-md-6">
    <label for="vc_descricaodoCurso" class="form-label">Descrição do Curso</label>
    <input type="text" class="form-control border-secondary" name="vc_descricaodoCurso" placeholder="Descrição do Curso"
        id="vc_descricaodoCurso" value="{{ $curso->vc_descricaodoCurso }}" required>
</div>
<div class="form-group col-md-6">
    <label for="vc_shortName" class="form-label">Nome Curto do Curso</label>
    <input type="text" class="form-control border-secondary" name="vc_shortName" placeholder="Nome Curto do Curso"
        id="vc_shortName" required>
</div>
<div class="form-group col-md-6">
    <label for="it_estadodoCurso" class="form-label">Estado do Curso</label>
    <select class="form-control border-secondary" name="it_estadodoCurso" id="it_estadodoCurso" required>
        <option value="0" @if($curso->it_estadodoCurso == 0) selected @endif class="text-danger">DESACTIVADO</option>
        <option value="1" @if($curso->it_estadodoCurso == 1) selected @endif class="text-primary">ACTIVADO</option>
    </select>
</div>

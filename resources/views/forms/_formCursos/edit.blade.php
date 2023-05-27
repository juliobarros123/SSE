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
    <input type="text" class="form-control border-secondary" value="{{ $curso->vc_shortName }}" name="vc_shortName" placeholder="Nome Curto do Curso"
        id="vc_shortName" required>
</div>


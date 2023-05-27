
<div class="form-group col-md-6">
    <label for="nome">Disciplina Extenso</label>
    <input type="text" id="nome" placeholder="Digite a disciplina" class="form-control border-secondary" name="vc_nome"
        value="{{ isset($disciplina->vc_nome) ? $disciplina->vc_nome : '' }}" required>
</div>

<div class="form-group col-md-6">
    <label for="vc_acronimo">Nome curto da Disciplina</label>
    <input type="text" id="vc_acronimo" placeholder="Digite o nome curto da Disciplina" class="form-control border-secondary" name="vc_acronimo"
        value="{{ isset($disciplina->vc_acronimo) ? $disciplina->vc_acronimo : '' }}" required>
</div>


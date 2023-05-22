<div class="form-group col-sm-4">
    <label for="" class="form-label">Inicio do Ano Lectivo</label>
    <input type="number" class="form-control" placeholder="Digite o ano lectivo" name="ya_inicio"
        value="{{ isset($anolectivo->ya_inicio) ? $anolectivo->ya_inicio : '' }}" required>
</div>
<div class="form-group col-sm-4">
    <label for="" class="form-label">Fim do Ano Lectivo</label>
    <input type="number" class="form-control" placeholder="Digite o ano lectivo" name="ya_fim"
        value="{{ isset($anolectivo->ya_fim) ? $anolectivo->ya_fim : '' }}" required>
</div>

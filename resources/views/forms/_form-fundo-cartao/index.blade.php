
<div class="form-group col-md-6">
    <label class="form-label" for="entidade">Entidade : </label>
    <select class="form-control " name="entidade" id="entidade" required>

        <option selected value="{{ isset($fundo_cartao) ? $fundo_cartao->entidade : '0' }}">
            {{ isset($fundo_cartao) ? $fundo_cartao->entidade : 'Selecciona o tipo de cartão' }}
        </option>

        <option value="Aluno">Aluno</option>
        <option value="Funcionario">Funcionário</option>

    </select>
</div>
<div class="form-group col-md-6">
    <label>Fundo:</label>
    <input type="file" id="fundo" class="form-control border-secondary " name="fundo">

</div>

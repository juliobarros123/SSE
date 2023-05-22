<div class="form-group col-sm-4">
    <label for="it_estado" class="form-label" required>Activador</label>
    <select name="it_estado" id="it_estado" class="form-control">
        <option value="" disabled>selecione uma opção</option>
        <option value="0" @if (isset($activador->it_estado) && $activador->it_estado == 0)
    selected
@endif>Desativar</option>
        <option value="1" @if (isset($activador->it_estado) && $activador->it_estado == 1)
    selected
@endif>Activar</option>
    </select>
</div>



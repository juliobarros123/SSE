<div class="form-group col-md-6">
    <label for="it_processo" class="form-label">Nº do Processo</label>
    <input type="text" class="form-control border-secondary" name="it_processo" placeholder="Nº do Processo"
        id="it_processo" value="{{ isset($processo->it_processo) ? $processo->it_processo : '' }}" required>
</div>

{{-- @isset($processo)
    <div class="form-group col-md-6">
        <label for="it_estado_processo" class="form-label">Estado do Processo</label>
        <select class="form-control border-secondary" name="it_estado_processo" id="it_estado_processo" required>
            <option value="{{ isset($processo->it_estado_processo) ? $processo->it_estado_processo : '0' }}" @if ($processo->it_estado_processo == 0) selected @endif
                class="text-danger">DESACTIVADO</option>
            <option value="{{ isset($processo->it_estado_processo) ? $processo->it_estado_processo : '1' }}" @if ($processo->it_estado_processo == 1) selected @endif
                class="text-primary">ACTIVADO</option>
        </select>
    </div>
@endisset --}}

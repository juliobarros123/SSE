<div class="form-group col-md-6">
    <label for="n">{{ __('Peso das Médias Trimestrais') }}</label>

    <input value="{{ isset($peso_nota_exame->peso_medias_trimestral) ? $peso_nota_exame->peso_medias_trimestral : '' }}"
        id="n" type="number" class="form-control @error('peso_medias_trimestral') is-invalid @enderror" name="peso_medias_trimestral"
        step="any" placeholder="Valor" value="{{ old('peso_medias_trimestral') }}" required autocomplete="peso_medias_trimestral" autofocus required>

    @error('peso_medias_trimestral')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-6">
    <label for="n">{{ __('Peso da Nota de Exame') }}</label>

    <input value="{{ isset($peso_nota_exame->peso_nota_exame) ? $peso_nota_exame->peso_nota_exame : '' }}"
        id="n" type="number" class="form-control @error('peso_nota_exame') is-invalid @enderror" name="peso_nota_exame"
        step="any" placeholder="Valor" value="{{ old('peso_nota_exame') }}" required autocomplete="peso_nota_exame" autofocus required>

    @error('peso_nota_exame')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

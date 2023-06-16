<div class="form-group col-md-4">
    <label for="n">{{ __('Nº de Negativas') }}</label>

    <input value="{{ isset($n_negativa->n) ? $n_negativa->n : '' }}" id="n" type="number"
        class="form-control @error('n') is-invalid @enderror" name="n" placeholder="Nº de Negativas"
        value="{{ old('n') }}" required autocomplete="n" autofocus required>

    @error('n')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>

<div class="form-group col-md-8">
    <label for="id_classe">Classe</label>
    <select class="form-control border-secondary mySelect" multiple name="id_classe[]" id="id_classe" required>

        @if (isset($n_negativa))
            <option selected value="{{ $n_negativa->id_classe }}">{{ $n_negativa->vc_classe }} ªclasse</option>
        @else
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">
                    {{ $classe->vc_classe }} ªclasse</option>
            @endforeach
        @endif

    </select>
</div>

{{-- <select id="mySelect" multiple style="width: 300px;">
    <option value="opcao1">Opção 1</option>
    <option value="opcao2">Opção 2</option>
    <option value="opcao3">Opção 3</option>
    <option value="opcao4">Opção 4</option>
    <option value="opcao5">Opção 5</option>
</select> --}}

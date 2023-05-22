

    <div class="form-group col-sm-8">
        <label for="vc_bI">{{ __('Nome Serviço') }}</label>

        <input value="{{ isset($dados->vc_nome) ? $dados->vc_nome : '' }}" id="vc_nome"
            type="text" class="form-control @error('vc_nome') is-invalid @enderror" name="vc_nome"
            placeholder="Nome do serviço" value="{{ old('vc_nome') }}" required autocomplete="vc_nome" autofocus required>

        @error('vc_nome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>


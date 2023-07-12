
<div class="col-md-2">
    <div class="form-group ">
        <label for="vc_bI">{{ __('Nº Bilhete') }}</label>

        <input value="{{ isset($funcionario->vc_bI) ? $funcionario->vc_bI : '' }}" id="vc_bI"
            type="text" class="form-control @error('vc_bI') is-invalid @enderror" name="vc_bI"
            placeholder="Número do BI" value="{{ old('vc_bI') }}" required autocomplete="vc_bI" autofocus>

        @error('vc_bI')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="vc_primemiroNome">{{ __('Nome') }}</label>

        <input value="{{ isset($funcionario->vc_nomeFuncionario) ? $funcionario->vc_nomeFuncionario : '' }}" id="vc_nomeFuncionario"
            type="text" class="form-control @error('vc_primemiroNome') is-invalid @enderror" name="vc_nomeFuncionario"
            placeholder="Nome" value="{{ old('vc_nomeFuncionario') }}" required autocomplete="vc_nomeFuncionario" autofocus>

        @error('vc_nomeFuncionario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <label for="vc_genero">{{ __('Genero') }}</label>
    <select type="text" class="form-control border-secondary" name="vc_genero" required>
        @isset($funcionario)
            <option value="{{ isset($funcionario->vc_genero) ? $funcionario->vc_genero : '' }}">{{ $funcionario->vc_genero }}</option>
        @else
            <option disabled value="" selected>selecione o gênero</option>
        @endisset
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
    </select>
</div>

<div class="col-md-4">
    <label for="vc_funcao">{{ __('Função') }}</label>
    <select type="text" class="form-control border-secondary" name="vc_funcao" required>
        @isset($funcionario)
            <option value="{{ isset($funcionario->vc_funcao) ? $funcionario->vc_funcao : '' }}">
                {{ $funcionario->vc_funcao }}</option>
        @else
            <option disabled value="" selected>selecione a função</option>
        @endisset
        <option value="02">Formador ++</option>
        <option value="01">Apenas Formador</option>
        <option value="00">Auxiliar de limpeza</option>
        <option value="00">Secretaria</option>
        <option value="00">RH</option>
        <option value="00">Coordenação Pedagógica</option>
    </select>
</div>






<div class="col-md-2">
    <div class="form-group ">
        <label for="vc_bI">{{ __('Nº Bilhete') }}</label>

        <input value="{{ isset($funcionario->vc_bi) ? $funcionario->vc_bi : '' }}" id="vc_bI"
            type="text" class="form-control @error('vc_bI') is-invalid @enderror" name="vc_bI"
            placeholder="Número do BI" value="{{ old('vc_bI') }}" required autocomplete="vc_bI" autofocus
            disabled>

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

        <input value="{{ isset($funcionario->vc_primeiroNome) ? $funcionario->vc_primeiroNome : '' }} {{ isset($funcionario->vc_ultimoNome) ? $funcionario->vc_ultimoNome : '' }}" id="vc_nomeFuncionario"
            type="text" class="form-control @error('vc_primemiroNome') is-invalid @enderror" name="vc_nomeFuncionario"
            placeholder="Nome" value="{{ old('vc_nomeFuncionario') }}" required autocomplete="vc_nomeFuncionario" autofocus
            disabled>

        @error('vc_nomeFuncionario')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

{{--<div class="col-md-2">
    <label for="vc_genero">{{ __('Gênero') }}</label>
    <select disabled type="text" class="form-control border-secondary" name="vc_genero" required>
        @isset($funcionario)
            <option value="{{ isset($funcionario->vc_genero) ? $funcionario->vc_genero : '' }}">{{ $funcionario->vc_genero }}</option>
        @else
            <option disabled value="" selected>selecione o gênero</option>
        @endisset
        <option value="masculino">Masculino</option>
        <option value="feminino">Feminino</option>
    </select>
</div> --}}

<div class="col-md-3">
    <label for="vc_funcao">{{ __('Função') }}</label>
    
    <input  disabled value="{{ isset($funcionario->vc_funcao) ? $funcionario->vc_funcao : '' }}" id="vc_funcao"
            type="text" class="form-control @error('vc_funcao') is-invalid @enderror" name="vc_funcao"
            placeholder="Escreva a função" value="{{ old('vc_funcao') }}" required autocomplete="vc_funcao" autofocus>
    
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="dc_salarioLiquido">{{ __('Salário Iliquido') }}</label>

        <input value="{{ isset($funcionario->dc_salarioLiquido) ? $funcionario->dc_salarioLiquido : '' }}" id="dc_salarioLiquido"
            type="text" class="form-control @error('dc_salarioLiquido') is-invalid @enderror" name="dc_salarioLiquido"
            placeholder="" value="{{ old('dc_salarioLiquido') }}" required autocomplete="dc_salarioLiquido" autofocus>

        @error('dc_salarioLiquido')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>





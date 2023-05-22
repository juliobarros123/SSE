
<div class="col-md-4">
    <div class="form-group ">
        <label for="vc_debito">{{ __('Destino da Saída') }}</label>

        <input value="{{ isset($debito->vc_debito) ? $debito->vc_debito : '' }}" id="vc_debito"
            type="text" class="form-control @error('vc_debito') is-invalid @enderror" name="vc_debito"
            placeholder="Escreva o destino" value="{{ old('vc_debito') }}" required autocomplete="vc_debito" autofocus required>

        @error('vc_debito')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="col-md-4">
    <div class="form-group ">
        <label for="vc_bI">{{ __('Mês Da Saída') }}</label>

        <select  id="it_id_mes"
             class="form-control @error('it_id_mes') is-invalid @enderror"
            placeholder="selecione o mês" required autocomplete="it_id_mes" name="it_id_mes" autofocus required>
            
            @isset($mes)
            <option value="{{ isset($mes->id  ) ? $mes->id   : '' }}">{{ $mes->vc_nome  }}</option>
            @else
            <option disabled value="" selected>selecione o mês</option>
            @endisset
            
            @foreach ($meses as $mes)
            <option value="{{  $mes->id   }}">{{  $mes->vc_nome   }}</option>
            @endforeach

        </select>

        @error('it_id_mes')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-4">
    <div class="form-group ">
        <label for="vc_bI">{{ __('Ano da Saída') }}</label>
        <input value="{{ isset($debito->ya_ano) ? $debito->ya_ano : '' }}" id="ya_ano"
            type="text" class="form-control @error('ya_ano') is-invalid @enderror" name="ya_ano"
            placeholder="Escreva o ano" value="{{ old('ya_ano') }}" required autocomplete="ya_ano" autofocus required>

        @error('ya_ano')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="col-md-4">
    <div class="form-group ">
        <label for="dc_valor">{{ __('Valor de Saída') }}</label>
        <input value="{{ isset($debito->dc_valor) ? $debito->dc_valor : '' }}" id="dc_valor"
            type="text" class="form-control @error('dc_valor') is-invalid @enderror" name="dc_valor"
            placeholder="Escreva o valor" value="{{ old('dc_valor') }}" required autocomplete="dc_valor" autofocus required>

        @error('dc_valor')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


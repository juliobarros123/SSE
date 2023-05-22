<div class="col-md-3">
    <label for="it_id_mes">{{ __('Mês') }}</label>
    <select type="text" class="form-control border-secondary" name="it_id_mes" required>
        @isset($funcionario)
            <option disabled value="{{ isset($funcionario->it_id_mes) ? $funcionario->it_id_mes : '' }}">
                {{ $funcionario->it_id_mes }}</option>
        @else
            <option disabled value="" selected>selecione o mês</option>
        @endisset
        @foreach($meses as $mes)
        <option value="{{$mes->id}}">{{$mes->vc_nome}}</option>    
        @endforeach
        
    </select>
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="ya_ano">{{ __('Ano') }}</label>

        <input id="ya_ano"
            type="text" class="form-control @error('ya_ano') is-invalid @enderror" name="ya_ano"
            placeholder="insira o ano" value="{{ old('ya_ano') }}" required autocomplete="ya_ano" autofocus>

        @error('ya_ano')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>





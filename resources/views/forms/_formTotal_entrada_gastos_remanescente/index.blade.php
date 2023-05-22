<div class="form-group col-md-5">
    <label for="it_id_mes">{{ __('Mês') }}</label>
    <select type="text" class="form-control border-secondary" name="it_id_mes" required>
            <option disabled value="" selected>selecione o mês</option>
     
            @foreach ($balancos as $balanco)
                 <option  value="{{isset($balanco)?$balanco->id:''}}" >{{isset($balanco)?$balanco->vc_nome:''}}</option>
                 @endforeach
           
           
    </select>
</div>

<div class="form-group col-md-4">
    <div class="form-group ">
        <label for="ya_ano">{{ __('Ano') }}</label>

        <input value="{{ isset($balanco->ya_ano) ? $balanco->ya_ano : '' }}" id="ya_ano"
            type="text" class="form-control @error('vc_primemiroNome') is-invalid @enderror" name="ya_ano"
            placeholder="escreva o ano" value="{{ old('ya_ano') }}" required autocomplete="ya_ano" autofocus>

        @error('ya_ano')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>






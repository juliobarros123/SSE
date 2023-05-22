<div class="col-md-3">
    <div class="form-group ">

        <label for="it_id_servicos">{{ __('Serviço ') }}</label>

            <select  id="it_id_servicos"
             class="form-control @error('it_id_servicos') is-invalid @enderror"
            placeholder="Selecione o serviço" required autocomplete="it_id_servicos" name="it_id_servicos" autofocus required>
            <option disabled value="" selected>selecione o serviço</option>
            @foreach ($servicos as $servico)
            <option value="{{  $servico->id   }}">{{  $servico->vc_nome   }}</option>
            @endforeach

        </select>
        @error('it_id_servicos')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="col-md-3">
    <div class="form-group ">
        <label for="descricao">{{ __('Mês da Manuteção') }}</label>

        <select  id="it_id_mes"
             class="form-control @error('it_id_mes') is-invalid @enderror"
            placeholder="Nome do dados" required autocomplete="it_id_mes" name="it_id_mes" autofocus required>
            <option disabled value="" selected>selecione o mês</option>
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

<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_bI">{{ __('Ano da Manuteção') }}</label>
        <input value="{{ isset($dados->ya_ano) ? $dados->ya_ano : '' }}" id="ya_ano"
            type="text" class="form-control @error('ya_ano') is-invalid @enderror" name="ya_ano"
            placeholder="Escreva o ano" value="{{ old('ya_ano') }}" required autocomplete="ya_ano" autofocus required>

        @error('ya_ano')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">

        <label for="dc_custo">{{ __('Valor Da Manuteção ') }}</label>

        <input value="{{ isset($dados->dc_custo) ? $dados->dc_custo : '' }}" id="dc_custo"
            type="text" class="form-control @error('dc_custo') is-invalid @enderror" name="dc_custo"
            placeholder="Escreva a quantia gasta" value="{{ old('dc_custo') }}" required autocomplete="dc_custo" autofocus required>

        @error('dc_custo')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-6">
    <div class="form-group ">
        <label for="dc_descricao">{{ __('Discrição do Serviço') }}</label>

        <textarea value="{{ isset($dados->vc_descricao) ? $dados->vc_descricao : '' }}" id="vc_descricao"
            class="form-control @error('vc_descricao') is-invalid @enderror" name="vc_descricao"
            placeholder="Nome do dados" value="{{ old('vc_descricao') }}" min="0" required autocomplete="vc_descricao" autofocus required>
        </textarea>

        @error('vc_descricao')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

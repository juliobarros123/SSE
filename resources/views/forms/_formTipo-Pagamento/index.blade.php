<div class="form-group col-md-4">
    <label>Tipo de Pagamento</label>
    <select name="tipo" class="form-control select-dinamico " id="tipo_pagamento" required>
        @isset($tipo_pagamento)
            <option value="{{ $tipo_pagamento->tipo }}">{{ $tipo_pagamento->tipo }}</option>
        @else
            <option value="" >Selecciona o Tipo de Pagamento</option>
        @endisset

        <option value="Mensalidades">Mensalidades</option>
        {{-- <option value="Taxa de Matrícula">Taxa de Matrícula</option>
        <option value="Material Didático">Material Didático</option>
        <option value="Uniforme Escolar">Uniforme Escolar</option>
        <option value="Taxa de Transporte">Taxa de Transporte</option>
        <option value="Taxa de Atividades Extracurriculares">Taxa de Atividades Extracurriculares</option> --}}
    </select>

</div>



<div class="form-group col-md-4">
    <label for="valor">{{ __('Pagamento de:') }}</label>

    <input value="{{ isset($tipo_pagamento->pagamento) ? $tipo_pagamento->pagamento : '' }}" id="pagamento"
        type="text" class="form-control @error('pagamento') is-invalid @enderror" name="pagamento"
        placeholder="pagamento do pagamento" value="{{ old('pagamento') }}" required autocomplete="pagamento" autofocus
        required>

    @error('pagamento')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>


<div class="form-group col-md-4">
    <label for="valor">{{ __('Valor') }}</label>

    <input value="{{ isset($tipo_pagamento->valor) ? $tipo_pagamento->valor : '' }}" id="valor" type="number"
        class="form-control @error('valor') is-invalid @enderror" name="valor" placeholder="Valor "
        value="{{ old('valor') }}" required autocomplete="valor" autofocus required>

    @error('valor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-4 box-hidden" hidden>
    <label for="multa_valor">{{ __('Valor da Multa') }}</label>

    <input value="{{ isset($tipo_pagamento->multa_valor) ? $tipo_pagamento->multa_valor : '' }}" id="multa_valor"
        type="number" class="form-control @error('multa_valor') is-invalid @enderror" name="multa_valor"
        placeholder="Multa de " value="{{ old('multa_valor') }}" required autocomplete="valor" autofocus required>

    @error('multa_valor')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-4  box-hidden" hidden>
    <label for="dias_multa">{{ __('Multa depois de:') }}</label>

    <input value="{{ isset($tipo_pagamento->dias_multa) ? $tipo_pagamento->dias_multa : '' }}" id="dias_multa"
        type="number" class="form-control @error('dias_multa') is-invalid @enderror" name="dias_multa"
        placeholder="dias " value="{{ old('dias_multa') }}" required autocomplete="dias_multa" autofocus required>

    @error('dias_multa')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
    @enderror
</div>
<div class="form-group col-md-3">
    <label for="id_classe">Classe</label>
    <select class="form-control border-secondary  select-dinamico" name="id_classe" id="id_classe">
        @if (!isset($tipo_pagamento->id_classe))
            <option value="" selected disabled>Selecione a classe</option>
        @endif
        @foreach ($classes as $classe)
            <option value="{{ $classe->id }}" @if (isset($tipo_pagamento->id_classe) && $tipo_pagamento->id_classe == $classe->id) selected @endif>
                {{ $classe->vc_classe }} ªclasse</option>
        @endforeach
    </select>
</div>


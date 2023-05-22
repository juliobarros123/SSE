{{-- @if (isset($diplomado))
{{dd($diplomado)}}
@endif --}}
<div class="col-md-2    ">
    <div class="form-group ">
        <label for="it_id_aluno">{{ __('Numero de Processo') }}</label>
        <input value="{{ isset($diplomado[0]->it_id_aluno) ? $diplomado[0]->it_id_aluno : '' }}" id="it_id_aluno"
            type="number" class="form-control @error('it_id_aluno') is-invalid @enderror border-secondary" name="it_id_aluno"
            placeholder="Numero de Processo" value="{{ old('it_id_aluno') }}" required autocomplete="it_id_aluno" autofocus>

        @error('vc_primeiroNome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_primeiroNome">{{ __('Primeiro Nome') }}</label>
        <input value="{{ isset($diplomado[0]->vc_primeiroNome) ? $diplomado[0]->vc_primeiroNome : '' }}" id="vc_primeiroNome"
            type="text" class="form-control @error('vc_nomeUtilizador') is-invalid @enderror border-secondary" name="vc_primeiroNome"
            placeholder="Primeiro Nome"  required autocomplete="vc_nomeUtilizador" autofocus>

        @error('vc_primeiroNome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_nomeMeio">{{ __('Nome do meio') }}</label>

        <input value="{{ isset($diplomado[0]->vc_nomeMeio) ? $diplomado[0]->vc_nomeMeio : '' }} " id="vc_nomeMeio"
            type="text" class="form-control @error('vc_nomeMeio') is-invalid @enderror border-secondary" name="vc_nomeMeio"
            placeholder="Nome do Meio"  required autocomplete="vc_nomeMeio" autofocus>

        @error('vc_nomeMeio')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_ultimoNome">{{ __('Ultimo Nome') }}</label>
        <input value="{{ isset($diplomado[0]->vc_ultimoNome) ? $diplomado[0]->vc_ultimoNome : '' }}" id="vc_ultimoNome" type="text"
        placeholder="Ultimo Nome" class="form-control @error('vc_ultimoNome') is-invalid @enderror border-secondary" name="vc_ultimoNome"
            required autocomplete="vc_ultimoNome" autofocus>

        @error('vc_ultimoNome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <label for="it_estado">{{ __('Estado') }}</label>
    <select type="text" class="form-control border-secondary" name="it_estado" required>
        @isset($user)
            <option value="{{ isset($diplomado->it_estado) ? $diplomado->it_estado : '' }}">
                {{ $diplomado->it_estado }}</option>
        @else
            <option disabled value="" selected>selecione o estado</option>
        @endisset
        <option value="1">Ativado</option>
        <option value="0">Desativado</option>


    </select>
</div>
<div class="form-group col-md-3">
    <label for="it_curso">Curso</label>
    <select name="id_curso" id="it_curso" class="form-control border-secondary buscarCurso" >
        @if (!isset($resposta->it_curso))
            <option value="" selected disabled>selecione o curso</option>
        @endif
        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}" @if (isset($resposta->it_curso) && $resposta->it_curso == $curso->id) selected @endif>{{ $curso->vc_nomeCurso }}</option>
        @endforeach
    </select>
</div>


<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_nomeMae">{{ __('Nome da Mãe ') }}</label>
        <input value="{{ isset($diplomado[0]->vc_nomeMae) ? $diplomado[0]->vc_nomeMae : '' }}" id="vc_nomeMae" type="text"
        placeholder="Nome da Mãe " class="form-control @error('vc_nomeMae') is-invalid @enderror border-secondary" name="vc_nomeMae"
           required autocomplete="vc_nomeMae" autofocus>

        @error('vc_nomeMae')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_nomePai">{{ __('Nome do Pai ') }}</label>
        <input value="{{ isset($diplomado[0]->vc_nomePai) ? $diplomado[0]->vc_nomePai : '' }}" id="vc_nomePai" type="text"
        placeholder="Nome do Pai " class="form-control @error('vc_nomePai') is-invalid @enderror border-secondary" name="vc_nomePai"
            required autocomplete="vc_nomePai" autofocus>

        @error('vc_nomePai')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_nBI">{{ __('Numero de BI ') }}</label>
        <input value="{{ isset($diplomado[0]->vc_nBI) ? $diplomado[0]->vc_nBI : '' }}" id="vc_nBI" type="text"
        placeholder="Numero de BI " class="form-control @error('vc_nBI') is-invalid @enderror border-secondary" name="vc_nBI"
            required autocomplete="vc_nBI" autofocus>

        @error('vc_nBI')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>


<div class="col-md-2">
    <div class="form-group ">
        <label for="dt_dataNascimento">{{ __('Data de Nascimento ') }}</label>
        <input value="{{ isset($diplomado->it_dataNascimento) ? $diplomado->it_dataNascimento : '' }}" id="it_dataNascimento" type="date"
        placeholder="Data de Nascimento " class="form-control @error('dt_dataNascimento') is-invalid @enderror border-secondary" name="dt_dataNascimento"
            required autocomplete="dt_dataNascimento" autofocus>

        @error('dt_dataNascimento')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">
        <label for="dt_dataEmissaoBilhete">{{ __('Data de Emissão do Bilhete ') }}</label>
        <input value="{{ isset($diplomado->dt_dataEmissaoBilhete) ? $diplomado->dt_dataEmissaoBilhete : '' }}" id="dt_dataEmissaoBilhete" type="date"
        placeholder="Data de Nascimento " class="form-control @error('dt_dataEmissaoBilhete') is-invalid @enderror border-secondary" name="dt_dataEmissaoBilhete"
            required autocomplete="dt_dataEmissaoBilhete" autofocus>

        @error('dt_dataEmissaoBilhete')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

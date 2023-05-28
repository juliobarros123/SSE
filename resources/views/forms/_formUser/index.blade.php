<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_nomeUtilizador">{{ __('Utilizador') }}</label>
        <input value="{{ isset($user->vc_nomeUtilizador) ? $user->vc_nomeUtilizador : '' }}" id="vc_nomeUtilizador"
            type="text" class="form-control @error('vc_nomeUtilizador') is-invalid @enderror border-secondary" name="vc_nomeUtilizador"
            placeholder="Utilizador" value="{{ old('vc_nomeUtilizador') }}" required autocomplete="vc_nomeUtilizador" autofocus>

        @error('vc_nomeUtilizador')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="vc_primemiroNome">{{ __('Nome') }}</label>

        <input value="{{ isset($user->vc_primemiroNome) ? $user->vc_primemiroNome : '' }}" id="vc_primemiroNome"
            type="text" class="form-control @error('vc_primemiroNome') is-invalid @enderror border-secondary" name="vc_primemiroNome"
            placeholder="Nome" value="{{ old('vc_primemiroNome') }}" required autocomplete="vc_primemiroNome" autofocus>

        @error('vc_primemiroNome')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-3">
    <div class="form-group ">
        <label for="vc_apelido">{{ __('Apelido') }}</label>
        <input value="{{ isset($user->vc_apelido) ? $user->vc_apelido : '' }}" id="vc_apelido" type="text"
        placeholder="Apelido" class="form-control @error('vc_apelido') is-invalid @enderror border-secondary" name="vc_apelido"
            value="{{ old('vc_apelido') }}" required autocomplete="vc_apelido" autofocus>

        @error('vc_apelido')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-md-4">
    <label for="vc_tipoUtilizador">{{ __('Nivel') }}</label>
    <select type="text" class="form-control border-secondary" id="nivel"  name="vc_tipoUtilizador" required>
        @isset($user)
            <option value="{{ isset($user->vc_tipoUtilizador) ? $user->vc_tipoUtilizador : '' }}">
                {{ $user->vc_tipoUtilizador }}</option>
        @else
            <option disabled value="" selected>selecione o nível de acesso</option>
        @endisset
        <option value="Director Geral">Director Geral</option>
        <option value="Administrador">Administrador</option>
        <option value="Sub Directoria Pedagógica">Sub Directoria Pedagógica</option>
        <option value="RH">Recursos Humanos</option>
        <option value="Secretaria">Secretaria</option>
        <option value="Comissão">Comissão</option>
        <option value="Professor">Professor</option>
        <option value="Preparador">Preparador</option>
        <option value="Chefe de Departamento Pedagógico">Chefe de Departamento Pedagógico</option>
        <option value="Gabinete Pedagógico">Gabinete Pedagógico</option>
        <option value="Candidato">Candidato</option>
   
    </select>
</div>
<div class="col-md-2">
    <div class="form-group" >
        <label for="it_n_agente">{{ __('Numero de agente') }}</label>
        <input  id="n_agente" value="{{ isset($user->it_n_agente) ? $user->it_n_agente : '' }}"
            placeholder="Numero de agene" type="number" class="form-control @error('it_n_agente') is-invalid @enderror border-secondary" name="it_n_agente"
            value="{{ old('it_n_agente') }}" autocomplete="it_n_agente" autofocus >

        @error('it_n_agente')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-md-2">
    <div class="form-group ">
        <label for="vc_telefone">{{ __('Telefone') }}</label>
        <input value="{{ isset($user->vc_telefone) ? $user->vc_telefone : '' }}" id="vc_tipoUtilizador" id="vc_telefone"
            placeholder="Telefone" type="number" min="900000000" class="form-control @error('vc_telefone') is-invalid @enderror border-secondary" name="vc_telefone"
            value="{{ old('vc_telefone') }}" required autocomplete="vc_telefone" autofocus>

        @error('vc_telefone')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>
<div class="col-md-2">
    <label for="vc_genero">{{ __('Genero') }}</label>
    <select type="text" class="form-control border-secondary" name="vc_genero" required>
        @isset($user)
            <option value="{{ isset($user->vc_genero) ? $user->vc_genero : '' }}">{{ $user->vc_genero }}</option>
        @else
            <option disabled value="" selected>selecione o gênero</option>
        @endisset
        <option value="Masculino">Masculino</option>
        <option value="Feminino">Feminino</option>
    </select>
</div>

<div class="col-md-4">
    <div class="form-group ">
        <label for="email">{{ __('Email') }}</label>
        <input value="{{ isset($user->vc_email) ? $user->vc_email : '' }}" id="email" type="email"
        placeholder="Email@gmail.com"class="form-control @error('email') is-invalid @enderror border-secondary" name="vc_email" value="{{ old('vc_email') }}"
            required autocomplete="vc_email">

        @error('email')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="password">{{ __('Senha') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror border-secondary"
        placeholder="Senha"name="password" required autocomplete="new-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
</div>

<div class="col-md-2">
    <div class="form-group ">
        <label for="password-confirm">{{ __('Confirmar a senha') }}</label>
        <input id="password-confirm" type="password" class="form-control border-secondary" name="password_confirmation" required
        placeholder="Confirmar a senha" autocomplete="new-password">
    </div>
</div>

{{-- <script>
 function habilitarCampos() {
	if($("#nivel").val() == 'Professor') {
		$("#n_agente").prop('disabled', false);
	} else {
  	$("#n_agente").prop('disabled', true);
  }
}
</script> --}}


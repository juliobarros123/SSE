
<div class="col-md-4">
    <label for="vc_primeiroNome" class="form-label">Primeiro Nome</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($funcionario->vc_primeiroNome) ? $funcionario->vc_primeiroNome : '' }}"
        name="vc_primeiroNome" placeholder="Primeiro Nome" required>
</div>
<div class="col-md-4">
    <label for="vc_ultimoNome" class="form-label">Apelido</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($funcionario->vc_ultimoNome) ? $funcionario->vc_ultimoNome : '' }}"
        name="vc_ultimoNome" placeholder="Apelido" required>
</div>

<div class="col-md-4">
    <label for="vc_agente" class="form-label">Número de agente</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($funcionario->vc_agente) ? $funcionario->vc_agente : '' }}" name="vc_agente" 
         placeholder="Número" >
</div>
<div class="col-md-4">
    <label for="vc_bi" class="form-label">Bilhete de Identidade</label>
    <input type="text" class="form-control border-secondary"
        value="{{ isset($funcionario->vc_bi) ? $funcionario->vc_bi : '' }}" name="vc_bi" minlength="14"
        maxlength="14" placeholder="Bilhete de Identidade" required>
</div>
<div class="col-md-4">
    <label for="vc_telefone" class="form-label">Telefone</label>
    <input type="tel" class="form-control border-secondary"
        value="{{ isset($funcionario->vc_telefone) ? $funcionario->vc_telefone : '+244 9' }}" name="vc_telefone" minlength="14"
        maxlength="14" placeholder="+xxx 9xxxxxxxx" required>
</div>
<div class="col-md-4">
    <label for="vc_funcao" class="form-label">Função</label>
    <select type="text" class="form-control border-secondary" name="vc_funcao" required>
        @isset($funcionario)
            <option value="{{ $funcionario->vc_funcao }}">{{ $funcionario->vc_funcao }}</option>
        @else
            <option disabled value="" selected>Selecione a função</option>
        @endisset
        <option value="Admin de Sistemas">Admin de Sistemas</option>
        <option value="Administrador">Administrador</option>
        <option value="Administrativa">Administrativa</option>
        <option value="Administrativo">Administrativo</option>
        <option value="Auxiliar de Limpeza">Auxiliar de Limpeza</option>
        <option value="Bibliotecária">Bibliotecária</option>
        <option value="Bibliotecário">Bibliotecário</option>
        <option value="Chefe de Depart. RH">Chefe de Depart. RH</option>
        <option value="Chefe de Departamento">Chefe de Departamento</option>
        <option value="Chefe da Secretaria Geral">Chefe da Secretaria Geral</option>
        <option value="Chefe da Comissão Geral">Chefe da Comissão Geral</option>
     
        <option value="Director Geral">Director Geral</option>
        <option value="Directora Geral">Directora Geral</option>
        <option value="Docente">Docente</option>
        <option value="Electricista">Electricista</option>
        <option value="Estafeta">Estafeta</option>
        <option value="Jardineira">Jardineira</option>
        <option value="Jardineiro">Jardineiro</option>
        <option value="Recepcionista">Recepcionista</option>
        <option value="Repógrafo">Repógrafo</option>
        <option value="Segurança">Segurança</option>
        <option value="Serralheiro">Serralheiro</option>
        <option value="Sub Director Pedagógico">Sub Director Pedagógico</option>
        <option value="Sub Directora Pedagógica">Sub Directora Pedagógica</option>

        <option value="Sub Dir. Administrativo">Sub Dir. Administrativo</option>

        <option value="Técnico de Frio">Técnico de Frio</option>
        <option value="Técnico de TI">Técnico de TI</option>

    </select>
</div>

<div class="col-md-4">
    <label for="ya_anoValidade" class="form-label">Válido até</label>
    <input type="number" class="form-control border-secondary"
        value="{{ isset($funcionario->ya_anoValidade) ? $funcionario->ya_anoValidade : date('Y') + (isset($anoValidade->it_qtAno)?$anoValidade->it_qtAno:0) }}"
        name="ya_anoValidade" placeholder="Válido Ate" >
</div>
<div class="col-md-4">
    <label for="dt_nascimento" class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control border-secondary" required
        value="{{ isset($funcionario->dt_nascimento) ? $funcionario->dt_nascimento : '' }}"
        max="<?php echo date('Y-m-d'); ?>" min="1921-01-01" name="dt_nascimento">
</div>
<div class="col-md-4">
    <label for="dt_nascimento" class="form-label">Fotografia</label>
    <input name="vc_foto" type="file" id="file" class="form-control border-secondary"
    value="{{ isset($funcionario->vc_foto) ? $funcionario->vc_foto : '' }}">
</div>

<style>
    .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
    }

    .file-input label {
        display: block;
        position: relative;
        height: 50px;
        border-radius: 6px;
        background: linear-gradient(40deg, #343a41, #343a41);
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform .2s ease-out;
        top: 3px;
        width: auto;
    }

</style>

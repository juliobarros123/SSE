<div class="form-group col-sm-2">
    <label class="form-label">Processo</label>
    <input type="number" class="form-control border-secondary" autocomplete="off"  placeholder="Processo" value="{{ isset($aluno->id) ? $aluno->id : '' }}" name="id">
</div>
<div class="form-group col-sm-3">
    <label class="form-label">Primeiro Nome</label>
    <input type="text" class="form-control border-secondary "  placeholder="Primeiro nome"
        name="vc_primeiroNome" value="{{ isset($aluno->vc_primeiroNome) ? $aluno->vc_primeiroNome : '' }}">
</div>

<div class="form-group col-sm-4">
    <label class="form-label">Nomes do Meio</label>
    <input type="text" class="form-control border-secondary"  placeholder="Nomes do Meio" name="vc_nomedoMeio"
        value="{{ isset($aluno->vc_nomedoMeio) ? $aluno->vc_nomedoMeio : '' }}">
</div>

<div class="form-group col-sm-3">
    <label class="form-label">Apelido</label>
    <input type="text" class="form-control border-secondary"  placeholder="Apelido" name="vc_apelido"
        value="{{ isset($aluno->vc_ultimoaNome) ? $aluno->vc_ultimoaNome : '' }}">
</div>
<div class="form-group col-sm-6">
    <label class="form-label">Nome do Pai</label>
    <input type="text" class="form-control border-secondary"  placeholder="Nome do Pai candidato"
        name="vc_nomePai" value="{{ isset($aluno->vc_namePai) ? $aluno->vc_namePai : '' }}">
</div>

<div class="form-group col-sm-6">
    <label>Nome da Mãe</label>
    <input type="text" class="form-control border-secondary"  placeholder="Nome Mae do candidato"
        name="vc_nomeMae" value="{{ isset($aluno->vc_nameMae) ? $aluno->vc_nameMae : '' }}">
</div>

<div class="form-group col-sm-2">
    <label class="form-label">Classe Inicial</label>
    <input type="text" class="form-control border-secondary"  placeholder="Informe a classe" name="vc_classe"
        value="{{ isset($aluno->vc_classe) ? $aluno->vc_classe : '' }}" value="">
</div>

<div class="form-group col-sm-3">
    <label class="form-label">Data de Nascimento</label>
    <input type="date" class="form-control border-secondary"  name="dt_dataNascimento"
        value="{{ isset($aluno->dt_dataNascimento) ? $aluno->dt_dataNascimento : '' }}">
</div>
<div class="form-group col-sm-7">
    <label class="form-label">Residencia</label>
    <input type="text" class="form-control border-secondary"  placeholder="Residencia" name="vc_residencia"
        value="{{ isset($aluno->vc_residencia) ? $aluno->vc_residencia : '' }}">
</div>

<div class="form-group col-sm-4">
    <label class="form-label">Naturalidade</label>
    <input type="text" class="form-control border-secondary"  placeholder="Naturalidade" name="vc_naturalidade"
        value="{{ isset($aluno->vc_naturalidade) ? $aluno->vc_naturalidade : '' }}">
</div>

<div class="form-group col-sm-3">
    <label class="form-label">Província</label>
    <input type="text" class="form-control border-secondary"  placeholder="Província" name="vc_provincia"
        value="{{ isset($aluno->vc_provincia) ? $aluno->vc_provincia : '' }}">
</div>



<div class="form-group col-sm-2">
    <label class="form-label">Dificiência Física?</label>
    <input type="text" class="form-control border-secondary"  placeholder="Dificiência" name="vc_dificiencia"
        value="{{ isset($aluno->vc_dificiencia) ? $aluno->vc_dificiencia : '' }}">
</div>

<div class="form-group col-sm-3">
    <label class="form-label">Estado Civil</label>
    <input type="text" class="form-control border-secondary"  placeholder="Estado Civil" name="vc_estadoCivil"
        value="{{ isset($aluno->vc_estadoCivil) ? $aluno->vc_estadoCivil : '' }}">
</div>

<div class="form-group col-sm-2">
    <label class="form-label">Genero</label>
    <input type="text" class="form-control border-secondary"  placeholder="Genero" name="vc_genero"
        value="{{ isset($aluno->vc_genero) ? $aluno->vc_genero : '' }}">
</div>
<div class="form-group col-sm-2">
    <label class="form-label">Telefone</label>
    <input type="text" class="form-control border-secondary"  placeholder="Telefone" name="it_telefone"
        value="{{ isset($aluno->it_telefone) ? $aluno->it_telefone : '' }}">
</div>
<div class="form-group col-sm-4">
    <label class="form-label">Email</label>
    <input type="email" class="form-control border-secondary"  placeholder="Email Candidato" name="vc_email"
        value="{{ isset($aluno->vc_email) ? $aluno->vc_email : '' }}">
</div>


<div class="form-group col-sm-4">
    <label class="form-label">Bilhete de Identidade</label>
    <input type="text" class="form-control border-secondary"  placeholder="Número do bilhete de identidade"
        name="vc_bi" value="{{ isset($aluno->vc_bi) ? $aluno->vc_bi : '' }}">
</div>

<div class="form-group col-sm-4">
    <label class="form-label">Date de Emissão</label>
    <input type="date" class="form-control border-secondary"
        placeholder="Date de Emissão do Bilhete de identidade" name="dt_emissao"
        value="{{ isset($aluno->dt_emissao) ? $aluno->dt_emissao : '' }}">
</div>

<div class="form-group col-sm-4">
    <label for="vc_localEmissao" class="form-label">Local Emissão do Bilhete de Identidade</label>
    <input type="text" class="form-control border-secondary"  placeholder="Local de Emissão do BI"
        name="vc_localEmissao" value="{{ isset($aluno->vc_localEmissao) ? $aluno->vc_localEmissao : '' }}">
</div>
<div class="form-group col-sm-4">
    <label class="form-label">Escola Anterior</label>
    <input type="text" class="form-control border-secondary"  placeholder="Escola Anterior"
        name="vc_EscolaAnterior" value="{{ isset($aluno->vc_EscolaAnterior) ? $aluno->vc_EscolaAnterior : '' }}">
</div>

<div class="form-group col-sm-2">
    <label class="form-label">Ano de conclusão</label>
    <input type="text" class="form-control border-secondary"  placeholder="Ano de conclusão"
        name="ya_anoConclusao" value="{{ isset($aluno->ya_anoConclusao) ? $aluno->ya_anoConclusao : '' }}">
</div>

{{-- <div class="form-group col-sm-4">
    <label class="form-label">Curso escolhido</label>
    <input type="text" class="form-control border-secondary"  placeholder="Curso Selecionando"
        name="vc_nomeCurso" value="{{ isset($aluno->vc_nomeCurso) ? $aluno->vc_nomeCurso : '' }}">
</div> --}}
<div class="form-group col-md-5">
    <label for="vc_nomeCurso" class="form-label">Curso:</label>
    <select name="vc_nomeCurso" id="vc_nomeCurso" class="form-control">
        <option value="Todos">Todos</option>
        @foreach ($cursos as $curso)
        @if($aluno->vc_nomeCurso==$curso->vc_nomeCurso)
        <option selected value="{{ $curso->vc_nomeCurso }}">
            {{ $curso->vc_nomeCurso }}
        </option>
        @endif
            <option value="{{ $curso->vc_nomeCurso }}">
                {{ $curso->vc_nomeCurso }}
            </option>
        @endforeach
    </select>

</div>

<div class="form-group col-sm-4">
    <label class="form-label">Ano Lectivo de Candidatura</label>
    <input type="text" class="form-control border-secondary"  placeholder="Ano Lectivo de candidatura"
        name="vc_anoLectivo" value="{{ isset($aluno->vc_anoLectivo) ? $aluno->vc_anoLectivo : '' }}">
</div>
<div class="form-group col-sm-2">
    <label class="form-label">Nota de Ingresso</label>
    <input type="number" class="form-control border-secondary" max="20" min="1" placeholder="Nota de Ingresso" autocomplete="off"
        name="it_media" value="{{ isset($aluno->it_media) ? $aluno->it_media : '' }}"  >
</div>
<input type="hidden" value="{{ isset($aluno->tokenKey) ? $aluno->tokenKey : '' }}" name="tokenKey" >
<input type=button class=hide value="Adicionar outro">

<style>
    .hide {
        display: none;
    }

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
<div class="file-field input-field col-md-12">
    <div class="form-group">
        <div class="file-input ">
            <input name="vc_imagem" type="file" id="file" class="file"
                value="{{ isset($matricula->vc_imagem) ? $matricula->vc_imagem : '' }}" size="50MB image/*" >
            <label for="file"><i class="fas fa-camera mr-2"></i> Carregar foto</label>
        </div>
    </div>
</div>

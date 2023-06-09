<div class="row p-4">
    <div class="form-group col-md-4">
        <label for="vc_primeiroNome" class="form-label">Primeiro Nome <small class="campo-obrigatorio">*</small></label>
        <input type="text" class="form-control" name="vc_primeiroNome" class="form-control" id="vc_primeiroNome"
            autocomplete="off" placeholder="Primeiro Nome" required />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_nomedoMeio" class="form-label">Nomes do Meio</label>
        <input type="text" class="form-control" name="vc_nomedoMeio" class="form-control" id="vc_nomedoMeio"
            autocomplete="off" placeholder="Nomes do Meio" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_apelido" class="form-label">Último Nome <small class="campo-obrigatorio">*</small></label>
        <input type="text" class="form-control" name="vc_apelido" id="vc_apelido" class="form-control"
            autocomplete="off" placeholder="Ultimo Nome" required />
    </div>


    <div class="form-group col-md-4">
        <label for="vc_nomePai" class="form-label">Nome do Pai </label>
        <input type="text" class="form-control" name="vc_nomePai" class="form-control" id="vc_nomePai"
            autocomplete="off" placeholder="Nome do Pai" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_nomeMae" class="form-label">Nome da Mãe </label>
        <input type="text" class="form-control" name="vc_nomeMae" class="form-control" id="vc_nomeMae"
            autocomplete="off" placeholder="Nome da Mãe" />
    </div>



    <div class="form-group col-md-4">
        <label for="gender">Gênero <small class="campo-obrigatorio">*</small></label>

        <select class="form-control" name="vc_genero" required>
            <option value="" selected disabled>Selecione o Gênero</option>
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
        </select>


    </div>
    @if ($idadesdecandidaturas)
        <div class="form-group col-md-4">
            <div class="form-date">
                <label for="dt_dataNascimento" class="form-label">Data de Nascimento <small
                        class="campo-obrigatorio">*</small></label>
                <input type="date" class="form-control" name="dt_dataNascimento" id="dt_dataNascimento"
                    max="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limiteaesquerda)); ?>" min="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limitemaxima)); ?>" required />
            </div>
        </div>
    @else
        <div class="form-group col-md-4">
            <div class="form-date">
                <label for="dt_dataNascimento" class="form-label">Data de Nascimento <small
                        class="campo-obrigatorio">*</small></label>
                <input type="date" class="form-control" name="dt_dataNascimento" id="dt_dataNascimento" required />
            </div>
        </div>
    @endif



    <div class="form-group col-md-4">
        <label for="vc_estadoCivil" class="form-label">Estado Civil</label>

        <select class="form-control" name="vc_estadoCivil">
            <option value="" selected disabled>Selecione uma opção</option>
            <option value="Casado(a)">Casado(a)</option>
            <option value="Solteiro(a)">Solteiro(a)</option>
            {{-- <option value="Viuvo(a)">Viuvo(a)</option> --}}
        </select>

    </div>




    <div class="form-group col-md-4">
        <label for="vc_bi" class="form-label">B.I/Cédula</label>
        <input type="text" class="form-control" class="form-control" name="vc_bi" {{-- id="vc_bi" --}}
            minlength="14" maxlength="14" min="14" max="14" placeholder="Nº do Bilhete de B.I/Cédula"
            autocomplete="off" />
    </div>
    <div class="form-group col-md-4">
        <label for="dt_emissao" class="form-label">Data de Emissão do Bilhete de
            Identidade </label>
        <input type="date" class="form-control" class="form-control" name="dt_emissao" id="dt_emissao"
            max="<?php echo date('Y-m-d'); ?>" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_localEmissao" class="form-label">Local Emissão do Bilhete de Identidade
        </label>

        <select class="form-control" name="vc_localEmissao" class="form-control" id="vc_localEmissao">
            <option value="" selected disabled>Selecione uma provincia</option>
            @foreach ($provincias as $provincia)
                <option value="{{ $provincia['vc_nome'] }}">{{ $provincia['vc_nome'] }}</option>
            @endforeach
        </select>

    </div>



    <div class="form-group col-md-4">
        <label for="vc_residencia" class="form-label">Residência</label>
        <input type="text" class="form-control" class="form-control" name="vc_residencia" id="vc_residencia"
            placeholder="Residência" autocomplete="off"  />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_naturalidade" class="form-label">Naturalidade</label>
        <input type="text" class="form-control" class="form-control" name="vc_naturalidade" id="vc_naturalidade"
            placeholder="Natural de" autocomplete="off"  />
    </div>

    <div class="form-group col-md-4">
        <label for="vc_provincia" class="form-label">Província <small class="campo-obrigatorio">*</small></label>
{{-- @dump($provincias ) --}}
        <select class="form-control" name="vc_provincia"  id="vc_provincia" required>
            <option value="" selected disabled>Selecione uma provincia</option>
            @foreach ($provincias as $provincia)
                <option value="{{ $provincia->vc_nome }}">{{ $provincia->vc_nome }}</option>
            @endforeach
        </select>

    </div>


    <div class="form-group col-md-4">
        <label for="el_email" class="form-label">E-mail</label>
        <input type="email" class="form-control" class="form-control" name="vc_email" id="vc_email"
            placeholder="E-mail" autocomplete="off" />
    </div>
    <div class="form-group col-md-4">
        <label for="it_telefone" class="form-label">Telefone</label>
        <input type="number" class="form-control" name="it_telefone" id="it_telefone" placeholder="Telefone"
            min="900000000" max="1000000000" maxlength="9" autocomplete="off" />
    </div>


    <div class="form-group col-md-4">
        <label for="id_curso" class="form-label">Curso à se Candidatar <small class="campo-obrigatorio">*</small></label>
{{-- @dump($cursos) --}}
        <select class="form-control" name="id_curso" id="id_curso">
            <option value="" selected disabled>Selecione um curso</option>
            @foreach ($cursos as $curso)
                <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }}</option>
            @endforeach
        </select>

    </div>
{{-- @dump($classes) --}}

    <div class="form-group col-md-4">
        <label for="id_classe" class="form-label">Classe à se Candidatar <small class="campo-obrigatorio">*</small></label>

        <select class="form-control" name="id_classe" id="id_classe" required>
            <option value="" selected disabled>Selecione uma classe</option>
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}ªclasse</option>
            @endforeach
        </select>

    </div>
    <div class="form-group col-md-4">
        <label for="media" class="form-label">Média da escola anterior</label>
        <input type="number" class="form-control" step="any" class="form-control" name="media"
            id="vc_naturalidade" placeholder="Média da escola anterior" autocomplete="off" />
    </div>
    <div class="form-group col-md-4">
        <label for="media" class="form-label">Escola anterior</label>
        <input type="text" class="form-control" class="form-control" name="vc_EscolaAnterior"
            id="vc_EscolaAnterior" placeholder="Escola anterior" autocomplete="off" />
    </div>
</div>

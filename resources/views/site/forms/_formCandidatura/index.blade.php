{{-- @dump($candidato) --}}
<div class="row p-4">
    <div class="form-group col-md-4">
        <label for="vc_primeiroNome" class="form-label">Primeiro Nome <small class="campo-obrigatorio">*</small></label>
        <input type="text" class="form-control" name="vc_primeiroNome" class="form-control" id="vc_primeiroNome"
            autocomplete="off" placeholder="Primeiro Nome"
            value="{{ isset($candidato) ? $candidato->vc_primeiroNome : ' ' }}" required />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_nomedoMeio" class="form-label">Nomes do Meio</label>
        <input type="text" class="form-control" name="vc_nomedoMeio" class="form-control" id="vc_nomedoMeio"
            autocomplete="off" placeholder="Nomes do Meio"
            value="{{ isset($candidato) ? $candidato->vc_nomedoMeio : ' ' }}" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_apelido" class="form-label">Último Nome <small class="campo-obrigatorio">*</small></label>
        <input type="text" class="form-control" name="vc_apelido" id="vc_apelido" class="form-control"
            autocomplete="off" placeholder="Ultimo Nome" value="{{ isset($candidato) ? $candidato->vc_apelido : ' ' }}"
            required />
    </div>


    <div class="form-group col-md-4">
        <label for="vc_nomePai" class="form-label">Nome do Pai </label>
        <input type="text" class="form-control" name="vc_nomePai" class="form-control" id="vc_nomePai"
            autocomplete="off" placeholder="Nome do Pai"
            value="{{ isset($candidato) ? $candidato->vc_nomePai : ' ' }}" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_nomeMae" class="form-label">Nome da Mãe </label>
        <input type="text" class="form-control" name="vc_nomeMae" class="form-control" id="vc_nomeMae"
            autocomplete="off" placeholder="Nome da Mãe"
            value="{{ isset($candidato) ? $candidato->vc_nomeMae : ' ' }}" />
    </div>



    <div class="form-group col-md-4">
        <label for="gender">Gênero <small class="campo-obrigatorio">*</small></label>

        <select class="form-control" name="vc_genero" required>
            @isset($candidato)
                <option value="{{ $candidato->vc_genero }}">{{ $candidato->vc_genero }}</option>
            @else
                <option value="" selected disabled>Selecione o Gênero</option>
            @endisset
            <option value="Masculino">Masculino</option>
            <option value="Feminino">Feminino</option>
        </select>


    </div>
    {{-- @dump($idadesdecandidaturas) --}}

        

    @if (isset($candidato))
        @php
       
            $idadesdecandidaturas = fh_idades_admissao_2()
                ->where('id_ano_lectivo', $candidato->id_ano_lectivo)
                ->first();
                // dd(   $idadesdecandidaturas);
        @endphp
    @else
        @php
            $idadesdecandidaturas = fh_idades_admissao()->first();
        @endphp
    @endif

    @if ($idadesdecandidaturas)
        <div class="form-group col-md-4">
            <div class="form-date">
                <label for="dt_dataNascimento" class="form-label">Data de Nascimento <small
                        class="campo-obrigatorio">*</small></label>
                <input type="date" class="form-control" name="dt_dataNascimento" id="dt_dataNascimento"
                    value="{{ isset($candidato) ? $candidato->dt_dataNascimento : ' ' }}" max="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limiteaesquerda)); ?>"
                    min="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limitemaxima)); ?>" required />
                <span>Dos
                    {{ calcularIdade($idadesdecandidaturas->dt_limiteaesquerda) }}({{ converterDataSemHora($idadesdecandidaturas->dt_limiteaesquerda) }})
                    aos
                    {{ calcularIdade($idadesdecandidaturas->dt_limitemaxima) }}({{ converterDataSemHora($idadesdecandidaturas->dt_limitemaxima) }})
                    de idade </span>
            </div>
        </div>
    @else
        <div class="form-group col-md-4">
            <div class="form-date">
                <label for="dt_dataNascimento" class="form-label">Data de Nascimento <small
                        class="campo-obrigatorio">*</small></label>
                <input type="date" class="form-control" name="dt_dataNascimento" id="dt_dataNascimento"
                    value="{{ isset($candidato) ? $candidato->dt_dataNascimento : ' ' }}" required />

                <span>Dos
                    {{ calcularIdade($idadesdecandidaturas->dt_limiteaesquerda) }}({{ converterDataSemHora($idadesdecandidaturas->dt_limiteaesquerda) }})
                    aos
                    {{ calcularIdade($idadesdecandidaturas->dt_limitemaxima) }}({{ converterDataSemHora($idadesdecandidaturas->dt_limitemaxima) }})
                    de idade </span>
            </div>
        </div>
    @endif



    <div class="form-group col-md-4">
        <label for="vc_estadoCivil" class="form-label">Estado Civil</label>
        {{-- @dump($candidato) --}}
        <select class="form-control" name="vc_estadoCivil">
            @isset($candidato)
                <option value="{{ $candidato->vc_estadoCivil }}">{{ $candidato->vc_estadoCivil }}</option>
            @else
                <option value="" selected disabled>Selecione uma opção</option>
            @endisset
            <option value="Casado(a)">Casado(a)</option>
            <option value="Solteiro(a)">Solteiro(a)</option>
            {{-- <option value="Viuvo(a)">Viuvo(a)</option> --}}
        </select>

    </div>




    <div class="form-group col-md-4">
        <label for="vc_bi" class="form-label">B.I/Cédula</label>
        <input type="text" class="form-control" class="form-control"
            value="{{ isset($candidato) ? $candidato->vc_bi : ' ' }}" name="vc_bi" {{-- id="vc_bi" --}}
            minlength="14" maxlength="14" min="14" max="14" placeholder="Nº do Bilhete de B.I/Cédula"
            autocomplete="off" />
    </div>
    <div class="form-group col-md-4">
        <label for="dt_emissao" class="form-label">Data de Emissão do Bilhete de
            Identidade </label>
        <input type="date" class="form-control" class="form-control" name="dt_emissao" id="dt_emissao"
            max="<?php echo date('Y-m-d'); ?>" value="{{ isset($candidato) ? $candidato->dt_emissao : ' ' }}" />
    </div>

    <div class="form-group col-md-4">
        <label for="vc_localEmissao" class="form-label">Local Emissão do Bilhete de Identidade
        </label>
        <select class="form-control" name="vc_localEmissao" class="form-control" id="vc_localEmissao">
            @isset($candidato)
                <option value="{{ $candidato->vc_localEmissao }}">{{ $candidato->vc_localEmissao }}</option>
            @else
                <option value="" selected disabled>Selecione uma provincia</option>
            @endisset
            @foreach (fh_provincias()->get() as $provincia)
                <option value="{{ $provincia['vc_nome'] }}">{{ $provincia['vc_nome'] }}</option>
            @endforeach
        </select>
    </div>

    <div class="form-group col-md-4">
        <label for="vc_residencia" class="form-label">Residência</label>
        <input type="text" class="form-control" class="form-control" name="vc_residencia" id="vc_residencia"
            value="{{ isset($candidato) ? $candidato->vc_residencia : '' }}" placeholder="Residência"
            autocomplete="off" />
    </div>
    <div class="form-group col-md-4">
        <label for="vc_naturalidade" class="form-label">Naturalidade</label>
        <input type="text" class="form-control" class="form-control" name="vc_naturalidade" id="vc_naturalidade"
            value="{{ isset($candidato) ? $candidato->vc_naturalidade : '' }}" placeholder="Natural de"
            autocomplete="off" />
    </div>

    <div class="form-group col-md-4">
        <label for="vc_provincia" class="form-label ">Província <small class="campo-obrigatorio  ">*</small></label>
        {{-- @dump($provincias ) --}}
        <select class="form-control select-dinamico" name="vc_provincia" id="id_provincia" required>
            @isset($candidato)
                <option value="{{ $candidato->vc_provincia }}">{{ $candidato->vc_provincia }}</option>
            @else
                <option value="" selected disabled>Selecione uma provincia</option>
            @endisset

            @foreach (fh_provincias()->get() as $provincia)
                <option value="{{ $provincia->vc_nome }}">{{ $provincia->vc_nome }}</option>
            @endforeach
        </select>

    </div>

    <div class="form-group col-sm-4">
        <label for="" class="form-label">Municipio</label>
        <select class="form-control select-dinamico " name="vc_municipio" id="id_municipio" required>
            <option value="{{ isset($candidato) ? $candidato->vc_municipio : '' }}" selected>
                {{ isset($candidato) ? $candidato->vc_municipio : 'Selecione o Municipio:' }}</option>
            @foreach (fha_municipios() as $municipio)
                <option value="{{ $municipio->vc_nome }}">{{ $municipio->vc_nome }} </option>
            @endforeach
        </select>
    </div>
    <div class="form-group col-md-4">
        <label for="el_email" class="form-label">E-mail</label>
        <input type="email" class="form-control" class="form-control" name="vc_email" id="vc_email"
            placeholder="E-mail" autocomplete="off" value="{{ isset($candidato) ? $candidato->vc_email : '' }}" />
    </div>
    <div class="form-group col-md-4">
        <label for="it_telefone" class="form-label">Telefone</label>
        <input type="number" class="form-control" name="it_telefone" id="it_telefone" placeholder="Telefone"
            min="900000000" max="1000000000" maxlength="9" autocomplete="off"
            value="{{ isset($candidato) ? $candidato->it_telefone : '' }}" />
    </div>


    <div class="form-group col-md-4">
        <label for="id_curso" class="form-label">Curso à se Candidatar <small
                class="campo-obrigatorio">*</small></label>
        {{-- @dump($cursos) --}}
        <select class="form-control" name="id_curso" id="id_curso" required>
            @isset($candidato)
                <option value="{{ $candidato->id_curso }}">{{ $candidato->vc_nomeCurso }}</option>
            @else
                <option value="" selected disabled>Selecione um curso</option>
            @endisset

            @foreach (fh_cursos()->get() as $curso)
                <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }}</option>
            @endforeach
        </select>

    </div>
    {{-- @dump($classes) --}}

    <div class="form-group col-md-4">
        <label for="id_classe" class="form-label">Classe à se Candidatar <small
                class="campo-obrigatorio">*</small></label>

        <select class="form-control" name="id_classe" id="id_classe" required>
            @isset($candidato)
                <option value="{{ $candidato->id_classe }}">{{ $candidato->vc_classe }}ªclasse</option>
            @else
                <option value="" selected disabled>Selecione uma classe</option>
            @endisset

            @foreach (fh_classes()->get() as $classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}ªclasse</option>
            @endforeach
        </select>

    </div>
    <div class="form-group col-md-4">
        <label for="media" class="form-label">Média da escola anterior</label>
        <input type="number" class="form-control" step="any" class="form-control" name="media"
            id="vc_naturalidade" placeholder="Média da escola anterior" autocomplete="off"
            value="{{ isset($candidato) ? $candidato->vc_naturalidade : '' }}" />
    </div>
    <div class="form-group col-md-4">
        <label for="media" class="form-label">Escola anterior</label>
        <input type="text" class="form-control" class="form-control" name="vc_EscolaAnterior"
            id="vc_EscolaAnterior" placeholder="Escola anterior" autocomplete="off"
            value="{{ isset($candidato) ? $candidato->vc_EscolaAnterior : '' }}" />
    </div>
</div>

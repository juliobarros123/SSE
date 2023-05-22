<div class="panel panel-default active">
    <div class="d-flex justify-content-center">
        <a href="{{url('/')}}" class="brand-link">
            <img src="{{asset("/$caminhoLogo")}}" alt="Logo" height="100"
                class=" brand-image img-circle bg-white elevation-3">

            </span></a>
    </div>
    <div class="panel-heading" id="headingOne">
        <h3>
            <a href="#collapseOne" data-toggle="collapse" data-parent="#accordion">
                Dados
            </a>
        </h3>
    </div>

    <div id="collapseOne" class="panel-collapse collapse in">
        <div class="panel-body">

            <div class="col-md-12">
                <input type="file" name="foto">
            </div>

            <div class="row">
                <div class="form-group col-md-4">
                    <label for="vc_bi" class="form-label">Bilhete de Identidade </label>
                    <input type="text" class="border-secondary" class="border-secondary" name="vc_bi" id="vc_bi"
                        minlength="14" maxlength="14" placeholder="Nº do Bilhete de Identidade" autocomplete="off" />
                </div>
                <div class="form-group col-md-4">
                    <label class="form-label">Processo*</label>
                    <input type="number" class="border-secondary" name="it_processo" class="border-secondary"
                        id="it_processo" autocomplete="off" placeholder="Processo" required />
                </div>


                <div class="form-group col-md-4">
                    <label for="vc_primeiroNome" class="form-label">Primeiro Nome *</label>
                    <input type="text" class="border-secondary" name="vc_primeiroNome" class="border-secondary"
                        id="vc_primeiroNome" autocomplete="off" placeholder="Primeiro Nome" required />
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_nomedoMeio" class="form-label">Nomes do Meio</label>
                    <input type="text" class="border-secondary" name="vc_nomedoMeio" class="border-secondary"
                        id="vc_nomedoMeio" autocomplete="off" placeholder="Nomes do Meio" />
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_apelido" class="form-label">Apelido *</label>
                    <input type="text" class="border-secondary" name="vc_ultimoaNome" id="vc_apelido"
                        class="border-secondary" autocomplete="off" placeholder="Apelido" required />
                </div>









                <div class="form-group col-md-4">
                    <label for="vc_nomePai" class="form-label">Nome do Pai <small>(deixar em
                            branco se não tiver)</small></label>
                    <input type="text" class="border-secondary" name="vc_namePai" class="border-secondary"
                        id="vc_nomePai" autocomplete="off" placeholder="Nome do Pai" />
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_nomeMae" class="form-label">Nome da Mãe <small>(deixar em
                            branco se não tiver)</small></label>
                    <input type="text" class="border-secondary" name="vc_nameMae" class="border-secondary"
                        id="vc_nomeMae" autocomplete="off" placeholder="Nome da Mãe" />
                </div>



                <!-- <div class="form-group col-md-4">

                    <label>Sexo *</label>

                    <input type="input" class="border-secondary" name="vc_genero" class="border-secondary"
                        id="vc_genero" />

                </div> -->

                <div class="form-radio col-md-4">
                            <label for="gender">Gênero *</label>

                            <div class="select-group" class="border-secondary" id="vc_genero">
                                <select class="border-secondary" name="vc_genero" required>
                                    <option value="" selected disabled>Selecione o Gênero</option>
                                    <option value="Masculino">Masculino</option>
                                    <option value="Feminino">Feminino</option>
                                </select>
                            </div>

                        </div>

                <div class="form-group col-md-4">
                    <label for="dt_dataNascimento" class="form-label">Data de Nascimento *</label>
                    <input type="date" class="border-secondary" class="border-secondary" name="dt_dataNascimento"
                        id="dt_dataNascimento" max="<?php echo date('Y-m-d'); ?>" required />
                </div>




                <div class="form-group col-md-4">
                    <label for="vc_estadoCivil" class="form-label">Estado Civil *</label>
                    <div class="select-group" class="border-secondary">

                        <input type="input" class="border-secondary" name="vc_estadoCivil" class="border-secondary"
                            id="vc_estadoCivil" />
                    </div>
                </div>

                <div class="form-group col-md-4">
                    <label for="vc_dificiencia" class="form-label">Portador de Deficiêcia Física? *</label>

                    <select class="border-secondary" name="vc_dificiencia" class="border-secondary" required>
                        <option value="" selected disabled>Selecione uma opção</option>
                        <option value="Não">Não</option>
                        <option value="Sim">Sim</option>
                    </select>

                </div>




                <div class="form-group col-md-4">
                    <label for="dt_emissao" class="form-label">Data de Emissão do Bilhete de
                        Identidade </label>
                    <input type="date" class="border-secondary" class="border-secondary" name="dt_emissao"
                        id="dt_emissao" max="<?php echo date('Y-m-d'); ?>"  />
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_localEmissao" class="form-label">Local Emissão do Bilhete de Identidade
                        </label>


                    <input type="text" name="vc_localEmissao" id="vc_localEmissao" class="border-secondary">
                </div>



                <div class="form-group col-md-4">
                    <label for="vc_residencia" class="form-label">Residência *</label>
                    <input type="text" class="border-secondary" class="border-secondary" name="vc_residencia"
                        id="vc_residencia" placeholder="Residência" autocomplete="off" required />
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_naturalidade" class="form-label">Natural de *</label>
                    <input type="text" class="border-secondary" class="border-secondary" name="vc_naturalidade"
                        id="vc_naturalidade" placeholder="Natural de" autocomplete="off" required />
                </div>

                <div class="form-group col-md-4">
                    <label for="vc_provincia" class="form-label">Provincia de *</label>
                    <div class="select-group">
                        <input class="border-secondary" name="vc_provincia" class="border-secondary" id="vc_provincia">
                    </div>
                </div>



                <div class="form-group col-md-4">
                    <label for="el_email" class="form-label">E-mail</label>
                    <input type="email" class="border-secondary" class="border-secondary" name="vc_email" id="vc_email"
                        placeholder="E-mail" autocomplete="off" />
                </div>
                <div class="form-group col-md-4">
                    <label for="it_telefone" class="form-label">Telefone *</label>
                    <input type="number" class="border-secondary" name="it_telefone" id="it_telefone"
                        placeholder="Telefone" min="900000000" max="1000000000" maxlength="9" autocomplete="off"
                        required />
                </div>

                <div class="form-select col-md-4">
                    <label for="it_classe" class="form-label">Classe de Candidatura *</label>
                    <div class="select-group">
                        <select class="border-secondary" name="it_classe" id="it_classe" required>
                            <option value="" selected disabled>Selecione a classe</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->vc_classe }}">{{ $classe->vc_classe }}ª Classe</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-select col-md-4">
                    <label for="it_classeConclusao" class="form-label">Classe de Conclusão *</label>
                    <div class="select-group">
                        <select class="border-secondary" name="it_classeConclusao" id="it_classeConclusao" required>
                            <option value="" selected disabled>Selecione a classe</option>
                            @foreach ($classes as $classe)
                                <option value="{{ $classe->vc_classe }}">{{ $classe->vc_classe }}ª classe</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- <div class="form-group col-md-4">
                    <label for="it_classe" class="form-label">Classe de conclusão *</label>
                    <input type="number" class="border-secondary" name="it_classe" id="it_classe" placeholder="Classe"
                        min="10" max="13" maxlength="2" autocomplete="off" required />
                </div> -->

                <div class="form-group col-md-4">
                    <label for="vc_nomeCurso" class="form-label">Curso *</label>
                    <div class="select-group">
                        <select class="border-secondary" name="vc_nomeCurso" class="border-secondary" id="vc_nomeCurso"
                            required>
                            <option value="" selected disabled>Selecione um curso</option>
                            @foreach ($cursos as $curso)
                                <option value="{{ $curso->vc_nomeCurso }}">{{ $curso->vc_nomeCurso }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
{{--
                <div class="form-group col-md-4">
                    <label for="dt_anoCandidatura" class="form-label">Ano de Ingresso *</label>
                    <input type="date" class="border-secondary" class="border-secondary" name="dt_anoCandidatura" id=""
                    required />
                </div> --}}

                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>

                    @if (isset($ano_lectivo_publicado))
                        <select name="dt_anoCandidatura" id="dt_anoCandidatura" class="form-control" readonly>
                            <option value="{{ $ano_lectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  " > Atenção: Ano lectivo publicado</p>

                    @else
                        <select name="dt_anoCandidatura" id="dt_anoCandidatura" class="form-control">
                            <option value="{{ isset($turma) ? $turma->it_idAnoLectivo : '' }}" selected>
                                {{ isset($turma) ? $turma->dt_anoCandidatura : 'Selecione o ano lectivo:' }}</option>
                            @foreach ($ano_letivos as $anolectivo)
                                <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim}}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>


                <div class="form-group col-md-4">
                    <label for="ya_anoConclusao" class="form-label">Ano de Conclusão *</label>
                    <input type="text" class="border-secondary" class="border-secondary" name="ya_anoConclusao" id="ya_anoConclusao"
                    maxlength="4"  minlength="4" placeholder="1999"  required/>
                </div>
            </div>


        </div>
    </div>
</div>

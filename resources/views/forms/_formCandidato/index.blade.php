 <div class="form-group col-md-2">
     <label for="id" class="form-label">Inscrição Nº:</label>
     <input type="text" name="id" disabled id="id" class="form-control border-secondary"
         value="{{ $candidato->id }}" />
 </div>
 <div class="form-group col-md-2">
     <label for="vc_anoLectivo" class="form-label">Ano Lectivo</label>
     <input type="text" id="vc_anoLectivo" class="form-control border-secondary" disabled
         value="{{ $candidato->vc_anoLectivo }}" placeholder="Ano Lectivo" autocomplete="off" />
 </div>
 <div class="form-group col-md-2">
     <label for="vc_primeiroNome" class="form-label">Primeiro Nome</label>
     <input type="text" name="vc_primeiroNome" id="vc_primeiroNome" class="form-control border-secondary"
         value="{{ $candidato->vc_primeiroNome }}" />
 </div>
 <div class="form-group col-md-3">
     <label for="vc_nomedoMeio" class="form-label">Nomes do Meio</label>
     <input type="text" name="vc_nomedoMeio" id="vc_nomedoMeio" class="form-control border-secondary"
         value="{{ $candidato->vc_nomedoMeio }}" />
 </div>
 <div class="form-group col-md-2">
     <label for="vc_apelido" class="form-label">Apelido</label>
     <input type="text" name="vc_apelido" id="vc_apelido" class="form-control border-secondary"
         value="{{ $candidato->vc_apelido }}" />
 </div>
 <div class="form-group col-md-3">
     <label for="vc_datanascimento" class="form-label">Data de Nascimento</label>
@isset($idadesdecandidaturas->dt_limiteaesquerda)
<input type="date" name="vc_datanascimento" id="vc_datanascimento" class="form-control border-secondary"
         value="{{ $candidato->dt_dataNascimento }}"
         max="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limiteaesquerda)); ?>"
         min="<?php echo date('Y-m-d', strtotime($idadesdecandidaturas->dt_limitemaxima)); ?>" />
    @else
    <input type="date" name="vc_datanascimento" id="vc_datanascimento" class="form-control border-secondary"
    value="{{ $candidato->dt_dataNascimento }}"
     />
@endisset
     

 </div>

 <div class="form-group col-md-6">
     <label for="vc_nomePai" class="form-label">Nome do Pai <small>(deixar em
             branco se não tiver)</small></label>
     <input type="text" name="vc_nomePai" class="form-control border-secondary" id="vc_nomePai"
         value="{{ $candidato->vc_nomePai }}" />
 </div>
 <div class="form-group col-md-6">
     <label for="vc_nomeMae" class="form-label">Nome da Mãe <small>(deixar em
             branco se não tiver)</small></label>
     <input type="text" name="vc_nomeMae" class="form-control border-secondary" id="vc_nomeMae"
         value="{{ $candidato->vc_nomeMae }}" />
 </div>

 <div class="form-group col-md-3">
     <label for="vc_estadoCivil" class="form-label">Estado Civil</label>
     <select name="vc_estadoCivil" id="vc_estadoCivil" value="{{ $candidato->vc_estadoCivil }}"
         class="form-control border-secondary">
         <option value="" disabled>Selecione uma opção</option>
         <option value="Casado(a)" @if ($candidato->vc_estadoCivil == 'Casado(a)') selected @endif>Casado(a)</option>
         <option value="Solteiro(a)" @if ($candidato->vc_estadoCivil == 'Solteiro(a)') selected @endif>Solteiro(a)</option>
         <option value="Viuvo(a)" @if ($candidato->vc_estadoCivil == 'Viuvo(a)') selected @endif>Viuvo(a)</option>
     </select>
 </div>

 <div class="form-group col-md-3">
     <label for="vc_dificiencia" class="form-label">Deficiênte Físico?</label>
     <select name="vc_dificiencia" id="vc_dificiencia" value="{{ $candidato->vc_dificiencia }}"
         class="form-control border-secondary">
         <option value="" disabled>Selecione uma opção</option>
         <option value="Não" @if ($candidato->vc_dificiencia == 'Não') selected @endif>Não</option>
         <option value="Sim" @if ($candidato->vc_dificiencia == 'Sim') selected @endif>Sim</option>
     </select>

 </div>

 <div class="form-group col-md-3">
     <label for="vc_genero" class="form-label">Genero</label>
     <select name="vc_genero" id="vc_genero" value="{{ $candidato->vc_genero }}"
         class="form-control border-secondary">
         <option value="" disabled>Selecione uma opção</option>
         <option value="Masculino" @if ($candidato->vc_genero == 'Masculino') selected @endif>Masculino</option>
         <option value="Feminino" @if ($candidato->vc_genero == 'Feminino') selected @endif>Feminino</option>
     </select>
 </div>

 <div class="form-group col-md-3">
     <label for="vc_bi" class="form-label">Bilhete de Identidade</label>
     <input type="text" class="form-control border-secondary" name="vc_bi" id="vc_bi" minlength="14" maxlength="14"
         value="{{ $candidato->vc_bi }}" />
 </div>
 <div class="form-group col-md-3">
     <label for="dt_emissao" class="form-label">Data de Emissão do Bilhete de Identidade</label>
     <input type="date" name="dt_emissao" id="dt_emissao"
         max="<?php echo date('Y-m-d'); ?>" class="form-control border-secondary"
         value="{{ $candidato->dt_emissao }}" required />
 </div>
 <div class="form-group col-md-3">
     <label for="vc_localEmissao" class="form-label">Local Emissão do Bilhete de Identidade</label>
     <select name="vc_localEmissao" id="vc_localEmissao" required class="form-control border-secondary">
         <option value="" disabled>Selecione uma provincia</option>
         @foreach ($provincias as $provincia)
             <option value="{{ $provincia['nome'] }}" @if (isset($candidato->vc_localEmissao) && $candidato->vc_localEmissao == $provincia['nome']) selected @endif>{{ $provincia['nome'] }}
             </option>
         @endforeach
     </select>
 </div>
 <div class="form-group col-md-6">
     <label for="vc_residencia" class="form-label">Residência</label>
     <input type="text" name="vc_residencia" id="vc_residencia" class="form-control border-secondary"
         value="{{ $candidato->vc_residencia }}" placeholder="Residência" autocomplete="off" required />
 </div>

 <div class="form-group col-md-3">
     <label for="vc_naturalidade" class="form-label">Natural de</label>
     <input type="text" name="vc_naturalidade" value="{{ $candidato->vc_naturalidade }}"
         class="form-control border-secondary" id="vc_naturalidade" placeholder="Natural de" autocomplete="off"
         required />
 </div>

 <div class="form-group col-md-3">
     <label for="vc_provincia" class="form-label">Provincia de</label>
     <select name="vc_provincia" id="vc_provincia" required class="form-control border-secondary">
         <option value="" disabled>Selecione uma provincia</option>
         @foreach ($provincias as $provincia)
             <option value="{{ $provincia['nome'] }}" @if (isset($candidato->vc_provincia) && $candidato->vc_provincia == $provincia['nome']) selected @endif>{{ $provincia['nome'] }}
             </option>
         @endforeach
     </select>
 </div>
 <div class="form-group col-md-2">
     <label for="it_telefone" class="form-label">Telefone</label>
     <input type="number" name="it_telefone" id="it_telefone" class="form-control border-secondary"
         value="{{ $candidato->it_telefone }}" placeholder="Telefone" min="900000000" max="1000000000" maxlength="9"
         autocomplete="off" required />
 </div>
 <div class="form-group col-md-4">
     <label for="vc_email" class="form-label">Email</label>
     <input type="text" name="vc_email" id="vc_email" class="form-control border-secondary"
         value="{{ $candidato->vc_email }}" placeholder="Email" autocomplete="off" />
 </div>
 <div class="form-group col-md-3">
     <label for="vc_EscolaAnterior" class="form-label">Escola Anterior</label>
     <input type="text" name="vc_EscolaAnterior" id="vc_EscolaAnterior" class="form-control border-secondary"
         value="{{ $candidato->vc_EscolaAnterior }}" placeholder="Escola Anterior" autocomplete="off" />
 </div>
 <div class="form-group col-md-2">
     <label for="ya_anoConclusao" class="form-label">Ano de Conclusão</label>
     <input type="number" name="ya_anoConclusao" id="ya_anoConclusao" class="form-control border-secondary"
         value="{{ $candidato->ya_anoConclusao }}" placeholder="Ano de Conclusão" autocomplete="off" />
 </div>
 <div class="form-group col-md-3">
     <label for="vc_nomeCurso" class="form-label">Curso Escolhido</label>
     <select name="vc_nomeCurso" id="vc_nomeCurso" class="form-control border-secondary" required>
         <option value="" disabled>Selecione um curso</option>
         @foreach ($cursos as $curso)
             <option value="{{ $curso->vc_nomeCurso }}" @if (isset($candidato->vc_nomeCurso) && $candidato->vc_nomeCurso == $curso->vc_nomeCurso) selected @endif>{{ $curso->vc_nomeCurso }}
             </option>
         @endforeach
     </select>
 </div>
 <div class="form-group col-md-2">
     <label for="vc_classe" class="form-label">Classe Inicial</label>
     <select name="vc_classe" id="vc_classe" class="form-control border-secondary" required>
         <option value="" disabled>Selecione uma classe</option>
         @foreach ($classes as $classe)
             <option value="{{ $classe->vc_classe }}" @if (isset($candidato->vc_classe) && $candidato->vc_classe == $classe->vc_classe) selected @endif>{{ $classe->vc_classe }}ªclasse
             </option>
         @endforeach
     </select>
 </div>

 <div class="form-group col-md-2">
     <label for="created_at" class="form-label">Data de Inscrição</label>
     <input type="text" id="created_at" class="form-control border-secondary" disabled
         value="{{ date('H:m | d-m-Y', strtotime($candidato->created_at)) }}" placeholder="Ano Lectivo"
         autocomplete="off" />
 </div>
 <fieldset>
    <div class="container shadow-none">

        <div class="row">
            <!--Informe a nota de língua portuguesa-->
            <div class=" col-md-6">
                <div class="form-group">
                    <label>Informe a nota de:</label>
                    <input disabled value="Língua Portuguesa" type="text" class="form-control" id="inp22">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>7ª classe:</label>
                    <input required type="number" value="{{ $candidato->LP_S }}" min="0" max="20" class="form-control" id="inp23"
                        name="LP_S">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>8ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->LP_O }}" max="20" class="form-control" id="inp24"
                        name="LP_O">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>9ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->LP_N }}" max="20" class="form-control" id="inp25"
                        name="LP_N">
                </div>
            </div>
            <!--informe a nota de matemática-->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Informe a nota de:</label>
                    <input disabled value="Matemática" type="text" class="form-control" id="inp26">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>7ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->MAT_S }}" max="20" class="form-control" id="inp27"
                        name="MAT_S">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>8ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->MAT_O }}" max="20" class="form-control" id="inp28"
                        name="MAT_O">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>9ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->MAT_N }}" max="20" class="form-control" id="inp29"
                        name="MAT_N">
                </div>
            </div>
            <!--informe a nota de física-->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Informe a nota de:</label>
                    <input disabled value="Física" type="text" class="form-control" id="inp30">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>7ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->FIS_S }}" max="20" class="form-control" id="inp31"
                        name="FIS_S">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>8ª classe:</label>
                    <input required type="number" min="0" value="{{ $candidato->FIS_O }}" max="20" class="form-control" id="inp32"
                        name="FIS_O">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>9ª classe:</label>
                    <input required type="number" min="0" max="20" value="{{ $candidato->FIS_N }}" class="form-control" id="inp33"
                        name="FIS_N">
                </div>
            </div>
            <!--informe a nota de Quimica-->
            <div class="col-md-6">
                <div class="form-group">
                    <label>Informe a nota de:</label>
                    <input disabled value="Quimica" type="text" class="form-control" id="inp34">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>7ª classe:</label>
                    <input required type="number" min="0" max="20" value="{{ $candidato->QUIM_S }}" class="form-control" id="inp35"
                        name="QUIM_S">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>8ª classe:</label>
                    <input required type="number" min="0" max="20" value="{{ $candidato->QUIM_O }}" class="form-control" id="inp36"
                        name="QUIM_O">
                </div>
            </div>
            <div class="col-4 col-md-2">
                <div class="form-group">
                    <label>9ª classe:</label>
                    <input required type="number" min="0" max="20" value="{{ $candidato->QUIM_N }}" class="form-control" id="inp37"
                        name="QUIM_N">
                </div>
            </div>
        </div>

    </div>
</fieldset>

<div class="form-group col-sm-3">
    <label for="dt_limiteaesquerda" class="form-label">Idade mínima de Candidaturas  </label>
    <input type="date" class="form-control border-secondary" id="dt_limiteaesquerda"
        placeholder="Data limite de Candidatura" name="dt_limiteaesquerda"
        value="{{ isset($idadedecandidatura->dt_limiteaesquerda) ? $idadedecandidatura->dt_limiteaesquerda : '' }}"
        max="<?php echo date('Y-m-d'); ?>" required>
        <span id="dt_limiteaesquerda_span" >------</span>
</div>

<div class="form-group col-sm-3">
    <label for="dt_limiteaesquerda" class="form-label">Idade máxima de Candidatura</label>
    <input type="date" class="form-control border-secondary" id="dt_limitemaxima"
        placeholder="Data limite de Candidatura" name="dt_limitemaxima"
        value="{{ isset($idadedecandidatura->dt_limitemaxima) ? $idadedecandidatura->dt_limitemaxima : '' }}"
        max="<?php echo date('Y-m-d'); ?>" required>
        <span id="dt_limitemaxima_span" >------</span>

</div>
<div class="form-group col-md-4">
    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


    @if (isset($ano_lectivo_publicado))
        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
            <option value="{{ $id_anoLectivo_publicado }}">
                {{ $ano_lectivo_publicado }}
            </option>
        </select>
        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
    @else
        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
            <option value="">Todos</option>
            @foreach ($anoslectivos as $anolectivo)
                <option value="{{ $anolectivo->id }}">
                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                </option>
            @endforeach
        </select>
    @endif


</div>



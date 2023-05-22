<div class="form-group col-sm-3">
    <label for="dt_limiteaesquerda" class="form-label">Idade mínima de Candidatura</label>
            <input type="date" class="form-control border-secondary" id="dt_limiteaesquerda"
                placeholder="Data limite de Candidatura" name="dt_limiteaesquerda"
                value="{{ isset($idadedecandidatura->dt_limiteaesquerda) ? $idadedecandidatura->dt_limiteaesquerda : '' }}" max="<?php echo date('Y-m-d'); ?>" required>
</div>

<div class="form-group col-sm-3">
    <label for="dt_limiteaesquerda" class="form-label">Idade máxima de Candidatura</label>
            <input type="date" class="form-control border-secondary" id="dt_limitemaxima"
                placeholder="Data limite de Candidatura" name="dt_limitemaxima"
                value="{{ isset($idadedecandidatura->dt_limitemaxima) ? $idadedecandidatura->dt_limitemaxima : '' }}" max="<?php echo date('Y-m-d'); ?>" required  >
</div>
<div class="form-group col-md-3">
    <label for="vc_anolectivo" class="form-label">Ano Lectivo</label>
    
        @if (isset($ano_lectivo_publicado))
        <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" readonly>
            <option value="{{ $ano_lectivo_publicado }}">
                {{ $ano_lectivo_publicado }}
            </option>
        </select>
        <p class="text-danger  " > Atenção: Ano lectivo publicado</p>

    @else
    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control border-secondary buscarAnoLetivo" required>
        @foreach ($anoslectivos as $anolectivo)
            <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}" @if (isset($idadedecandidatura->vc_anolectivo) && $idadedecandidatura->vc_anolectivo == $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim)
                selected
        @endif

        >{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}</option>
        @endforeach
        @endif
    </select>
</div>

<div class="form-group col-md-4">
    
    <label>Mês de Início:</label>
    <select name="mes_inicio" class="form-control select-dinamico " id="mes_inicio" required>
        @isset($inicio_termino_ano_lectivo)
            <option value="{{ $inicio_termino_ano_lectivo->mes_inicio }}">{{ $inicio_termino_ano_lectivo->mes_inicio }}
            </option>
        @else
            <option value="">Selecciona o mês</option>
        @endisset
        @foreach (fh_meses() as $item)
            <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4">
    <label>Do ano:</label>
    <select name="ano_inicio" class="form-control select-dinamico " id="ano_inicio" required>
        @isset($inicio_termino_ano_lectivo)
            <option value="{{ $inicio_termino_ano_lectivo->ano_inicio }}">{{ $inicio_termino_ano_lectivo->ano_inicio }}
            </option>
        @else
            <option value="">Selecciona o ano</option>
        @endisset
        @foreach ($anos_lectivos as $ano_lectivo)
            <option value="{{ $ano_lectivo->ya_inicio }}">{{ $ano_lectivo->ya_inicio }}</option>
        @endforeach
    </select>
</div>


<div class="form-group col-md-4">
    <label>Mês de Fim:</label>
    <select name="mes_termino" class="form-control select-dinamico " id="mes_termino" required>
        @isset($inicio_termino_ano_lectivo)
            <option value="{{ $inicio_termino_ano_lectivo->mes_termino }}">{{ $inicio_termino_ano_lectivo->mes_termino }}
            </option>
        @else
            <option value="">Selecciona o mês</option>
        @endisset
        @foreach (fh_meses() as $item)
            <option value="{{ $item }}">{{ $item }}</option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4">
    <label>Do ano:</label>
    <select name="ano_fim" class="form-control select-dinamico " id="ano_fim" required>
        @isset($inicio_termino_ano_lectivo)
            <option value="{{ $inicio_termino_ano_lectivo->ano_fim }}">{{ $inicio_termino_ano_lectivo->ano_fim }}</option>
        @else
            <option value="">Selecciona o ano</option>
        @endisset
        @foreach ($anos_lectivos as $ano_lectivo)
            <option value="{{ $ano_lectivo->ya_fim }}">{{ $ano_lectivo->ya_fim }}</option>
        @endforeach
    </select>
</div>

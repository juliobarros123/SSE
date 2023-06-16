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
            <option value="Todos">Todos</option>

            @foreach ($anoslectivos as $anolectivo)
                <option value="{{ $anolectivo->id }}">
                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                </option>
            @endforeach
        </select>
    @endif


</div>

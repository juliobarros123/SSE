
<div class="form-group col-md-4">
    <label class="form-label">Funcionário:</label>
        <select name="id_user" class="form-control select-dinamico">
            @isset($coordenador_turno)
                <option value="{{ $coordenador_turno->id }}" selected>{{ $coordenador_turno->vc_primemiroNome }} {{ $coordenador_turno ->vc_apelido }}</option>
            @else
                <option disabled> Seleciona o funcionário</option>
            @endisset
            @foreach ($usuarios as $usuario)
                <option value="{{ $usuario->id }}">{{ $usuario->vc_primemiroNome }} {{ $usuario->vc_apelido }}</option>
            @endforeach
        </select>
 
</div>
<div class="form-group col-md-4">
    <label class="form-label" for="turno">Turno: </label>
    <select class="form-control " name="turno" id="turno" required>
        @if (isset($coordenador_turno))
            <option selected class="text-primary" value="{{ $coordenador_turno->turno }}">{{ $coordenador_turno->turno }}
            </option>
        @else
            <option selected disabled value="">Selecione o turno </option>
        @endif

        <option value="DIURNO">Diurno(manhã e tarde)</option>
        <option value="NOITE">Noite</option>
        <option value="MANHÃ">Manhã</option>
        <option value="TARDE">Tarde</option>
        <option value="Sabática">Sabática</option>
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

    @else
        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
            <option value="Todos">Todos</option>
            @foreach ($anoslectivos as $anolectivo)
                <option value="{{ $anolectivo->id}}">
                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                </option>
            @endforeach
        </select>
    @endif
</div>

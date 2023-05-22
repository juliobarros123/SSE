@if ($estados_de_notas_unica[0]->estado == 1)

    <div class="form-group col-md-4">
        <label>Nota 1</label>

        @if (isset($aluno->vc_tipodaNota))
            @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                    placeholder="Nota 1" name="fl_nota1_{{ $aluno->id_aluno }}"
                    value="{{ isset($aluno->fl_nota1) ? $aluno->fl_nota1 : '' }}">
            @else
                <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                    placeholder="Nota 1" name="fl_nota1_{{ $aluno->id_aluno }}" >
            @endif
        @else
       
            <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="Nota 1"
                name="fl_nota1_{{ $aluno->id_aluno }}" >
        @endif
    </div>
@endif




@if ($estados_de_notas_unica[1]->estado == 1)
    <div class="form-group col-md-4" id="provadois">
        <label>Nota 2</label>

        @if (isset($aluno->vc_tipodaNota))
            @if ($aluno->vc_tipodaNota == $vc_tipodaNota)

                <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                    placeholder="Nota 2" name="fl_nota2_{{ $aluno->id_aluno }}"
                    value="{{ isset($aluno->fl_nota2) ? $aluno->fl_nota2 : '' }}">


            @else
                <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                    placeholder="Nota 2" name="fl_nota2_{{ $aluno->id_aluno }}" >
            @endif
        @else


        <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                    placeholder="Nota 2" name="fl_nota2_{{ $aluno->id_aluno }}" >
@endif
    </div>
@endif







@if ($estados_de_notas_unica[2]->estado == 1)
    <div class="form-group col-md-4" id="mac">
        <label>MAC</label>

        
        @if (isset($aluno->vc_tipodaNota))
            @if ($aluno->vc_tipodaNota == $vc_tipodaNota)

        <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="MAC"
            name="fl_mac_{{ $aluno->id_aluno }}" value="{{ isset($aluno->fl_mac) ? $aluno->fl_mac : '' }}">
            @else
            <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="MAC"
            name="fl_mac_{{ $aluno->id_aluno }}" >
        @endif
    @else

    <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="MAC"
            name="fl_mac_{{ $aluno->id_aluno }}" >
@endif
    </div>
@endif


 @if ($permissaoNota->vc_trimestre=='T')
<div class="col-sm-3">
    <div class="form-group">
        <label>Estado geral</label>
        <h3 class="text-info">{{$permissaoNota->estado==1?'Activado':'Desativado'}}</h3>
        <select name="estado_t" class="form-control">
           
            @if ($permissaoNota->estado!=1)
            <option value="0">Desativar</option>
            <option value="1">Activar</option>
           
            @else
            <option value="1">Activar</option>
            <option value="0">Desativar</option>
           
            @endif

             
        </select>

    </div>
</div>
@endif

@if ($permissaoNota->vc_trimestre=='I')
<div class="col-sm-3">
    <div class="form-group">
        <label>Estado I Trimestre</label>
        <h3 class="text-info">{{$permissaoNota->estado==1?'Activado':'Desativado'}}</h3>
        <select name="estado_trimestreI" class="form-control">
            @if ($permissaoNota->estado!=1)
            <option value="0">Desativar</option>
            <option value="1">Activar</option>
           
            @else
            <option value="1">Activar</option>
            <option value="0">Desativar</option>
           
            @endif
        </select>

    </div>
</div>
@endif

@if ($permissaoNota->vc_trimestre=='II')
<div class="col-sm-3">
    <div class="form-group">
        <label>Estado II Trimestre</label>
        <h3 class="text-info">{{$permissaoNota->estado==1?'Activado':'Desativado'}}</h3>
        <select name="estado_trimestreII" class="form-control">
            @if ($permissaoNota->estado!=1)
            <option value="0">Desativar</option>
            <option value="1">Activar</option>
           
            @else
            <option value="1">Activar</option>
            <option value="0">Desativar</option>
           
            @endif
        </select>

    </div>
</div>
@endif

@if ($permissaoNota->vc_trimestre=='III')
<div class="col-sm-3">
    <div class="form-group">
        <label>Estado III Trimestre</label>
        <h3 class="text-info">{{$permissaoNota->estado==1?'Activado':'Desativado'}}</h3>
        <select name="estado_trimestreIII" class="form-control">
            @if ($permissaoNota->estado!=1)
            <option value="0">Desativar</option>
            <option value="1">Activar</option>
           
            @else
            <option value="1">Activar</option>
            <option value="0">Desativar</option>
           
            @endif
        </select>

    </div>
</div>
@endif
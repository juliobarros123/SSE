@if ($permissaoUnicaNota->id_permissao_notas == 2)

    @if ($permissaoUnicaNota->vc_tipo_nota == 'Professores')
    <h3 class="col-sm-12 text-center ">Notas do I Trimestre</h3>
        <div class="col-sm-4">
            <div class="form-group ">
                <label>Nota dos Professores</label>
                <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
                <select name="estado_professores_I" class="form-control">

                    @if ($permissaoUnicaNota->estado != 1)
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

    @if ($permissaoUnicaNota->vc_tipo_nota == 'Escolar')
        <div class="col-sm-4">
            <div class="form-group ">
                <label>Nota Escolar</label>
                <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
                <select name="estado_escolar_I" class="form-control">

                    @if ($permissaoUnicaNota->estado != 1)
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


    @if ($permissaoUnicaNota->vc_tipo_nota == 'Mac')
    <div class="col-sm-4">
        <div class="form-group ">
            <label> Mac</label>
            <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
            <select name="estado_mac_I" class="form-control">

                @if ($permissaoUnicaNota->estado != 1)
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

@endif


@if ($permissaoUnicaNota->id_permissao_notas == 3)


    @if ($permissaoUnicaNota->vc_tipo_nota == 'Professores')
    <h3 class="col-sm-12 text-center ">Notas do II Trimestre</h3>
        <div class="col-sm-4">
            <div class="form-group">
                <label>Nota dos Professores</label>
                <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
                <select name="estado_professores_II" class="form-control">

                    @if ($permissaoUnicaNota->estado != 1)
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

    @if ($permissaoUnicaNota->vc_tipo_nota == 'Escolar')
        <div class="col-sm-4">
            <div class="form-group">
                <label>Nota Escolar</label>
                <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
                <select name="estado_escolar_II" class="form-control">

                    @if ($permissaoUnicaNota->estado != 1)
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
   



    @if ($permissaoUnicaNota->vc_tipo_nota == 'Mac')
    <div class="col-sm-4">
        <div class="form-group ">
            <label> Mac</label>
            <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
            <select name="estado_mac_II" class="form-control">

                @if ($permissaoUnicaNota->estado != 1)
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

@endif

@if ($permissaoUnicaNota->id_permissao_notas == 4)


    @if ($permissaoUnicaNota->vc_tipo_nota == 'Professores')
    <h3 class="col-sm-12 text-center ">Notas do III Trimestre</h3>
        <div class="col-sm-4">
            <div class="form-group ">
                <label>Nota dos Professores</label>
                <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
                <select name="estado_professores_III" class="form-control">

                    @if ($permissaoUnicaNota->estado != 1)
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

    @if ($permissaoUnicaNota->vc_tipo_nota == 'Escolar')
    <div class="col-sm-4">
        <div class="form-group">
            <label>Nota Escolar</label>
            <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
            <select name="estado_escolar_III" class="form-control">

                @if ($permissaoUnicaNota->estado != 1)
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
    

    @if ($permissaoUnicaNota->vc_tipo_nota == 'Mac')
    <div class="col-sm-4">
        <div class="form-group ">
            <label> Mac</label>
            <h3 class="text-info">{{ $permissaoUnicaNota->estado == 1 ? 'Activado' : 'Desativado' }}</h3>
            <select name="estado_mac_III" class="form-control">

                @if ($permissaoUnicaNota->estado != 1)
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

@endif


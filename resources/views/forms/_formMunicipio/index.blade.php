<div class="form-group col-sm-4">
    <label for="" class="form-label">Nome</label>
    <input type="text" class="form-control" placeholder="Digite o nome do municipio" name="vc_nome"
        value="{{ isset($municipio->vc_nome) ? $municipio->vc_nome : '' }}" required>
</div>

<div class="form-group col-sm-4">
    <label for="" class="form-label">Província</label>

        <select class="form-control " name="it_id_provincia" required>
            <option value="{{ isset($municipio) ? $municipio->it_id_provincia : '' }}" selected>
                {{ isset($municipio) ? $municipio->vc_nomeProvincia : 'Selecione a Província:' }}</option>
            @foreach ($provincias as $provincia)
                <option value="{{ $provincia->id }}">{{ $provincia->vc_nome }} </option>
          
            @endforeach
        </select>
</div>
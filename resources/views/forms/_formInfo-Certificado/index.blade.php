<div class="form-group col-md-4">
    <label for="id_classe">Classe</label>
    <select class="form-control border-secondary  select-dinamico" name="id_classe" id="id_classe" required>
        @if (!isset($info_certificado->id_classe))
            <option value="" selected disabled>Selecione a classe</option>
        @endif
        @foreach (fh_classes()->get() as $classe)
            <option value="{{ $classe->id }}" @if (isset($info_certificado->id_classe) && $info_certificado->id_classe == $classe->id) selected @endif>
                {{ $classe->vc_classe }} ªclasse</option>
        @endforeach
    </select>
</div>

<div class="form-group col-4">
    <label for="decreto" class="form-label"> Decreto Executivo nº:</label>
    <input type="text" class="form-control border-secondary col-sm-12" name="decreto"
        placeholder="______/ _____ de _____"
        value="{{ isset($info_certificado->decreto) ? $info_certificado->decreto : '' }}" id="decreto" required>
</div>

<div class="form-group col-4">
    <label for="artigo" class="form-label"> Artigo:</label>
    <input type="text" class="form-control border-secondary col-sm-12" name="artigo" placeholder="Nº"
        value="{{ isset($info_certificado->artigo) ? $info_certificado->artigo : '' }}" id="artigo" required>
</div>
<div class="form-group col-4">
    <label for="LBSEE" class="form-label"> LBSEE de:</label>
    <input type="text" class="form-control border-secondary col-sm-12" name="LBSEE"
        placeholder="__/__ de ___ de ___" value="{{ isset($info_certificado->LBSEE) ? $info_certificado->LBSEE : '' }}"
        id="LBSEE" required>
</div>

<div class="form-group col-4">
    <label for="lei" class="form-label"> Conjugada com a lei :</label>
    <input type="text" class="form-control border-secondary col-sm-12" name="lei"
        placeholder="__/__ de ___ de _______-" value="{{ isset($info_certificado->lei) ? $info_certificado->lei : '' }}"
        id="lei" required>
</div>

<div class="form-group col-4">
    <label for="processo" class="form-label">Ensino:</label>
    <select name="ensino" id="" class="form-control" required>
        @if (isset($info_certificado->id_classe))
        <option value="{{$info_certificado->ensino}}">{{$info_certificado->ensino}}</option>

        @else
            <option value="" selected disabled>Selecione a classe</option>
        @endif


        <option value="Iº CICLO DO ENSINO SECUNDÁRIO GERAL">IIº CICLO DO ENSINO SECUNDÁRIO GERAL</option>
        <option value="IIº CICLO DO ENSINO SECUNDÁRIO GERAL">IIº CICLO DO ENSINO SECUNDÁRIO GERAL</option>
        <option value="IIº CICLO DO ENSINO SECUNDÁRIO TÉCNICO ">IIº CICLO DO ENSINO SECUNDÁRIO TÉCNICO </option>

    </select>

</div>

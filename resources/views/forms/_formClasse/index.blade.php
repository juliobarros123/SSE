

<div class="form-group col-sm-8">
    <label for="" class="form-label">Classe</label>
    <input type="number" class="form-control" required name="vc_classe"
        max="13" min="1"  value="{{isset($classe->vc_classe) ? $classe->vc_classe : '' }}"  placeholder="Digite a classe">
</div>
{{--
value="{{ isset($classe->vc_classe) ? $classe->vc_name : '' }}"
    --}}

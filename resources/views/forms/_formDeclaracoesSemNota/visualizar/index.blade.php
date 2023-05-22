<input type="hidden" name="_token" value="{{ csrf_token() }}">

<div class="form-group col-md-4">
    <label for="aluno" class="form-label">Número de processo</label>
    <input type="text" class="form-control border-secondary" name="aluno" placeholder="Número de processo" id="aluno">
</div>

<div class="form-group col-md-4">
    <label for="declaracao" class="form-label">Número da daclaração</label>
    <input type="text" class="form-control border-secondary" name="declaracao"
        placeholder="Insira o número da declaração" id="declaracao">

</div>

<div class="form-group col-md-4">
    <label class="form-label text-white">.</label>
    <button class="form-control btn btn-dark" title="@lang('ver a declaração')" type="submit">ver a declaração</button>
</div>

<input type="hidden" name="_token" value="{{ csrf_token() }}">
<input type="hidden" class="form-control" name="id" value="{{ $dadosActualizar->id }}" id="id">

<div class="form-group col-md-4">
    <label for="idDeclaracao" class="form-label">Número da daclaração</label>
    <input type="text" class="form-control border-secondary" name="idDeclaracao" value="{{ $dadosActualizar->id }}"
        disabled id="idDeclaracao">
</div>

@include('forms._formDeclaracoesSemNota.criar.index',$classes)


<div class="form-group col-md-4">
    <label class="form-label text-white">.</label>
    <button class="form-control btn btn-dark" title="@lang('actualizar declaração')" type="submit">actualizar
        declaração</button>
</div>

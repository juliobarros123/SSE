<div class="row">
    <div class="col-sm-6">
        <label for="">Média</label>
        <input type="text" value="{{ isset($dado->nota) ? $dado->nota : '' }}" class=" form-control col-sm-12" id=""
            name="nota">
    </div>
    <div class="col-sm-6">
        <label for="">Data de nascimento limite</label>
        <input type="date" value="{{ isset($dado->dt_nascimento) ? $dado->dt_nascimento : '' }}"
            class="form-control col-sm-12" id="" name="dt_nascimento">
    </div>
</div>

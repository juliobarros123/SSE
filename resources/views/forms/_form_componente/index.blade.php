<div class="form-group col-sm-4">
    <label for="" class="form-label">Componente</label>
    <input type="text" class="form-control" required name="vc_componente" class=""
        value="{{ isset($componente->vc_componente) ? $componente->vc_componente : '' }}"
        placeholder="Digite a componente">
</div>
<div class="form-group col-md-4">
    <label for="id_curso" class="form-label">Curso:</label>
    <select name="id_curso" id="id_curso_sem_todas" class="form-control" required>
        
        @if (isset($componente->id_curso))
        <option selected value="{{$componente->id_curso}}">{{$componente->vc_nomeCurso}}</option>

        @else
            <option value="">Selecciona o Curso</option>

        @endif
        @foreach (fh_cursos()->get() as $curso)
            <option value="{{ $curso->id }}">
                {{ $curso->vc_nomeCurso }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-4">
    <label for="id_classe">Classe</label>
    <select class="form-control border-secondary  select-dinamico" name="id_classe" id="id_classe" required>
        @if (!isset($componente->id_classe))
            <option value=""  >Selecione a classe</option>
        @endif
        @foreach (fh_classes()->get() as $classe)
            <option value="{{ $classe->id }}" @if (isset($componente->id_classe) && $componente->id_classe == $classe->id) selected @endif>
                {{ $classe->vc_classe }} ªclasse</option>
        @endforeach
    </select>
</div>

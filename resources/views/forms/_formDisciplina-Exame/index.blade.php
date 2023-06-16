

<div class="form-group col-md-6">
    <label for="id_classe">Disciplina</label>
    <select class="form-control border-secondary mySelect" multiple name="id_disciplina[]" id="id_disciplina" required>
        @if (isset($disciplina_exame))
            <option selected value="{{ $disciplina_exame->id_disciplina }}">{{ $disciplina_exame->vc_nome }}</option>
      
        @endif
        @foreach ($disciplinas as $disciplina)
        <option value="{{ $disciplina->id }}">
            {{ $disciplina->vc_nome }}</option>
    @endforeach

    </select>
</div>

<div class="form-group col-md-6">
    <label for="id_classe">Classe</label>
    <select class="form-control border-secondary mySelect"  name="id_classe" id="id_classe" required>

        @if (isset($disciplina_exame))
            <option selected value="{{ $disciplina_exame->id_classe }}">{{ $disciplina_exame->vc_classe }} ªclasse</option>
        @else
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">
                    {{ $classe->vc_classe }} ªclasse</option>
            @endforeach
        @endif

    </select>
</div>

{{-- <select id="mySelect" multiple style="width: 300px;">
    <option value="opcao1">Opção 1</option>
    <option value="opcao2">Opção 2</option>
    <option value="opcao3">Opção 3</option>
    <option value="opcao4">Opção 4</option>
    <option value="opcao5">Opção 5</option>
</select> --}}

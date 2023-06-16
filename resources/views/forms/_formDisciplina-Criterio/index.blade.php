<div class="form-group col-md-4">
    <label for="id_curso" class="form-label">Curso:</label>
    <select name="id_curso" id="id_curso" class="form-control" required>
        <option value="">Selecciona o Curso</option>

        @foreach ($cursos as $curso)
            <option value="{{ $curso->id }}">
                {{ $curso->vc_nomeCurso }}
            </option>
        @endforeach
    </select>
</div>

<div class="form-group col-md-4">
    <label for="id_classe" class="form-label">Classe:</label>
    <select name="id_classe" id="id_classe" class="form-control">

        @foreach ($classes as $classe)
            <option value="{{ $classe->id }}">
                {{ $classe->vc_classe }}ª classe
            </option>
        @endforeach
    </select>

</div>

<div class="form-group col-md-4">
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
<div class="form-group col-md-4">
    <label for="resultado" class="form-label">Resultado:</label>
    <select name="resultado" id="resultado" class="form-control">
        @isset($criterio_avaliacao)
            <option value="{{ $criterio_avaliacao->resultado }}">{{ $criterio_avaliacao->resultado }}</option>
        @else
            <option value="" disabled selected>Selecione o resultado</option>
        @endisset
        @foreach (['RECURSO', 'TRANSITA', 'N/TRANSITA', 'TRANSITA/DEFICIÊNCIA'] as $resultado)
            <option value="{{ $resultado }}">
                {{ $resultado }}
            </option>
        @endforeach
    </select>
</div>
<div class="form-group col-md-4">
    <label for="valor_inicial" class="form-label">Valor acima ou igual :</label>
    <input type="text" name="valor_inicial"
        value="{{ isset($criterio_avaliacao) ? $criterio_avaliacao->valor_inicial : '' }}" class="form-control"
        id="">
</div>
<div class="form-group col-md-4">
    <label for="valor_final" class="form-label">Valor abaixo ou igual a:</label>
    <input type="text" name="valor_final"
        value="{{ isset($criterio_avaliacao) ? $criterio_avaliacao->valor_final : '' }}" class="form-control"
        id="">
</div>
<script>
    var selectElement = document.getElementById("id_classe");

    // Adiciona um evento de mudança ao select
    selectElement.addEventListener("change", function() {
        // Obtém o valor selecionado atual
        var selectedValue = this.value;
        // alert("ola");
        // Verifica se o valor selecionado é igual a "Todas"
        if (selectedValue === "Todas") {
            // Define o valor selecionado para a opção padrão (ou qualquer outra opção desejada)
            this.value = ""; // Você também pode definir um valor diferente aqui, se necessário
        }
    });
</script>

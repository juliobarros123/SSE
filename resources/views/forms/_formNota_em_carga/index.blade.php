@isset($matricula->vc_imagem)

    <div class="col-lg-2 col-sm-6  ">

        <div class="col-lg-12 col-sm-12  ">

            <div class="card card-outline-info h-100">
                <div class="card-img-top">
                    <img src="{{ asset($matricula->vc_imagem) }}" class="grayscale img-fluid mx-auto d-block"
                        alt="card image 3">
                </div>
            </div>

        </div>
    </div>
@endisset



<div class="col-md-2">
    <div class="form-group ">
        <label for="aluno">Nº DE PROCESSO</label>
        <input id="it_idAluno" class="form-control" placeholder="Digite o numero de Processo" name="it_idAluno"
            value="{{ isset($matricula->it_idAluno) ? $matricula->it_idAluno : '' }}" autocomplete="off">
    </div>
</div>



<div class="col-sm-3">
    <div class="form-group">
        <label>Turma</label>
        <select name="it_idTurma" class="form-control">
            @isset($turma)
                <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}| {{$turma->vc_turnoTurma}} | {{ $turma->vc_cursoTurma }} |
                    {{ $turma->vc_classeTurma }}ª classe</option>
            @else
                <option>seleciona a turma</option>
            @endisset
            @foreach ($turmas as $turma)
                @if ($turma->it_qtdeAlunos != $turma->it_qtMatriculados)
                    <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}| {{$turma->vc_turnoTurma}} | {{ $turma->vc_cursoTurma }} |
                        {{ $turma->vc_classeTurma }}ª classe</option>
                @endif
            @endforeach
        </select>

    </div>
</div>

<div class="col-sm-2">
    <div class="form-group ">
        <label>Classe</label>
        <select name="it_idClasse" class="form-control">
            @isset($classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}ªclasse</option>
            @else
                <option>seleciona a classe</option>
            @endisset
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}ªclasse</option>
            @endforeach
        </select>

    </div>
</div>
<div class="col-sm-3">
    <div class="form-group">
        <label>Curso</label>
        <select name="it_idCurso" class="form-control">
            @isset($curso)
                <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }}</option>
            @else
                <option>seleciona o curso</option>
            @endisset
            @foreach ($cursos as $curso)
                <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }}</option>
            @endforeach
        </select>

    </div>
</div>
<div class="col-sm-2">
    <div class="form-group">
        @if (!isset($matricula->vc_anoLectivo))
            <label for="vc_anoLectivo">Ano Lectivo</label>
            <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                value="{{ isset($anoLectivo) ? $anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim : '' }}" readonly>
        @endif
        @isset($matricula->vc_anoLectivo)
            <label for="vc_anoLectivo">Ano Lectivo</label>
            <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                value="{{ isset($matricula->vc_anoLectivo) ? $matricula->vc_anoLectivo : '' }}" readonly>
        @endisset
    </div>
</div>

<style>
    .file {
        opacity: 0;
        width: 0.1px;
        height: 0.1px;
        position: absolute;
    }

    .file-input label {
        display: block;
        position: relative;
        height: 50px;
        border-radius: 6px;
        background: linear-gradient(40deg, #343a41, #343a41);
        box-shadow: 0 4px 7px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: bold;
        cursor: pointer;
        transition: transform .2s ease-out;
        top: 3px;
        width: auto;
    }

</style>
<div class="file-field input-field col-md-12">
    <div class="form-group">
        <div class="file-input ">
            <input name="vc_imagem" type="file" id="file" class="file"
                value="{{ isset($matricula->vc_imagem) ? $matricula->vc_imagem : '' }}">
            <label for="file"><i class="fas fa-camera mr-2"></i> Carregar foto</label>
        </div>
    </div>
</div>

<script>
    var msg = '{{ Session::get('
    alert ') }}';
    var exist = '{{ Session::has('
    alert ') }}';
    if (exist) {
        alert(msg);
    }

</script>


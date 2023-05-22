@if (isset($cadastrar))
    {{-- <div class="col-md-4">
    <div class="form-group ">
        <label for="aluno">Nº DE PROCESSO</label>
        <input id="it_idAluno" class="form-control processo" placeholder="Digite o numero de Processo" name="it_idAluno"
            value="{{ isset($matricula->it_idAluno) ? $matricula->it_idAluno : '' }}" autocomplete="off">
    </div>
</div> --}}
    @if (isset($matricula->vc_imagem))
        <img src="{{ asset($matricula->vc_imagem) }}" class="razer" alt="card image 3"
            style="max-width: 333px; max-height:310px;min-width: 333px; min-height:310px " id="imageoption">
    @else
        <img class="razer" id="imageoption" class="border-0"
            style="max-width: 333px; max-height:310px;min-width: 333px; min-height:310px">
    @endif

    <div class="col-md-6">
        <div class="col-md-4">

        </div>
    </div>
    <!-- <input type="file" id="img" name="imgh"> -->
    <div class="col-md-5">
        <div class="form-group ">
            <label for="aluno">Nº DE PROCESSO</label>
            <select name="it_idAluno" class="form-control buscarProcesso processo_aprovacao" >
                <option value="" selected disabled> Seleciona o aluno</option>
                @foreach ($alunos as $aluno)
                <option value="{{ $aluno->id }}">{{ $aluno->id }}</option>
                @endforeach
            </select>


        </div>
    </div>
    <div class="col-md-6">
        <h6 class="" id="nome"></h6>
    </div>
    @isset($id_anoLectivo_publicado)
        @php
            $turmas = $turmas->where('it_idAnoLectivo', $id_anoLectivo_publicado);
        @endphp
    @endisset


    <div class="col-sm-5">
        <div class="form-group">
            <label>Turma</label>
            <select name="it_idTurma" class="form-control select2">
                @isset($turma)
                    <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/ {{ $turma->vc_turnoTurma }} /
                        {{ $turma->vc_cursoTurma }} /
                        {{ $turma->vc_classeTurma }}ª classe / {{ $turma->vc_classeTurma }}</option>
                @else
                    <option>Seleciona a turma</option>
                @endisset
                @foreach ($turmas as $turma)
                    @if ($turma->it_qtdeAlunos != $turma->it_qtMatriculados)
                        <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                            {{ $turma->vc_turnoTurma }}
                            /
                            {{ $turma->vc_cursoTurma }} /
                            {{ $turma->vc_classeTurma }}ª classe/ {{ $turma->vc_anoLectivo }} </option>
                    @endif
                @endforeach
            </select>

        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
            @if (!isset($matricula->vc_anoLectivo))
                <label for="vc_anoLectivo">Ano Lectivo</label>
                @if (isset($ano_lectivo_publicado))
                    <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                        value="{{ $ano_lectivo_publicado }}" readonly>
                    <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                @else
                    <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                        value="{{ isset($anoLectivo) ? $anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim : '' }}"
                        readonly>
                @endif
            @endif

            @isset($matricula->vc_anoLectivo)
                <label for="vc_anoLectivo">Ano Lectivo</label>
                <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                    value="{{ isset($matricula->vc_anoLectivo) ? $matricula->vc_anoLectivo : '' }}" readonly>
            @endisset
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">

            <label for="resultado">RESULTADO</label>
            <input id="resultado" class="form-control" readonly>

        </div>
    </div>

    <input type=button class=hide value="Adicionar outro">

    <style>
        .hide {
            display: none;
        }

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
                    value="{{ isset($matricula->vc_imagem) ? $matricula->vc_imagem : '' }}"
                    onchange="
                    document.getElementById('imageoption').removeAttribute('src')
                    document.getElementById('imageoption').src = window.URL.createObjectURL(this.files[0])">
                <label for="file"><i class="fas fa-camera mr-2"></i> Carregar foto</label>
            </div>
        </div>
    </div>

    <input type="text" id="vc_nameImage" name="vc_nameImage" hidden>
@else
    @isset($matricula->vc_imagem)
        <div class="col-lg-2 col-sm-6  ">

            <div class="col-lg-12 col-sm-12  ">

                <div class="card card-outline-info h-100">
                    <div class="card-img-top">
                        <img src="{{ asset($matricula->vc_imagem) }}" id="imageoption"
                            class="grayscale img-fluid mx-auto d-block" alt="card image 3">
                    </div>
                </div>

            </div>
        </div>
    @endisset <br>



    <div class="col-md-4">
        <div class="form-group ">
            <label for="aluno">Nº DE PROCESSO</label>
            {{-- name="it_idAluno" class="form-control  " --}}
            <input id="it_idAluno" class="form-control buscarProcesso processo_aprovacao "
                placeholder="Digite o numero de Processo" name="it_idAluno"
                value="{{ isset($matricula->it_idAluno) ? $matricula->it_idAluno : '' }}" autocomplete="off">


        </div>
    </div>



    <div class="col-sm-5">
        <div class="form-group">
            <label>Turma</label>
            {{-- <select name="it_idTurma" class="form-control buscarTurma"> --}}
            <select name="it_idTurma" class="form-control select2">
                @isset($turma)
                <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                    {{ $turma->vc_turnoTurma }}
                    /
                    {{ $turma->vc_cursoTurma }} /
                    {{ $turma->vc_classeTurma }}ª classe/ {{ $turma->vc_anoLectivo }} </option>
                @else
                    <option>seleciona a turma</option>
                @endisset
                @foreach ($turmas as $turma)
                    @if ($turma->it_qtdeAlunos != $turma->it_qtMatriculados)
                    <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }}/
                        {{ $turma->vc_turnoTurma }}
                        /
                        {{ $turma->vc_cursoTurma }} /
                        {{ $turma->vc_classeTurma }}ª classe/ {{ $turma->vc_anoLectivo }} </option>
                    @endif
                @endforeach
            </select>

        </div>
    </div>

    {{-- <div class="col-sm-2">
    <div class="form-group ">
        <label>Classe</label>
        <select name="it_idClasse" class="form-control buscarClasse">
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
        <select name="it_idCurso" class="form-control buscarCurso">
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
</div> --}}
    <div class="col-sm-3">
        <div class="form-group">
            @if (!isset($matricula->vc_anoLectivo))
                <label for="vc_anoLectivo">Ano Lectivo</label>
                <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                    value="{{ isset($anoLectivo) ? $anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim : '' }}"
                    readonly>
            @endif
            @isset($matricula->vc_anoLectivo)
                <label for="vc_anoLectivo">Ano Lectivo</label>
                <input id="vc_anoLectivo" class="form-control" name="vc_anoLectivo"
                    value="{{ isset($matricula->vc_anoLectivo) ? $matricula->vc_anoLectivo : '' }}" readonly>
            @endisset
        </div>
    </div>

    <!-- <input type=button class=hide value="Adicionar outro"> -->

    <style>
        .hide {
            display: none;
        }

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
                <input name="vc_imagem" type="file" id="file" class="file carregar2"  size="50MB image/*"
                    value="{{ isset($matricula->vc_imagem) ? $matricula->vc_imagem : '' }}"
                    onchange="
                    document.getElementById('imageoption').removeAttribute('src');
                    document.getElementById('imageoption').src = window.URL.createObjectURL(this.files[0])">
                <label for="file"><i class="fas fa-camera mr-2"></i> Carregar foto</label>
            </div>
        </div>
    </div>
    <input type="text" hidden value="" id="input-file" name="input_file">

    <script>
        var msg = '{{ Session::get('
            alert ') }}';
        var exist = '{{ Session::has('
            alert ') }}';
        if (exist) {
            alert(msg);
        }
    </script>
 
   
@endif

<div class="col-sm-3">
    <div class="form-group">
        <label>Turma</label>
     
        <select name="id_turma" class="form-control select-dinamico " id="selectT"  required>
            @isset($turma)
                <option value="{{ $turma->id }}">{{ $turma->vc_nomedaTurma }} </option>
            @else
                <option  selected disabled>seleciona a turma</option>
            @endisset
            @foreach ($turmas as $turma)
                <option value="{{ $turma->id }}" >{{ $turma->vc_nomedaTurma }} || {{ $turma->vc_classeTurma }}ªclasse || {{ $turma->vc_cursoTurma }}</option>
            @endforeach
        </select>

    </div>
</div>

{{-- <div class="col-sm-3">
    <div class="form-group">
        <label>Classe</label>
        <select name="it_idClasse" class="form-control">
            @isset($classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}</option>
            @else
                <option>seleciona a classe</option>
            @endisset
            @foreach ($classes as $classe)
                <option value="{{ $classe->id }}">{{ $classe->vc_classe }}</option>
            @endforeach
        </select>

    </div>
</div> --}}




<div class="col-sm-3">
    <div class="form-group ">
        <label>Professor</label>
        <select name="id_user" class="form-control select-dinamico" required>
            @isset($user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @else
                <option>seleciona o professor</option>
            @endisset
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @endforeach
        </select>
    </div>
</div>

<div class="col-sm-3">
    <div class="form-group ">
        <label>Ano Lectivo</label>

        @if (isset($ano_lectivo_publicado))
        <select name="id_anoLectivo" id="id_ano_lectivo" class="form-control" readonly>
            <option value="{{ $id_anoLectivo_publicado }}">
                {{ $ano_lectivo_publicado }}
            </option>
        </select>
        <p class="text-danger  " > Atenção: Ano lectivo publicado</p>

    @else
        <select name="id_anoLectivo" class="form-control" required>
            @isset($ano_letivo)
                <option value="{{ $ano_letivo->id }}">{{ $ano_letivo->ya_inicio }} -  {{ $ano_letivo->ya_fim }}</option>
            @else
                <option>seleciona o ano Lectivo</option>
            @endisset
            @foreach ($ano_letivos as $ano_letivo)
                <option value="{{ $ano_letivo->id }}">{{ $ano_letivo->ya_inicio }} - {{ $ano_letivo->ya_fim }}</option>
            @endforeach
        </select>
        @endif
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
<script>
    var msg = '{{ Session::get('
    alert ') }}';
    var exist = '{{ Session::has('
    alert ') }}';
    if (exist) {
        alert(msg);
    }

</script>


<div class="form-group col-md-3">
    <label class="form-label">Funcionário:</label>
        <select name="id_user" class="form-control select-dinamico">
            @isset($coordenador_curso)
                <option value="{{ $coordenador_curso->id }}">{{ $coordenador_curso->vc_primemiroNome }} {{ $coordenador_curso->vc_apelido }}</option>
            @else
                <option disabled> Seleciona o funcionário</option>
            @endisset
            @foreach ($users as $user)
                <option value="{{ $user->id }}">{{ $user->vc_primemiroNome }} {{ $user->vc_apelido }}</option>
            @endforeach
        </select>
 
</div>




<div class="form-group col-md-3">
    <label class="form-label">Curso:</label>
    <select class="form-control buscarCurso" name="id_curso" required>
        <option value="{{ isset($coordenador_curso) ? $coordenador_curso->id_curso : '' }}" selected>
            {{ isset($coordenador_curso) ? $coordenador_curso->vc_nomeCurso : 'Selecione o curso:' }}</option>
            <option disabled> Seleciona o curso</option>
            {{-- @foreach ($cursos as $curso)
  
            <option value="{{ $curso->id }}">{{ $curso->vc_nomeCurso }} </option>
            </option>
        @endforeach --}}
    </select>
</div>






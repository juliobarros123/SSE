@extends('layouts.admin')

@section('titulo', 'Dispensa do Professor/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Dispensa do Professor </h3>
        </div>
    </div>
    @if ($errors->any())
        <div class="card">
            <div class="card-body">

                <div class="text-center">

                    @foreach ($errors->all() as $error)
                        <i>
                            <p class="text-danger text-center">{{ $error }}</p>
                        </i>
                    @endforeach

                </div>



            </div>
        </div>
    @endif
    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('documentos.dispensa_professor.imprimir') }}" target="_blank"
                class="row">
                @csrf
                <div class="form-group col-md-4">
                    <label for="id_funcionario" class="form-label">Funcioário</label>
                    <select name="id_funcionario" id="id_funcionario" class="form-control js-example-basic-single"
                         required>
                          <option selected disabled>Seleccionar funcionário</option>
                       
                        @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->vc_primeiroNome." ".$funcionario->vc_ultimoNome }}</option>
                        @endforeach
                      
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="modelo" class="form-label">Modelo</label>
                    <select name="modelo" id="modelo" class="form-control" required onchange="changeModelo()">
                        <option selected disabled>Selecciona a opção</option>
                        <option value="Dinâmico">Dinâmico</option>
                        <option value="Estático">Estático</option>
                        <option value="Puro">Puro</option>
                    </select>

                </div>
                <div class="form-group col-md-4">
                    <label for="disciplina">Disciplina</label>
                    <select class="form-control  border-secondary buscarDisciplina" name="disciplina" id="disciplina" required>
                        @if (!isset($documento->disciplina))
                            <option value="" selected disabled>Selecione disciplina
                            </option>
                        @endif
                        @foreach ($disciplinas as $row)
                            <option value="{{ $row->vc_nome }}" @if (isset($documento->disciplina) && $documento->disciplina == $row->vc_nome) selected @endif>{{ $row->vc_nome }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-md-4">
                    <label for="classe" class="form-label">Classe:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="classe"
                        placeholder="" value="" id="classe" required>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label">Curso:</label>
                    <select class="form-control " name="curso" required id="curso">
                        <option value="{{ isset($documento) ? $documento->curso : '' }}" selected>
                            {{ isset($documento) ? $documento->curso : 'Selecione o curso:' }}</option>
                        @foreach ($cursos as $curso)
                            <option value="{{ $curso->vc_nomeCurso }}">{{ $curso->vc_nomeCurso }} </option>
                      
                        @endforeach
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label class="form-label" for="periodo">Turno</label>
                    <select class="form-control " name="periodo" id="periodo" required>
                        @if (isset($turma))
                            <option selected class="text-primary" value="{{ $turma->periodo }}">{{ $turma->periodo }}
                            </option>
                        @else
                            <option selected disabled value="">Selecione o Periodo</option>
                        @endif
                
                        <option value="DIURNO">Diurno(manhã e tarde)</option>
                        <option value="NOITE">Noite</option>
                        <option value="MANHÃ">Manhã</option>
                        <option value="TARDE">Tarde</option>
                        <option value="Sabática">Sabática</option>
                    </select>
                </div>

                <div class="form-group col-md-4">
                    <label for="comprovativo" class="form-label">Documentos comprovativos em anexo?</label>
                    <div id="res" class=" d-flex justify-content-center" style="font-size: 25px;">
                        Sim<input type="radio" name="comprovativo" id="ck_sim" value="1" style="width: 25px;margin-right: 50px;">
                        Não <input type="radio" name="comprovativo" id="ck_nao" value="0" style="width: 25px;">
                    </div>
                </div>
                <div class="form-group col-md-4">
                    <label for="data1" class="form-label">Período:</label>
                    <input type="date" class="form-control border-secondary col-sm-12" name="data1"
                        placeholder="" value="" id="data1" required>
                </div>
                <div class="form-group col-md-4">
                    
                    <input type="date" class="form-control border-secondary col-sm-12" name="data2"
                        placeholder="" value="" id="data2" required style="margin-top: 32px;">
                </div>
                <div class="form-group col-md-12">
                    
                    <label for="motivo" class="form-label">Motivo:</label>
                    <textarea name="motivo" id="motivo" cols="30" rows="10" class="form-control border-secondary col-sm-12"></textarea>
                </div>
                <div class="form-group col-12 d-flex justify-content-center">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark " type="submit">Emitir </button>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

    <!-- Footer-->
    @include('admin.layouts.footer')

    @if (session('dispensa_professor.imprimir.error'))
        <script>
            Swal.fire(
                'Erro ao Emitir Dispensa do Professor! ',
                '',
                'error'
            )
        </script>
    @endif
    @if (session('dispensa_professor.funcionario.inexistente'))
        <script>
            Swal.fire(
                'Erro ao Emitir Dispensa do Professor! ',
                'Funcionário não encontrado',
                'error'
            )
        </script>
    @endif

    <script>
        function changeModelo(){
            var modelo = $('#modelo').val();
            if (modelo == "Puro") {
                document.getElementById("disciplina").removeAttribute('required');
                document.getElementById("classe").removeAttribute('required');
                document.getElementById("curso").removeAttribute('required');
                document.getElementById("periodo").removeAttribute('required');
                document.getElementById("id_funcionario").removeAttribute('required');
                document.getElementById("motivo").removeAttribute('required');
                document.getElementById("data1").removeAttribute('required');
                document.getElementById("data2").removeAttribute('required');
            }else{
                document.getElementById("disciplina").setAttribute('required','required');
                document.getElementById("classe").setAttribute('required','required');
                document.getElementById("curso").setAttribute('required','required');
                document.getElementById("periodo").setAttribute('required','required');
                document.getElementById("id_funcionario").setAttribute('required','required');
                document.getElementById("motivo").setAttribute('required','required');
                document.getElementById("data1").setAttribute('required','required');
                document.getElementById("data2").setAttribute('required','required');
            }
        }
    </script>
@endsection

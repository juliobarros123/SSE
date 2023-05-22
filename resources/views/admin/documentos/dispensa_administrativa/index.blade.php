@extends('layouts.admin')

@section('titulo', 'Dispensa Administrativa/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Dispensa Administrativa </h3>
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
            <form method="POST" action="{{ route('documentos.dispensa_administrativa.imprimir') }}" target="_blank"
                class="row">
                @csrf
                <div class="form-group col-6">
                    <label for="id_funcionario" class="form-label">Funcioário</label>
                    <select name="id_funcionario" id="id_funcionario" class="form-control js-example-basic-single"
                         required>
                          <option selected disabled>Seleccionar funcionário</option>
                       
                        @foreach ($funcionarios as $funcionario)
                        <option value="{{ $funcionario->id }}">{{ $funcionario->vc_primeiroNome." ".$funcionario->vc_ultimoNome }}</option>
                        @endforeach
                      
                    </select>
                </div>
                <div class="form-group col-6">
                    <label for="modelo" class="form-label">Modelo</label>
                    <select name="modelo" id="modelo" class="form-control" required onchange="changeModelo()">
                        <option selected disabled>Selecciona a opção</option>
                        <option value="Dinâmico">Dinâmico</option>
                        <option value="Estático">Estático</option>
                        <option value="Puro">Puro</option>
                    </select>

                </div>
                <div class="form-group col-md-6">
                    <label for="area_trabalho" class="form-label">Área de Trabalho:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="area_trabalho"
                        placeholder="" value="" id="area_trabalho" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="comprovativo" class="form-label">Documentos comprovativos em anexo?</label>
                    <div id="res" class=" d-flex justify-content-center" style="font-size: 25px;">
                        Sim<input type="radio" name="comprovativo" id="ck_sim" value="1" style="width: 25px;margin-right: 50px;">
                        Não <input type="radio" name="comprovativo" id="ck_nao" value="0" style="width: 25px;">
                    </div>
                </div>

                <div class="form-group col-md-6">
                    <label for="data1" class="form-label">Periodo:</label>
                    <input type="date" class="form-control border-secondary col-sm-12" name="data1"
                        placeholder="" value="" id="data1" required>
                </div>
                <div class="form-group col-md-6">
                    
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

    @if (session('dispensa_administrativa.imprimir.error'))
        <script>
            Swal.fire(
                'Erro ao Emitir Dispensa Administrativa! ',
                '',
                'error'
            )
        </script>
    @endif
    @if (session('dispensa_administrativa.funcionario.inexistente'))
        <script>
            Swal.fire(
                'Erro ao Emitir Dispensa Administrativa! ',
                'Funcionário não encontrado',
                'error'
            )
        </script>
    @endif

    <script>
        function changeModelo(){
            var modelo = $('#modelo').val();
            if (modelo == "Puro") {
                document.getElementById("area_trabalho").removeAttribute('required');
                document.getElementById("id_funcionario").removeAttribute('required');
                document.getElementById("motivo").removeAttribute('required');
                document.getElementById("data1").removeAttribute('required');
                document.getElementById("data2").removeAttribute('required');
            }else{
                document.getElementById("area_trabalho").setAttribute('required','required');
                document.getElementById("id_funcionario").setAttribute('required','required');
                document.getElementById("motivo").setAttribute('required','required');
                document.getElementById("data1").setAttribute('required','required');
                document.getElementById("data2").setAttribute('required','required');
            }
        }
    </script>
@endsection

@extends('layouts.admin')

@section('titulo', 'Declaração de Frequência/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Declaração de Frequência </h3>
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
            <form method="POST" action="{{ route('documentos.declaracao_frequencia.imprimir') }}" target="_blank"
                class="row">
                @csrf
                <div class="form-group col-md-4">
                    <label for="processo" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="processo"
                        placeholder="Número de processo" value="" id="processo" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="processo" class="form-label">Modelo</label>
                    <select name="modelo" id="modelo" class="form-control" required onchange="changeModelo()">
                        <option selected disabled>Selecciona a opção</option>
                        <option value="Dinâmico">Dinâmico</option>
                        <option value="Estático">Estático</option>
                        <option value="Puro">Puro</option>
                    </select>

                </div>

              

                <div class="form-group col-md-4">
                    <label for="efeito" class="form-label">Efeito:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="efeito"
                        placeholder="" value="" id="efeito" required>
                </div>
               

                <div class="form-group col-md-12 d-flex justify-content-center">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark " type="submit">Emitir </button>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

    <!-- Footer-->
    @include('admin.layouts.footer')

    <script>
        function changeModelo(){
            var modelo = $('#modelo').val();
            
            if (modelo == "Puro") {
                document.getElementById("processo").removeAttribute('required');
                document.getElementById("efeito").removeAttribute('required');
             
            }else{
                document.getElementById("processo").setAttribute('required','required');
                document.getElementById("efeito").setAttribute('required','required');
              
            }
        }
    </script>

    @if (session('declaracao_frequencia.imprimir.error'))
        <script>
            Swal.fire(
                'Erro ao Emitir Declaração de Frequência! ',
                '',
                'error'
            )
        </script>
    @endif
    @if (session('declaracao_frequencia.aluno.inexistente'))
        <script>
            Swal.fire(
                'Erro ao Emitir Declaração de Frequência! ',
                'Aluno não encontrado',
                'error'
            )
        </script>
    @endif



@endsection

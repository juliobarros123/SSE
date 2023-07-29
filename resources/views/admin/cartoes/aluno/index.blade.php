@extends('layouts.admin')

@section('titulo', 'Cartao/pesquisar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cartão de Estudante</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('aviso'))
    <script>
        Swal.fire(
            ' Não existe Estudante com este número de processo',
            '',
            'error'
        )

    </script>
@endif


    <div class="card">
        <div class="card-body ">
            <form method="post" class="row" action="{{ url('admin/cartaoaluno/send/') }}"
                target="_blank">
                @csrf
                <div class="col-md-4">
                    <label for="processo" class="form-label">Processo:</label>
                    <input type="number" autocomplete="off" name="processo" placeholder="Número de processo"
                        class="form-control border-secondary" id="processo" required>
                </div>
            
                <div class="col-md-4">
                    <label for="validade" class="form-label">Válido Até:</label>
                    <input type="number" autocomplete="off" name="validade" placeholder="Número de validade"
                        class="form-control border-secondary" id="validade" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Tipo de Imprensão:</label>
                        <select name="tipo_impressao" id="tipo_impressao" class="form-control" required>
                            <option value="" >Selecciona o Tipo de Impressão</option>
                           
                                <option value="PERSONALIZADO-PVC">
                               PERSONALIZADO-PVC
                                </option>
                                <option value="CARTOLINA">
                                    CARTOLINA
                                     </option>
                                     
                                     <option value="A4">
                                        A4
                                         </option>
                            
                        </select>
              


                </div>
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                    @if (isset($ano_lectivo_publicado))
                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else

                        <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control">
                            <option value="Todos" >Todos</option>
                            @foreach ( fh_anos_lectivos()->get() as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                </div>

             
                <div class=" d-flex justify-content-center w-100">
                    <button class="form-control btn btn-dark col-md-3">Imprimir</button>
                </div>
            </form>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection



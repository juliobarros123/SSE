@extends('layouts.admin')
@section('titulo', 'Relatório de Matriculados/Alunos')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Relatório Estatístico de Alunos Matriculados</h3>
        </div>
    </div>


 


    <div class="card">
        <div class="card-body">
            <form action="{{url('Admin/recebeRem')}}" class="row" method="POST" target="_blank">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>

                    @if (isset($ano_lectivo_publicado))
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" readonly>
                        <option value="{{ $ano_lectivo_publicado }}">
                            {{ $ano_lectivo_publicado }}
                        </option>
                    </select>
                    <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                @else
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" required>
                        <option value="Todos">Todos</option>
                        @foreach ($anoslectivos as $anolectivo)
                            <option value="{{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}">
                                {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                            </option>
                        @endforeach
                    </select>
@endif
                </div>
               
                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>





@endsection



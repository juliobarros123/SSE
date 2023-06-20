@extends('layouts.admin')
@section('titulo', 'Filtrar Mensalidades')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Filtrar Mensalidades</h3>
        </div>
    </div>





    <div class="card">
        <div class="card-body">
            <form action="{{ route('pagamentos.lista') }}" method="POST">
                @csrf
                <div class="row">
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
                                @foreach ($anoslectivos as $anolectivo)
                                    <option value="{{ $anolectivo->id }}">
                                        {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
    
    
                    </div>
                 
    


                </div>
                <div class="d-flex justify-content-center">

                    <button class=" btn btn-dark ">Filtrar</button>
                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')



@endsection
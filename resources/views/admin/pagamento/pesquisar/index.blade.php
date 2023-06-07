@extends('layouts.admin')

@section('titulo', 'Pesquisar Aluno')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Aluno</h3>
        </div>
    </div>


 
    @if (session('aviso'))
        <h5 class="text-center alert alert-danger">{{ session('aviso') }}</h5>
    @endif
    <div class="card">
        <div class="card-body">
            <form method="post" class="row justify-content-center" action="{{ route('pagamentos.estado') }}"
                target="_blank">
                @csrf
                <div class=" form-group col-md-4    ">
                    <label for="processo" class="form-label">Processo:</label>
                    <input type="number" autocomplete="off" name="processo" placeholder="Introduza o número de processo"
                        class="form-control border-secondary" id="processo" required>
                </div>
                <div class="form-group col-md-4">
                    <label>Tipo de Pagamento:</label>
                    <select name="tipo" class="form-control select-dinamico " required>
                        <option value="" selected disabled>Selecciona o Tipo de Pagamento</option>
                        <option value="Mensalidades">Mensalidades</option>
                        <option value="Taxa de Matrícula">Taxa de Matrícula</option>
                        <option value="Material Didático">Material Didático</option>
                        <option value="Uniforme Escolar">Uniforme Escolar</option>
                        <option value="Taxa de Transporte">Taxa de Transporte</option>
                        <option value="Taxa de Atividades Extracurriculares">Taxa de Atividades Extracurriculares</option>
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
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif


                </div>
                <div class="form-group col-md-12 d-flex justify-content-center">

                    <button class="form-control btn btn-dark w-25">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection



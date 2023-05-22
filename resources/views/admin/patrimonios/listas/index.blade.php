@extends('layouts.admin')
@section('titulo', 'Patrimonios/Imprimir')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Imprimir lista dos Patrimónios</h3>
        </div>
    </div>


 
    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{route('admin.ListaPatrimonio.recebePatrimonios')}}" class="row" method="POST" target="_blank">
                @csrf
                <div class="form-group col-md-4">
                    <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>
                    <select name="vc_anolectivo" id="vc_anolectivo" class="form-control">
                        <option value="Todos">Todos</option>
                       
                    </select>

                </div>
             
                <div class="form-group col-md-3">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control btn btn-dark">Pesquisar</button>
                </div>

            </form>
        </div>
    </div>

@include('admin.layouts.footer')

@endsection




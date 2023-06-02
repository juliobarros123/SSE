@extends('layouts.admin')

@section('titulo', 'Funcionário(a)/Editar')

 @section('conteudo')
<div class="card mt-3">
    <div class="card-body">
        <h3>Editar dados do(a) Funcionário(a)</h3>
    </div>
</div>
    


 
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin/funcionario/editar', $funcionario->slug) }}" class="row" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('forms._formFuncionario.index')
                <div class="form-group col-sm-12 d-flex justify-content-center mt-2">
                       
                    <button class="form-control btn btn-dark w-25">Editar</button>
                </div>
            </form>

        </div>
    </div>

    @include('admin.layouts.footer')


@endsection



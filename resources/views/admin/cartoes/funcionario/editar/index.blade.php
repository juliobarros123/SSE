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
            <form action="{{ route('admin/funcionario/editar', $funcionario->id) }}" class="row" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('forms._formFuncionario.index')
                <div class="col-md-12 text-center mt-4">
                    <button class="btn btn-success col-md-3" type="submit">Editar</button>
                </div>
            </form>

        </div>
    </div>

    @include('admin.layouts.footer')


@endsection



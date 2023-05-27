@extends('layouts.admin')

@section('titulo', 'Patrimônio/Editar')

 @section('conteudo')
<div class="card mt-3">
    <div class="card-body">
        <h3>Editar Património</h3>
    </div>
</div>
    


 
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('admin/patrimonios/editar', $patrimonios->id) }}" class="row" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('forms._formPatrimonios.index')
                <div class="col-md-12 text-center mt-4">
                    <button class="btn btn-success col-md-2" type="submit">Editar</button>
                </div>
            </form>

        </div>
    </div>

    @include('admin.layouts.footer')


@endsection



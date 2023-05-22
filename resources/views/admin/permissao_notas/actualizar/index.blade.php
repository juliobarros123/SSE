@extends('layouts.admin')

@section('titulo', 'Actualizar permissao de notas')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Actualizar Permissao De Notas</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('classe'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Classe Inexistente',
        })
    </script>
@endif



    <div class="card">
        <div class="card-body">


            <form action=" {{ route('permissao.actualizar') }}" method="post" class="row">
                @csrf
                @method('PUT')
                @foreach($permissoesNota as $permissaoNota)
                @include('forms._formPermissaoNotas.index')
                @endforeach

                @foreach($permissoesUnicaNota as $permissaoUnicaNota)
                @include('forms._formPermissaoUnicaNota.index')
                @endforeach

                <div class="form-group col-sm-12">
                    <label for="" class="text-white form-label">.</label>
                    <button class="form-control btn btn-dark">Actualizar</button>
                </div>
            </form>

        </div>
    </div>
    <!-- Footer-->
    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('status'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Dados actualizado com sucesso',
            })

        </script>
    @endif
    @include('admin.layouts.footer')


@endsection


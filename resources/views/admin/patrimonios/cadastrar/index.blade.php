@extends('layouts.admin')

@section('titulo', 'Patrimônio/Cadastrar')

 @section('conteudo')
<div class="card mt-3">
    <div class="card-body">
        <h3>Cadastrar Património</h3>
    </div>
</div>


<script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
@if (session('patrimonio'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Patrimônio Inexistente',
    })
</script>
@endif


    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ url('admin/patrimonios/cadastrar') }}" class="row" method="POST" enctype="multipart/form-data">
                @csrf
                @include('forms._formPatrimonios.index')
                <div class="col-12 text-center mt-4">
                    <button class="btn btn-success col-md-2" type="submit">Cadastrar</button>
                </div>
            </form>

        </div>
    </div>

    @include('admin.layouts.footer')
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('status'))
        <script>
            Swal.fire(
                'Patrimônio Cadastrado',
                '',
                'success'
            )

        </script>
    @endif
    @if (session('aviso'))
        <script>
            Swal.fire(
                ' Falha ao Cadastrar Patrimônio',
                '',
                'error'
            )

        </script>
    @endif

@endsection



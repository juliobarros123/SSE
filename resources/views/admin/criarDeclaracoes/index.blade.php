@extends('layouts.admin')

@section('titulo', 'Home')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Criar Declarações</h3>
        </div>
    </div>



 
    <div class="card card bg-primary">
        <div class="card-header">
            <h3 class="card-title">Insira os dados no formulário</h3>
            <div class="card-tools">
                <!-- Buttons, labels, and many other things can be placed here! -->
                <!-- Here is a label for example -->
            </div>
            <!-- /.card-tools -->
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="post" action="{{ route('cadastrar') }}">
                @include('admin._forms._formsCriarDeclaracao.index')
            </form>
        </div>

    </div>
    <!-- /.card -->

<!-- Footer-->
@include('admin.layouts.footer')
@endsection


@extends('layouts.admin')

@section('titulo', 'Criar componente')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Criar componente</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <h5>As Componentes só devem ser Cadastradas para Classes de Término de Ensinno(6ª,9ª,12ª ou 13ª)<br>

            </h5>

            <form method="POST" action="{{ route('admin.documentos.componentes.cadastrar') }}" class="row">
                @csrf
                @include('forms._form_componente.index')

                <div class="d-flex justify-content-center col-sm-12 ">
                    <button class="form-control w-25 btn btn-dark" title="@lang('Cadastrar')" type="submit">Cadastrar</button>
                </div>



            </form>
        </div>
    </div>

    <!-- Footer-->

    @include('admin.layouts.footer')
@endsection

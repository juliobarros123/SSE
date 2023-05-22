@extends('layouts.admin')

@section('titulo', 'Matricula/Gerar Boletim')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Gerar Boletim</h3>
        </div>
    </div>


 
    @if (session('aviso'))
        <h5 class="text-center alert alert-danger">{{ session('aviso') }}</h5>
    @endif
    <div class="card">
        <div class="card-body">
            <form method="post" class="row justify-content-center" action="{{ url('admin/matriculas/send/') }}"
                target="_blank">
                @csrf
                <div class="col-md-4">
                    <label for="processo" class="form-label">Nº de Processo</label>
                    <input type="number" autocomplete="off" name="processo" placeholder="Introduza o número de processo"
                        class="form-control border-secondary" id="processo" required>
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button id="submit" class="form-control btn btn-success">Gerar Boletim</button>
                </div>
            </form>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection



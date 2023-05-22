@extends('layouts.admin')

@section('titulo', 'Cartao/pesquisar')

 @section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Emitir Cartão de Estudante</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('aviso'))
    <script>
        Swal.fire(
            ' Não existe Estudante com este número de processo',
            '',
            'error'
        )

    </script>
@endif


    <div class="card">
        <div class="card-body">
            <form method="post" class="row justify-content-center" action="{{ url('admin/cartaoaluno/send/') }}"
                target="_blank">
                @csrf
                <div class="col-md-4">
                    <label for="processo" class="form-label">Nº de Processo</label>
                    <input type="number" autocomplete="off" name="processo" placeholder="Introduza o número de processo"
                        class="form-control border-secondary" id="processo" required>
                </div>
                <div class="col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button id="submit" class="form-control btn btn-success">Gerar Cartão</button>
                </div>
            </form>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection



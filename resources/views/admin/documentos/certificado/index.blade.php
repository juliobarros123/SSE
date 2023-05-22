@extends('layouts.admin')

@section('titulo', 'Certificado/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir certificado </h3>
        </div>
    </div>
    @if ($errors->any())
    <div class="card">
        <div class="card-body">
         
                <div class="text-center">

                    @foreach ($errors->all() as $error)
                        <i>
                            <p class="text-danger text-center">{{ $error }}</p>
                        </i>
                    @endforeach

                </div>
        
         
        
        </div>
    </div>
    @endif
    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            <form method="POST" action="{{ route('documentos.certificados.imprimir') }}" target="_blank" class="row">
                @csrf
                <div class="form-group col-6">
                    <label for="processo" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="processo"
                        placeholder="Número de processo" value="" id="processo" required>
                </div>
                <div class="form-group col-6">
                    <label for="processo" class="form-label" >Com visto:</label>
                    <select name="visto" id="" class="form-control" required>
                        <option  selected disabled>Selecciona a opção</option>
                        <option value="Sim">Sim</option>
                        <option value="Não">Não</option>
                    </select>
                   
                </div>
                <div class="form-group col-12 d-flex justify-content-center">
                    <label class="form-label text-white">.</label><br>
                    <button class="btn btn-dark " type="submit">Emitir </button>
                </div>
            </form>
        </div>

    </div>
    <!-- /.card -->

    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection

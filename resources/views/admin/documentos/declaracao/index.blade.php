@extends('layouts.admin')

@section('titulo', 'Declaração/Emitir')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3> Emitir Declaração </h3>
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
            <form method="POST" action="{{ route('documentos.declaracoes.imprimir') }}" target="_blank" class="row">
                @csrf
                <div class="form-group col-4">
                    <label for="processo" class="form-label">Número de processo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="processo"
                        placeholder="Número de processo" value="" id="processo" required>
                </div>
              
                <div class="form-group col-md-4">
                    <label for="id_classe" class="form-label">Dá Classe:</label>
                    <select name="id_classe" id="id_classe" class="form-control">
                        <option value="" >Selecciona a Classe</option>
                        @foreach (fh_classes()->get() as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ª classe
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-md-4">
                    <label for="id_classe_2" class="form-label">Para Classe:</label>
                    <select name="id_classe_2" id="id_classe_2" class="form-control">
                        <option value="" >Selecciona a Classe</option>
                        @foreach (fh_classes()->get() as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ª classe
                            </option>
                        @endforeach
                    </select>

                </div>
              
                <div class="form-group col-4">
                    <label for="numero" class="form-label">  Declaração nº:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="numero"
                        placeholder="Nº" value="" id="numero" required>
                </div>

             
                <div class="form-group col-4">
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

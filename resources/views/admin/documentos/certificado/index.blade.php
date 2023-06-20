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
                    <label for="id_classe" class="form-label">Para Classe:</label>
                    <select name="id_classe" id="id_classe" class="form-control">
                        <option value="" >Selecciona a Classe</option>
                        @foreach (fh_classes()->get() as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ª classe
                            </option>
                        @endforeach
                    </select>

                </div>
                <div class="form-group col-4">
                    <label for="decreto" class="form-label"> Decreto Executivo nº:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="decreto"
                        placeholder="______/ _____ de _____" value="" id="decreto" required>
                </div>
               
                <div class="form-group col-4">
                    <label for="artigo" class="form-label"> Artigo:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="artigo"
                        placeholder="Nº" value="" id="artigo" required>
                </div>
                <div class="form-group col-4">
                    <label for="LBSEE" class="form-label"> LBSEE de:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="LBSEE"
                        placeholder="__/__ de ___ de ___" value="" id="LBSEE" required>
                </div>
               
                <div class="form-group col-4">
                    <label for="lei" class="form-label"> Conjugada com a lei :</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="lei"
                        placeholder="__/__ de ___ de _______-" value="" id="lei" required>
                </div>
           
                <div class="form-group col-4">
                    <label for="registo" class="form-label"> Registo nº:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="registo"
                        placeholder=" ____/20___" value="" id="registo" required>
                </div>

                <div class="form-group col-4">
                    <label for="folha" class="form-label">Folha nº:</label>
                    <input type="text" class="form-control border-secondary col-sm-12" name="folha"
                        placeholder="Folha nº" value="" id="folha" required>
                </div>
                <div class="form-group col-4">
                    <label for="processo" class="form-label" >Ensino:</label>
                    <select name="ensino" id="" class="form-control" required>
                        <option  selected disabled>Selecciona a opção</option>
                        <option value="Iº CICLO DO ENSINO SECUNDÁRIO GERAL">IIº CICLO DO ENSINO SECUNDÁRIO GERAL</option>
                        <option value="IIº CICLO DO ENSINO SECUNDÁRIO GERAL">IIº CICLO DO ENSINO SECUNDÁRIO GERAL</option>
                        <option value="IIº CICLO DO ENSINO SECUNDÁRIO TÉCNICO ">IIº CICLO DO ENSINO SECUNDÁRIO TÉCNICO </option>
                    
                    </select>
                   
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

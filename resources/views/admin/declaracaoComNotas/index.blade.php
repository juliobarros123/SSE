

    @extends('layouts.admin')

    @section('titulo', 'Declaração/Gerar')
    
     @section('conteudo')
        <div class="card mt-3">
            <div class="card-body">
                <h3> Declaração com notas</h3>
            </div>
        </div>
    
    <div class="card">
        <div class="card-body">
        @if ($errors->any())
        <div class="text-center">
            
                @foreach ($errors->all() as $error)
                <i> <p class="text-danger text-center">{{ $error }}</p></i>
                @endforeach
            
        </div>
    @else
    <div class=" text-center text-info">
        
         
                <p><i>Insira o número de processo e informa a classe</i></p>
         
        
    </div>
    @endif
</div>
</div>
     
        <div class="card">
            
            <!-- /.card-header -->
            <div class="card-body">
                <form method="POST" action="{{ route('declaracaoComNotas.buscarAluno') }}" class="row">
                    @csrf
                     @include('forms._formDeclaracoesComNotas.criar.index')
                     <div class="form-group col-sm-1">
                        <label class="form-label text-white">.</label><br>
                        <button class="btn btn-dark " type="submit">Gerar </button>
                    </div>
                </form>
            </div>
    
        </div>
        <!-- /.card -->
    
    <!-- Footer-->
    @include('admin.layouts.footer')
    @endsection
    
    
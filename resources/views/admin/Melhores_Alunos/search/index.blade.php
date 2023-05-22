@extends('layouts.admin')
@section('titulo', 'Quadro de honra')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Melhores Alunos</h3>
        </div>
    </div>


    @if (isset($errors) && count($errors) > 0)
        <div class="text-center mt-4 mb-4 alert-danger">
            @foreach ($errors->all() as $erro)
                <h5>{{ $erro }}</h5>
            @endforeach
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <form action="{{ url('/admin/aluno/send/') }}" class="row" method="POST" target="_blenk">
                @csrf
                <div class="form-group col-md-3">
                    <label>Trimestre</label>
                    <select name="vc_nomeT" class="form-control border-secondary" required>
                        <option selected disabled value="">Selecione uma das opções:</option>
                        <option value="I">Iºtrimestre</option>
                        <option value="II">IIºtrimestre</option>
                        <option value="III">IIIºtrimestre</option>
                    </select>
                </div>
                <div class="form-group col-md-2">
                    <label for="classe">Classe</label>
                    <select name="classe" id="classe" class="form-control border-secondary" required>
                        <option selected disabled value="">Selecione uma das opções:</option>
                        @foreach ($classes as $classe)
                            <option value="{{ $classe->id }}">
                                {{ $classe->vc_classe }}ªclasse
                            </option>
                        @endforeach
                    </select>

                </div>

                <div class="form-group col-md-3">

                    <label for="vc_anolectivo">Ano Lectivo</label>
                    @if (isset($ano_lectivo_publicado))
                        <select name="vc_anolectivo" id="vc_anolectivo" class="form-control" readonly>
                            <option value="{{ $id_anoLectivo_publicado }}">
                                {{ $ano_lectivo_publicado }}
                            </option>
                        </select>
                        <p class="text-danger  "> Atenção: Ano lectivo publicado</p>
                    @else
                        <select name="vc_anolectivo" id="vc_anolectivo" class="form-control border-secondary" required>
                            <option selected disabled value="">Selecione uma das opções:</option>
                            @foreach ($anoslectivos as $anolectivo)
                                <option value="{{ $anolectivo->id }}">
                                    {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </div>
                <div class="form-group col-md-2">
                    <label for="papel">1º Nota</label>
                    <input name="nota" id="nota" placeholder="Digita a nota" class="form-control border-secondary"
                        type="number">
                </div>
                <div class="form-group col-md-2">
                    <label for="papel">2º Nota</label>
                    <input name="nota2" id="nota2" placeholder="Digita a nota" class="form-control border-secondary"
                        type="number">
                </div>
                <div class="form-group col-md-2">
                    <label for="papel" hidden>Formato da folha</label>
                    <select name="papel" id="papel" hidden  class="form-control border-secondary" required>
                        <option value="A3">A3</option>
                        {{-- <option value="A4"> A4</option> --}}
                    </select>

                </div>
            

                <div class="form-group col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button type="submit" class="form-control btn btn-dark">Visualizar</button>

                </div>

            </form>
        </div>
    </div>

    @include('admin.layouts.footer')
    <script src="/js/sweetalert2.all.min.js"></script>
    @if (session('aviso'))
        <script>
            Swal.fire(
                ' Quadro de honra vazio',
                '',
                'error'
            )
        </script>
    @endif
@endsection

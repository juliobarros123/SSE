@extends('layouts.admin')

@section('titulo', 'Nota/Inserir')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir Nota</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="row" action="{{ url('/admin/nota/send/') }}">
                @csrf
                <div class="col-md-6">
                    <label for="it_idAluno" class="form-label">Introduza o número de processo</label>
                    <input type="number" autocomplete="off" name="it_idAluno" placeholder="Introduzir o número de processo"
                        class="form-control" id="it_idAluno" required>
                </div>
                <div class="col-md-4">
                    <label for="vc_anoletivo" class="form-label">Ano Lectivo actual</label>
                    <input type="text" name="vc_anoletivo" value="{{ $anoactual->ya_inicio . '-' . $anoactual->ya_fim }}"
                        readonly class="form-control" id="vc_anoletivo">
                </div>

                <div class="col-md-2">
                    <label class="form-label text-white">.</label><br>
                    <button id="btn_consulta" class="form-control btn btn-dark">Pesquisar</button>
                </div>
            </form>
        </div>
    </div>


    <div class="card" id="result">
        <div class="card-body">
            <form form action="{{ url('/nota') }}" method="post" class="row">
                @csrf
                @isset($searchs)
                    @foreach ($searchs as $search)
                        <div class="col-md-12">

                            <div class="col-md-12 text-center">
                                <img src="{{asset('/{{ $search->vc_imagem }}" width="100">
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <label>Processo</label>
                                        <input type="text" class="form-control border-secondary " readonly
                                            value="{{ isset($search->it_idAluno) ? $search->it_idAluno : '' }}">

                                    </div>
                                    <div class="form-group col-md-10">
                                        <label>Nome Completo</label>
                                        <input type="text" class="form-control border-secondary " readonly
                                            value="{{ isset($search->vc_primeiroNome) ? $search->vc_primeiroNome . ' ' . $search->vc_nomedoMeio . ' ' . $search->vc_ultimoaNome : '' }}">

                                    </div>
                                </div>

                            </div>


                        </div>
                        @include('forms._formNota.index')
                        <div class="form-group col-md-2">
                            <label for="" class="form-label text-white">.</label>
                            <button class="form-control  btn btn-dark">Inserir</button>
                        </div>
                        <div class="form-group col-md-1">
                            <input type="hidden" id="aluno" class="form-control border-secondary" placeholder="Processo"
                                readonly name="it_idAluno"
                                value="{{ isset($search->it_idAluno) ? $search->it_idAluno : '' }}">
                        </div>
                    @endforeach
                @else
                    @if (session('danger'))
                        <h6 class="text-center col-12 text-danger"><i>{{ session('danger') }}</i></h6>
                    @else
                        <h6 class="text-center col-12"><i>Introduza o número de processo para proceder
                                com a inserção da nota</i></h6>
                    @endif
                @endisset

            </form>

        </div>
    </div>

    <!-- sweetalert -->
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('ExisteNota'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Nota do Aluno já foi introduzida',
                'error'
            )

        </script>
    @endif

    @if (session('status'))
        <script>
            Swal.fire(
                'Nota inserida ',
                '',
                'success'
            )

        </script>
    @endif

    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

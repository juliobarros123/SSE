@extends('layouts.admin')

@section('titulo', 'Nota/Editar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Editar Nota</h3>
        </div>
    </div>



    <div class="card">
        <div class="card-body">
            <form action="{{ route('admin.notas.editar.index', $notas->id) }}" method="POST" class="row">
                @method('PUT')
                @csrf

                <div class="form-group col-md-2">
                    <label for="aluno">Nº de Processo</label>
                    <input id="aluno" class="form-control border-secondary" placeholder="Processo" name="it_idAluno"
                        value="{{ isset($notas->it_idAluno) ? $notas->it_idAluno : '' }}" readonly>
                </div>
                @foreach ($searchs as $search)

                    <div class="form-group col-md-4">
                        <label>Nome Completo</label>
                        <input type="text" class="form-control border-secondary " readonly
                            value="{{ isset($search->vc_primeiroNome) ? $search->vc_primeiroNome . ' ' . $search->vc_nomedoMeio . ' ' . $search->vc_ultimoaNome : '' }}">

                    </div>
                @endforeach


                @foreach ($disciplinas as $disciplina)
                    <div class="form-group col-md-4">
                        <label>Disciplina</label>
                        <input type="text" class="form-control border-secondary " readonly placeholder="Disciplina"
                            value="{{ $disciplina->vc_nome }}">
                    </div>
                @endforeach
                <div class="form-group col-md-3">
                    <label for="vc_nomeT" class="form-label">Trimestre</label>
                    <input type="text" class="form-control border-secondary " readonly placeholder="Trimestre"
                        name="vc_nomeT" value="{{ isset($notas->vc_nomeT) ? $notas->vc_nomeT : '' }}ºTrimestre">
                </div>
                <div class="form-group col-md-2" id="mac" >
                    <label>MAC</label>
                    <input type="number" min="0" max="20" step="any" class="form-control border-secondary" placeholder="MAC"
                    name="fl_mac" value="{{ isset($notas->fl_mac) ? $notas->fl_mac : '' }}">
                </div>

                <div class="form-group col-md-2">
                    <label>Nota 1</label>
                    <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                        placeholder="Nota 1" name="fl_nota1" value="{{ isset($notas->fl_nota1) ? $notas->fl_nota1 : '' }}"
                        required>
                </div>
                <div class="form-group col-md-2">
                    <label>Nota 2</label>
                    <input type="number" min="0" max="20" step="any" class="form-control border-secondary"
                        placeholder="Nota 2" name="fl_nota2"
                        value="{{ isset($notas->fl_nota2) ? $notas->fl_nota2 : '' }}">
                </div>

                <div class="form-group col-md-2">
                    <label for="" class="form-label text-white">.</label>
                    <button class="form-control  btn btn-dark">Editar</button>
                </div>

            </form>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

@if (session('status'))
    <script>
        Swal.fire(
            'Nota editada',
            '',
            'success'
        )

    </script>
@endif
<script>

    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

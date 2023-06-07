@extends('layouts.admin')

@section('titulo', 'Inserir nota/recurso')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir nota/recurso</h3>
            <div class="d-flex justify-content-end">
                @if (session('processos'))
                    <button type="button" class="btn btn-warning text-white" data-toggle="modal"
                        data-target="#exampleModal">Aviso</button>
                @endif
            </div>

        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Processos não vinculados nesta disciplina</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if (session('processos'))
                        @foreach (session('processos') as $item)
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">

                                    {{ alunoPorProcesso($item)->vc_primeiroNome . ' ' .alunoPorProcesso($item)->vc_nomedoMeio . ' ' . alunoPorProcesso($item)->vc_ultimoaNome }}
                                    <span class="badge badge-primary badge-pill">{{ $item }}</span>
                                </li>

                            </ul>
                        @endforeach
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>

                </div>
            </div>
        </div>
    </div>
    <div class="card">

        <div class="card-body">
            <form method="POST" class="" action="{{ route('admin.notas-recurso.cadastrar') }}">
                @csrf
                <div class="campos">

                    <div class="row">
                        <div class="form-group col-md-12">
                            <label>Disciplinas</label>
                            <select name="id_disciplina" class="  form-control  select-dinamico"
                                id="selectDisciplinaRecurso">
                                @isset($disciplinas)
                                @foreach ($disciplinas as $disciplina)
                                <option value="{{ $disciplina->id }}">{{ $disciplina->vc_nome }}</option>
                            @endforeach
                                @else
                                    <option selected value="{{ isset($dt) ? $dt->id_disciplina : '0' }}">
                                        {{ isset($dt) ? $dt->vc_nome : 'Seleciona a disciplina' }}
                                    </option>
                                @endisset

                            </select>
                        </div>
                        <div class="form-group col-md-12 d-flex justify-content-end">


                            <i hidden class="fas fa-user-edit" style="height: 26px;" id="maisCampoProcesso"></i>
                        </div>
                    </div>
                    <div id="camposProcesso">

                    </div>
                </div>
                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Inserir" id="inserir">
                </div>

            </form>

        </div>
    </div>
    <!-- sweetalert -->


    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>

    @if (session('processos'))
    @endif
    @if (session('status'))
        <script>
            Swal.fire(
                'Nota inserida com sucesso',
                '',
                'success'
            )
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire(
                'Aluno não está matriculado noutras classes',
                '',
                'error'
            )
        </script>
    @endif

    <!-- Footer-->
    @include('admin.layouts.footer')


    <style>
        .select2 {
            width: 100% !important;
        }
    </style>
@endsection

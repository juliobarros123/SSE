@extends('layouts.admin')

@section('titulo', 'Inserir nota seca')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir nota seca</h3>
        <h5 class="text-info ">{{$turma->vc_nomedaTurma}}/{{$turma->vc_cursoTurma}}/{{$turma->vc_anoLectivo}}/{{$turma->vc_classeTurma}}ªClasse</h5>
        </div>
    </div>

    
    <div class="card">

        <div class="card-body">
            <form method="POST" class="" target="_blank"
                action="{{route('notas-seca.cadastrar',['id_turma'=>$id_turma])}}">
                @csrf
                <?php $contador = 1; ?>

                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Nº </th>
                            <th scope="col">PROCESSO</th>
                            <th scope="col">NOME COMPLETO</th>
                            @foreach ($disciplinas as $item)
                            <th scope="col">{{$item->vc_acronimo}}</th>
                            @endforeach

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($alunos as $aluno)
                            <tr>
                                <td><?php echo $contador++; ?></td>
                                <th scope="row">{{ $aluno->id_aluno }}</th>
                                <td> {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                    {{ $aluno->vc_ultimoaNome }}</td>
                                    @foreach ($disciplinas as $item)
                                    <td>
                                        <div class="form-group  bg-danger">
                                            <input type="number" min="0" max="20" step="any"
                                                class="form-control border-secondary {{ceil(mediaDisciplinaNoAno($aluno->id_aluno, $id_turma, $item->id))>=10?'text-primary':'text-danger'}}" placeholder="Nota"
                                            name="idDCC_{{$item->id}}_{{$aluno->id_aluno}}" value="{{ceil(mediaDisciplinaNoAno($aluno->id_aluno, $id_turma, $item->id))}}"    >
                                        </div>
                                    </td>
                                    @endforeach
                            </tr>
                        @endforeach

                    </tbody>
                </table>
                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Inserir" id="inserir">
                </div>
            </form>

        </div>
    </div>
    <!-- sweetalert -->


    <script src="/js/sweetalert2.all.min.js"></script>

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



@endsection

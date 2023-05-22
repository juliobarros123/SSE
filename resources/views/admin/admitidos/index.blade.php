@extends('layouts.admin')

@section('titulo', 'Alunos/Listar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">

            <div class="row ">
                <div class="col-md-6">
                    <h3>Imprimir lista dos admitidos</h3>
                </div>
                <div class="row col-sm-6 d-flex justify-content-end">


                    {{-- <a type="submit" href="{{ route('admin.candidatos.editar_selecao') }}"
                        class="col-sm-4 m-1 btn btn-primary">Atualizar</a> --}}


                    <a type="submit" href="{{ url('admin/selecionados/pesquisar') }}"
                        class=" col-sm-4 m-1 btn btn-primary">voltar</a>

                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                        Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                        Auth::user()->vc_tipoUtilizador == 'Preparador')
                   
            
                        <a class="btn btn-dark ml-1" href="{{ route('admin.admitidos.eliminadas') }}">
                            <strong class="text-light">Eliminados</strong>
                        </a>
            
            
                @endif
            


                </div>
            </div>


        </div>
    </div>






   <div class="table-responsive">
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>Nº</th>
                <th>NOME</th>
                <th>CURSO</th>
                <th>BILHETE DE IDENTIDADE</th>
                <th>IDADE</th>
                <th>MEDIA</th>
                <th>FOTO</th>
                <th>ESTADO</th>
                <th>ACÇÕES</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @foreach ($alunos as $aluno)

                <tr class="text-center">
                    <td>{{ $aluno->id }}</td>
                    <td class="text-left">
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}
                    </td>
                    <td>{{ $aluno->vc_nomeCurso }}</td>
                    <td>{{ $aluno->vc_bi }}</td>
                    <td>{{ date('Y') - date('Y', strtotime($aluno->dt_dataNascimento)) }} anos</td>
                    {{-- <td>{{ $aluno->idade }}</td> --}}
                    <td>{{ $aluno->it_media }}</td>
                    <td>
                        <img src="{{asset('/confirmados/'. $aluno->foto) }}" width="50" height="50" alt="Sem Foto">
                    </td>

                    @if ($aluno->it_processo >  0)
                        <td id='ok{{ $aluno->id }}' class="text-green">Trasnferido</td>
                    @else
                        <td id='nt{{ $aluno->id }}' class="text-danger">N/Trasnferido</td>
                    @endif
                    <td>

                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        @if (isset($eliminadas))
                        <div class="dropdown">
                            <button class="btn btn-dark btn-sm dropdown-toggle" type="button"
                                id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                                <i class="fa fa-clone fa-sm" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ route('admin.admitidos.recuperar', $aluno->id) }}"
                                    class="dropdown-item ">Recuperar</a>
                                <a href="{{ route('admin.candidatos2.pulgar', $aluno->id) }}"
                                    class="dropdown-item " data-confirm="Tem certeza que deseja eliminar?">Purgar</a>
                            </div>
                        </div>
                         @else
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="#" type="button" data-toggle="modal" data-backdrop="static"
                                    data-target=".bd-example-modal-lg-{{ $aluno->id }}">Expandir</a>
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                <a class="dropdown-item" href="{{ route('selecionado.delete', $aluno->id) }}"
                                    data-confirm="Tem certeza que deseja eliminar?">Eliminar</a>


                                    <a class="dropdown-item" href="{{ route('admin.candidatos2.pulgar', $aluno->id) }}"
                                        data-confirm="confirmation message">Purgar</a>


                                @endif


                                @if ($aluno->it_processo <= 0)
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Comissão' || Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico'  || Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico')
                                        <a style="cursor: pointer;" codigoD='{{ $aluno->id }}'
                                           
                                            class="dropdown-item adimito-para-aluno  pre{{ $aluno->id }}">Transferir</a>
                                    @endif
                                @endif

                            </div>
                        </div>
                        @endif
                        @endif

                    </td>
                </tr>

                <div class="modal fade bd-example-modal-lg-{{ $aluno->id }}" tabindex="-1" role="dialog"
                    aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Processo: <b>{{ $aluno->id }}</b></h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">

                                <h5 class="text-left mb-2 ml-2"><b>Dados Pessoais</b></h5>
                                <p class="ml-4">
                                    <b>Nome Completo:
                                    </b>{{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_ultimoaNome }}<br>

                                    <b>Data de Nascimento: </b>
                                    {{ date('d-m-Y', strtotime($aluno->dt_dataNascimento)) }}<br>
                                    <b>Idade: </b>
                                    {{ date('Y') - date('Y', strtotime($aluno->dt_dataNascimento)) }} anos<br>

                                    <b>Nome do Pai: </b>
                                    {{ $aluno->vc_namePai }}<br>
                                    <b>Nome da Mãe: </b>
                                    {{ $aluno->vc_nameMae }}<br>
                                    <b>Genero: </b>
                                    {{ $aluno->vc_genero }}<br>
                                    <b>Deficiênte Físico?: </b>
                                    {{ $aluno->vc_dificiencia }}<br>
                                    <b>Estado Civil: </b>
                                    {{ $aluno->vc_estadoCivil }}<br>
                                    <b>Telefone: </b>
                                    {{ $aluno->it_telefone }}<br>
                                    <b>Email: </b>
                                    {{ $aluno->vc_email }}<br>
                                    <b>Residência: </b>
                                    {{ $aluno->vc_residencia }}<br>
                                    <b>Naturalidade: </b>
                                    {{ $aluno->vc_naturalidade }}<br>
                                    <b>Provincia: </b>
                                    {{ $aluno->vc_provincia }}<br>
                                    <b>Bilhete de Identidade Nº: </b>
                                    {{ $aluno->vc_bi }}<br>
                                    <b>Data de emissão do bilhete de Identidade: </b>
                                    {{ date('d-m-Y', strtotime($aluno->dt_emissao)) }}<br>
                                    <b>Local de emissão do Bilhete de Identidade: </b>
                                    {{ $aluno->vc_localEmissao }}<br>
                                </p>
                                <h5 class="text-left mb-2 mt-2 ml-2"><b>Dados Acadêmicos</b></h5>
                                <p class="ml-4">
                                    <b>Escola Anterior: </b>
                                    {{ $aluno->vc_EscolaAnterior }}<br>

                                    <b>Ano de Conclusão: </b>
                                    {{ $aluno->ya_anoConclusao }}
                                </p>
                                <h5 class="text-left mt-2 ml-2"><b>Dados da Nova Escola</b></h5>
                                <p class="ml-4">
                                    <b>Curso escolhido: </b>
                                    {{ $aluno->vc_nomeCurso }}<br>
                                    <b>Classe Inicial: </b>
                                    {{ $aluno->it_classe }}ªClasse<br>
                                    <b>Ano Lectivo de Inscrição: </b>
                                    {{ $aluno->vc_anoLectivo }}
                                </p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach


        </tbody>

    </table>

   </div>

    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <script>
        $(document).ready(function() {

            //start delete
            $('a[data-confirm]').click(function(ev) {
                var href = $(this).attr('href');
                if (!$('#confirm-delete').length) {
                    $('table').append(
                        '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
                    );
                }
                $('#dataConfirmOk').attr('href', href);
                $('#confirm-delete').modal({
                    shown: true
                });
                return false;

            });
            //end delete
        });
    </script>
    @include('admin.layouts.footer')

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('up'))
        <script>
            Swal.fire(
                'Seleção actualizada com sucesso!',
                '',
                'success'
            )
        </script>
    @endif


@if (session('user.eliminar.success'))
<script>
    Swal.fire(
        'Aluno Eliminado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('admitido.eliminar.error'))
<script>
    Swal.fire(
        'Erro ao Eliminar Aluno! ',
        '',
        'error'
    )
</script>
@endif

@if (session('admitido.purgar.success'))
<script>
    Swal.fire(
        'Aluno Purgado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('admitido.purgar.error'))
<script>
    Swal.fire(
        'Erro ao Purgar Aluno! ',
        '',
        'error'
    )
</script>
@endif

@if (session('admitido.recuperar.success'))
<script>
    Swal.fire(
        'Aluno Recuperado Com Sucesso! ',
        '',
        'success'
    )
</script>
@endif
@if (session('admitido.recuperar.error'))
<script>
    Swal.fire(
        'Erro ao Recuperar Aluno! ',
        '',
        'error'
    )
</script>
@endif

@endsection

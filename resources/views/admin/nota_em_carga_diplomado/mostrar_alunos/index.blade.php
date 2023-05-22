@extends('layouts.admin')

@section('titulo', 'Inserir Notas em Carga')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <h3>Inserir Notas em Carga</h3>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <form method="POST" class="" target="_blank"
                action="{{ url("/nota_em_carga_diplomado/$it_idCurso/$it_idClasse/$it_idTurma/$id_anoLectivo/$vc_tipodaNota/$it_disciplina/inserir") }}">
                @csrf






                <?php $contador = 1; ?>

                <table class="table table-hover ">
                    <thead>
                        <tr>
                            <th scope="col">Nº </th>
                            <th scope="col">PROCESSO</th>
                            <th scope="col">NOME COMPLETO</th>
                            {{-- <th scope="col">ÚLTIMO NOME</th> --}}
                            <th scope="col">NOTA</th>
                            <th scope="col">NOTA 1</th>
                            <th scope="col">NOTA 2</th>
                            <th scope="col">MAC</th>
                            <th scope="col">INDIVÍDUO </th>
                        </tr>
                    </thead>











                    <tbody>
                        @if ($alunos)
                            @foreach ($alunos as $aluno)
                                @if (isset($aluno->vc_tipodaNota) && $aluno->vc_tipodaNota == $vc_tipodaNota)
                                    <div class="modal fade" id="exampleModal{{ $aluno->id_aluno }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class=" d-flex justify-content-center">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">

                                                            {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                                            {{ $aluno->vc_ultimoaNome }}
                                                        </h3>

                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mx-auto text-center">
                                                        {{-- <img class="img-circle" src="{{asset('/{{ $aluno->vc_imagem }}" width="250"
                                                            height="250"> --}}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <tr>
                                        <td><?php echo $contador++; ?></td>
                                        <th scope="row">{{ $aluno->id_aluno }}</th>
                                        <td> {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                            {{ $aluno->vc_ultimoaNome }}</td>
                                        {{-- <td >{{ $aluno->vc_primeiroNome }}</td>
                                        <td>{{ $aluno->vc_ultimoaNome }}</td> --}}
                                        <td> <input type="number" min="0" max="20" step="any"
                                                class="form-control border-secondary nota-final" placeholder="Nota final"
                                                id="processo_{{ $aluno->id_aluno }}"
                                                name="nota_final{{ $aluno->id_aluno }}" value=""></td>
                                        <td>
                                            @if ($estados_de_notas_unica[0]->estado == 1)
                                                <div class="form-group  bg-danger">
                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota1 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota1) ? $aluno->fl_nota1 : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary " placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 1"
                                                            name="fl_nota1_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group  bg-danger">
                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary text-danger {{ $aluno->fl_nota1 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota1) ? $aluno->fl_nota1 : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 1"
                                                            name="fl_nota1_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>


                                        <td>
                                            @if ($estados_de_notas_unica[1]->estado == 1)
                                                <div class="form-group " id="provadois">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota2 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota2) ? $aluno->fl_nota2 : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 2"
                                                            name="fl_nota2_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group " id="provadois">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota2 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota2) ? $aluno->fl_nota2 : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 2"
                                                            name="fl_nota2_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif

                                        </td>



                                        <td>

                                            @if ($estados_de_notas_unica[2]->estado == 1)
                                                <div class="form-group " id="mac">



                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_mac <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="MAC" name="fl_mac_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_mac) ? $aluno->fl_mac : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="MAC"
                                                                name="fl_mac_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="MAC"
                                                            name="fl_mac_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group " id="mac">



                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_mac <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="MAC" name="fl_mac_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_mac) ? $aluno->fl_mac : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="MAC"
                                                                name="fl_mac_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="MAC"
                                                            name="fl_mac_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif






                                        </td>




                                        <td>
                                            <div class="d-flex justify-content-center">

                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal{{ $aluno->id_aluno }}">
                                                    FOTOGRÁFIA
                                                </button>
                                            </div>
                                        </td>


                                    </tr>
                                @else
                                    <div class="modal fade" id="exampleModal{{ $aluno->id_aluno }}" tabindex="-1"
                                        role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class=" d-flex justify-content-center">
                                                    <div class="modal-header">
                                                        <h3 class="modal-title" id="exampleModalLabel">
                                                            {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_ultimoaNome }}
                                                        </h3>

                                                    </div>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="col mx-auto text-center">
                                                        {{-- <img class="img-circle" src="{{asset('/{{ $aluno->vc_imagem }}"
                                                            width="250" height="250"> --}}
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary"
                                                        data-dismiss="modal">Close</button>

                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <tr>
                                        <td><?php echo $contador++; ?></td>
                                        <th scope="row">{{ $aluno->id_aluno }}</th>
                                        <td> {{ $aluno->vc_primeiroNome }} {{ $aluno->vc_nomedoMeio }}
                                            {{ $aluno->vc_ultimoaNome }}</td>
                                        <td> <input type="number" min="0" max="20" step="any"
                                                class="form-control border-secondary nota-final " placeholder="Nota final"
                                                id="processo_{{ $aluno->id_aluno }}"
                                                name="nota_final{{ $aluno->id_aluno }}" value=""></td>
                                        {{-- <td>{{ $aluno->vc_primeiroNome }}</td>
                                        <td>{{ $aluno->vc_ultimoaNome }}</td> --}}
                                        <td>
                                            @if ($estados_de_notas_unica[0]->estado == 1)
                                                <div class="form-group  bg-danger">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota1 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota1) ? $aluno->fl_nota1 : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 1"
                                                            name="fl_nota1_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group  bg-danger">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota1 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota1) ? $aluno->fl_nota1 : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 1"
                                                                name="fl_nota1_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 1"
                                                            name="fl_nota1_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif
                                        </td>


                                        <td>
                                            @if ($estados_de_notas_unica[1]->estado == 1)
                                                <div class="form-group " id="provadois">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota2 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota2) ? $aluno->fl_nota2 : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 2"
                                                            name="fl_nota2_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group " id="provadois">


                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_nota2 <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_nota2) ? $aluno->fl_nota2 : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="Nota 2"
                                                                name="fl_nota2_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="Nota 2"
                                                            name="fl_nota2_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif


                                        </td>



                                        <td>

                                            @if ($estados_de_notas_unica[2]->estado == 1)
                                                <div class="form-group " id="mac">



                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_mac <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="MAC" name="fl_mac_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_mac) ? $aluno->fl_mac : '' }}">
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="MAC"
                                                                name="fl_mac_{{ $aluno->id_aluno }}">
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="MAC"
                                                            name="fl_mac_{{ $aluno->id_aluno }}">
                                                    @endif
                                                </div>
                                            @else
                                                <div class="form-group " id="mac">



                                                    @if (isset($aluno->vc_tipodaNota))
                                                        @if ($aluno->vc_tipodaNota == $vc_tipodaNota)
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary {{ $aluno->fl_mac <= 9 ? 'text-danger' : '' }}"
                                                                placeholder="MAC" name="fl_mac_{{ $aluno->id_aluno }}"
                                                                value="{{ isset($aluno->fl_mac) ? $aluno->fl_mac : '' }}"
                                                                readonly>
                                                        @else
                                                            <input type="number" min="0" max="20" step="any"
                                                                class="form-control border-secondary" placeholder="MAC"
                                                                name="fl_mac_{{ $aluno->id_aluno }}" readonly>
                                                        @endif
                                                    @else
                                                        <input type="number" min="0" max="20" step="any"
                                                            class="form-control border-secondary" placeholder="MAC"
                                                            name="fl_mac_{{ $aluno->id_aluno }}" readonly>
                                                    @endif
                                                </div>
                                            @endif






                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                                    data-target="#exampleModal{{ $aluno->id_aluno }}">
                                                    FOTOGRÁFIA
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                    </tbody>
                </table>

                @endif










                <div class=" col-md-12 text-center">
                    <input type="submit" class=" col-md-2 text-center btn btn-dark" value="Inserir" id="inserir">
                </div>
            </form>

        </div>
    </div>

    <!-- sweetalert -->

    <script src="{{asset('/js/datatables/jquery-3.5.1.js')}}"></script>

    <script>


    </script>

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
    @if (session('error'))
        <script>
            Swal.fire(
                'Falha ao Introduzir a Nota!',
                'Verifica o relacionamento da disciplina com curso',
                'error'
            )
        </script>
    @endif


    <!-- Footer-->
    @include('admin.layouts.footer')
    <script>
        $('.nota-final').on('keyup', function() {
            var nota = $(this).val();
            if (nota > 20) {
                $(this).val(20);
            } else if (nota < 0) {
                $(this).val(0);
            }
            var id = this.id;
            var id = this.id;
            var processo = ray = id.split('_')[1];
            var notas = dividirNotas(nota);
            $("input[name=fl_nota1_" + processo + "]").val(notas[0]);
            $("input[name=fl_nota2_" + processo + "]").val(notas[1]);
            $("input[name=fl_mac_" + processo + "]").val(notas[2]);
        });

        function dividirNotas(nota) {
            var notas = [];
            if(nota>=0 && nota<=20){
            estado = 1;
            while (estado) {
                notas['0'] = Math.floor(Math.random() * nota);
                notas['1'] = Math.floor(Math.random() * notas['0']);
                notas['2'] = nota - (notas['0'] + notas['1']);
                if (notas['0'] < 0 || notas['2'] < 0 || notas['3'] < 0) {
                    estado = 1;
                } else {
                    estado = 0;
                }
            }
        }

            return notas;
        }
    </script>

@endsection

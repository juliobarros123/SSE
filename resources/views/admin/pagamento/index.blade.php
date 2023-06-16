@extends('layouts.admin')

@section('titulo', 'Lista de Pagamentos')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Pagamentos do mês de <strong> {{$mes}}</strong></h3>
        </div>
    </div>



    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
            Auth::user()->vc_tipoUtilizador == 'Preparador')
        <div class="d-flex justify-content-end mb-3">
            {{-- <a class="btn btn-dark" href="{{ route('tipos-pagamento.criar') }}">
                <strong class="text-light">Cadastrar</strong>
            </a> --}}
        </div>
    @endif

    <table id="example" class="display table table-hover">
        <thead class="">
            <tr class="text-center">
                <th>ID</th>
                <th>PROCESSO</th>
                <th>NOME DO ALUNO</th>
                <th>MÊS</th>
                <th>VALOR</th>

                <th>MULTA</th>

                <th>DATA DO PAGAMENTO</th>
                <th>ANO LECTIVO</th>
            </tr>
        </thead>
        <tbody class="bg-white">
            @if ($pagamentos)
                @foreach ($pagamentos as $pagamento)
                    {{-- @dump($dt) --}}
                    <tr class="text-center">
                        <th>{{ $pagamento->id }}</th>
                        <th>{{ $pagamento->processo }}</th>

                        <th>{{ $pagamento->vc_primeiroNome }}
                            {{ $pagamento->vc_apelido }}</th>
                        <td>{{ $pagamento->mes }}</td>

                        <td> {{ $pagamento->valor }}</td>
                        <td>
                            {{ $multa = fha_calcular_valor_pagar(date('Y-' . fha_obterNumeroMes($pagamento->mes) . "-$pagamento->dias_multa"), 0, $pagamento->dias_multa, $pagamento->multa_valor) }}
                        </td>
                        <td>{{ converterData($pagamento->created_at) }}</td>
                        <td> {{ $pagamento->ya_inicio }}/{{ $pagamento->ya_fim }}</td>



                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
    <script src="{{ asset('/js/datatables/jquery-3.5.1.js') }}"></script>

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
    <!-- Footer-->
    @include('admin.layouts.footer')


@endsection

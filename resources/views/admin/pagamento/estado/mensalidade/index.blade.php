@extends('layouts.admin')

@section('titulo', 'Pesquisar Aluno')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Cartão de Pagamento</h3>
            <div class="card-title">Aluno: <strong>{{ $matricula->vc_primeiroNome }}
                    {{ $matricula->vc_apelido }}</strong>
                Processo: <strong>{{ $matricula->processo }}
                </strong> </div>
        </div>
    </div>
    {{-- @dump($matricula); --}}


    @if (session('aviso'))
        <h5 class="text-center alert alert-danger">{{ session('aviso') }}</h5>
    @endif
    <div class="card">
        <div class="card-body">

            <div class="row d-flex justify-content-center">
                <!-- Earnings (Monthly) Card Example -->
                @php
                    $meses = fha_obter_numeros_meses($inicio_termino_ano_lectivo->mes_inicio, $inicio_termino_ano_lectivo->mes_termino);
                    //   $meses=fha_obter_numeros_meses('Janeiro','Dezembro');
                    // dd($meses);
                @endphp
                @foreach ($meses as $numero_mes)
                    <div class="col-sm-3 statistic-card m-1 ">
                        @php
                            $mes_extenso = fh_meses()[$numero_mes];
                            $pagamento = fh_pagamento($mes_extenso, $matricula->processo, $matricula->it_idAnoLectivo);
                            $estado_pago = $pagamento->count();
                            $pagamento = $pagamento->first();
                            $tipo_pagamento = fh_tipos_pagamento()
                                ->where('tipo_pagamentos.id_classe', $matricula->id_classe)
                                ->where('tipo_pagamentos.tipo', 'Mensalidades')
                                ->first();
                            // dd( $tipo_pagamento );
                        @endphp
                        <div class="text-xs font-weight-bold text-uppercase ">
                            {{ $mes_extenso }}

                        </div>



                        @if ($estado_pago)
                            <div class="h5 mb-0 font-weight-bold text-success ">
                                Pago
                            </div>
                        @else
                            <div class="h5 mb-0 font-weight-bold text-danger ">
                                Não Pago
                            </div>
                        @endif
                        {{-- {{ dividas_por_contrato($contrato->id) }} --}}



                        <div class="mt-2 mb-0 text-muted text-xs">
                            <span class="text-success mr-2"><i class="fa fa-calendar"></i>

                                Valor:{{ $tipo_pagamento->valor }}

                            </span>
                            <span class="text-success mr-2"><i class="fa fa-calendar"></i>
                                @php
                                    $multa = fha_calcular_valor_pagar(date('Y-' . $numero_mes . "-$tipo_pagamento->dias_multa"), $tipo_pagamento->valor, $tipo_pagamento->dias_multa, $tipo_pagamento->multa_valor);
                                @endphp
                                Multa:{{$multa}}


                            </span>
                            <br>
                            <span class="text-success mr-2"><i class="fa fa-calendar"></i>
                                Data de pagamento:
                                @if (isset($pagamento->created_at))
                                    {{ converterData($pagamento->created_at) }}
                                @else
                                    -------
                                @endif

                            </span>
                            {{-- @dump( $matricula) --}}
                        </div>
                        <div class="mt-2 w-100 mb-0 text-muted text-xs">
                            {{-- @dump( $matricula->processo) --}}

                            @if ($estado_pago)
                                <a type="submit"href="{{ route('pagamentos.anular_pagamento', [
                                    'slug_pagamento' => $pagamento->slug,
                                ]) }}"
                                    class="text-white btn btn-dark ">Anular Pagamento </a>
                                <a target="_blank"
                                    href="{{ route('pagamentos.fatura', [
                                        'slug_pagamento' => $pagamento->slug,
                                    ]) }}"
                                    class="text-white btn btn-dark ">Fatura</a>
                            @else

                                <a href="{{ route('pagamentos.pagar_mensalidade', [
                                    'slug_tipo_pagamento' => $tipo_pagamento->slug,
                                    'processo' => $matricula->processo,
                                    'slug_ano_lectivo' => fh_anos_lectivos()->where('anoslectivos.id', $matricula->it_idAnoLectivo)->first()->slug,
                                    'mes' => $mes_extenso,
                                    'valor_final'=>  $multa
                                ]) }}"
                                    type="submit" class="text-white btn btn-success mb-1">Pagar</a>
                            @endif



                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection

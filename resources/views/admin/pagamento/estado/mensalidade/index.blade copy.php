@extends('layouts.admin')

@section('titulo', 'Pesquisar Aluno')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Pesquisar Aluno</h3>
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
                @for ($i = fha_obterNumeroMes($inicio_termino_ano_lectivo->mes_inicio); $i <= fha_obterNumeroMes($inicio_termino_ano_lectivo->mes_termino); $i++)
                    @php
                        $mes_valido = fh_mes_valido('Mensalidades', fh_meses()[$i], $matricula->id_classe)->first();
                        
                    @endphp
                
                        <div class="col-sm-3 statistic-card m-1 ">

                            <div class="text-xs font-weight-bold text-uppercase ">
                                @php
                                    $pagamento = fh_pagamento_estado($mes_valido->id, $matricula->processo, $matricula->it_idAnoLectivo);
                                    $estado_pago = $pagamento->count();
                                    $pagamento = $pagamento->first();
                                    
                                @endphp
                                {{ fh_meses()[$i] }} <span
                                    class="{{ $mes_valido ? 'text-success' : 'text-danger' }}">({{ $mes_valido ? 'Válido' : 'inválido' }})</span>
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

                                    Valor:{{ isset($mes_valido->valor) ? $mes_valido->valor : 0 }} akz

                                </span>
                                <span class="text-success mr-2"><i class="fa fa-calendar"></i>

                                    Multa:
                                    {{-- @dump(date('Y-' . fha_obterNumeroMes(fh_meses()[$i]) . "-$mes_valido->dias_multa")) --}}
                                    {{ fha_calcular_valor_pagar(date('Y-' . fha_obterNumeroMes(fh_meses()[$i]) . "-$mes_valido->dias_multa"), $mes_valido->valor, $mes_valido->dias_multa, $mes_valido->multa_valor) }}akz

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
                                @if ($mes_valido)
                                    @if ($estado_pago)
                                        <a type="submit"href="{{ route('pagamentos.anular_pagamento', [
                                            'slug_pagamento' => $pagamento->slug,
                                        ]) }}"
                                            class="text-white btn btn-dark ">Fatura</a>
                                        <a type="submit" class="text-white btn btn-dark ">Anular Pagamento</a>
                                    @else
                                        <a href="{{ route('pagamentos.pagar_mensalidade', [
                                            'slug_tipo_pagamento' => $mes_valido->slug,
                                            'processo' => $matricula->processo,
                                            'slug_ano_lectivo' => fh_anos_lectivos()->where('anoslectivos.id', $matricula->it_idAnoLectivo)->first()->slug,
                                        ]) }}"
                                            type="submit" class="text-white btn btn-success mb-1">Pagar</a>
                                    @endif
                                @endif

                            </div>


                        </div>
                
                @endfor
            </div>
        </div>
    </div>


    @include('admin.layouts.footer')

@endsection

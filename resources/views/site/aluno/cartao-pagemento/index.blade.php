@extends('site.layouts.app')
@section('titulo', 'Cartão de Pagemento')
@section('conteudo')
    <div class="card mb-3">
        <div class="card-body">
            <div class="card-title">Cartão de Pagemento </div>
        </div>
    </div>
    <div class="card mb-3">
        <div class="card-body">
            <form form action="{{ route('painel.alunos.cartoes_pagamento') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="row d-flex">
                    <div class=" form-group col-md-4    " hidden>
                        <label for="processo" class="form-label">Processo:</label>
                        <input type="number" autocomplete="off" name="processo" value="{{session()->get('aluno_login')['processo']}}"
                            placeholder="Introduza o número de processo" class="form-control border-secondary"
                            id="processo" required>
                    </div>
                    <div class="form-group col-md-4" hidden>
                        <label>Tipo de Pagamento:</label>
                        <select name="tipo" class="form-control select-dinamico " required>
                            {{-- <option value="" selected disabled>Selecciona o Tipo de Pagamento</option> --}}
                            <option value="Mensalidades" selected>Mensalidades</option>
                           
                          
                        </select>
                    </div>

                    <div class="form-group col-md-4">
                        <label for="vc_anolectivo" class="form-label">Ano Lectivo:</label>


                            <select name="id_ano_lectivo" id="id_ano_lectivo" class="form-control" required>
                                <option value="">Selecciona o Ano lectivo</option>
                                @foreach (fh_anos_lectivos()->get() as $anolectivo)
                                    <option value="{{ $anolectivo->id }}">
                                        {{ $anolectivo->ya_inicio . '-' . $anolectivo->ya_fim }}
                                    </option>
                                @endforeach
                            </select>
                  


                    </div>


                </div>
                <div class="d-flex justify-content-center col-md-12">

                    <button class=" btn-sm btn-dark pl-4 pr-4 ">Ver</button>
                </div>
            </form>
        </div>
    </div>
    @isset($matricula)


        <div class="row ">
            @php
                $meses = fha_obter_numeros_meses($inicio_termino_ano_lectivo->mes_inicio, $inicio_termino_ano_lectivo->mes_termino);
                //   $meses=fha_obter_numeros_meses('Janeiro','Dezembro');
                // dd($meses);
            @endphp
            @foreach ($meses as $numero_mes)
                <div class="col-lg-4 mb-4">
                    <div class="card">
                        <div class="card-body">
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
                                    Multa:{{ $multa }}


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
                                    
                                    <a target="_blank"
                                        href="{{ route('pagamentos.fatura', [
                                            'slug_pagamento' => $pagamento->slug,
                                        ]) }}"
                                        class="text-white btn btn-dark ">Fatura</a>
                               
                                @endif



                            </div>


                        </div>
                    </div>
                </div>
            @endforeach

        </div>

    @endisset
@endsection

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>
    <br>
    @php
        
        $ttl_v_compra = 0;
    @endphp
    <table class="table-2" style="margin-top: 30px;">

        <tr style="border:none">

            {{-- <style>
            s{
                font-size: 10px
            }
           </style> --}}
           @php
               $cabecalho=fh_cabecalho();
           @endphp
            <td style="text-align:left;font-size:25px;padding:0px">
                {{ $cabecalho->vc_escola }}
            </td>
            <td style="text-align:right;font-size:25px;padding:0px">
                FATURA 
            </td>
        </tr>



    </table>


    <table class="table-2" style="margin-top: 20px;">

        <tr style="border:none">

            <td style="text-align:left;padding:0px">
                {{  $cabecalho->vc_endereco }}

                <br>
                Telefone: {{ $cabecalho->it_telefone }}
                <br>
                NIF: {{ $cabecalho->vc_nif }}
            </td>

            <td style="text-align:right;padding:0px">
                Aluno: {{ $aluno->vc_primeiroNome }}
                {{ $aluno->vc_apelido }}
                <br>
           
                Telefone: {{ $aluno->it_telefone }}
                <br>
           
                Processo: {{ $aluno->processo }}

            </td>
        </tr>



    </table>

    <p style="margin-top: 30px;font-size:10px;"><strong>Produtos:</strong> </p>
    <table style="margin-top: 10px;">
        <thead class="">

            <tr>

                <th style=" text-align: left">DESCRIÇÃO</th>
                <th style=" text-align: left">MÊS</th>
                <th style=" text-align: left">ANO LECTIVO</th>
                <th>VALOR(AKZ)</th>
                
                
                <th>MULTA(AKZ)</th>

           


            </tr>


        </thead>
        <tbody class="">
      
                <tr>

                    <td>
                        {{$pagamento->tipo }}
                    </td>
                    <td >
                        {{$pagamento->mes }}
                    </td>
                    <td >
                        {{$pagamento->ya_inicio}}/{{$pagamento->ya_fim }}
                    </td>
                        <td style="text-align:right">
                            {{$pagamento->valor }}
                        </td>
                     
                       
                    <td style="text-align:right">
                        {{$multa= fha_calcular_valor_pagar(date('Y-' . fha_obterNumeroMes($pagamento->mes) . "-$pagamento->dias_multa"), 0, $pagamento->dias_multa, $pagamento->multa_valor) }}

                    </td>
                    
                </tr>
          
        </tbody>

    </table>
 


    <table style="margin-top: 10px" class="table-2">

        <tr style="border:none">
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td style="text-align:right">

            </td>
            <td style="text-align:right">
                Sobtoal
            </td>
            <td style="text-align:right">
                {{ $pagamento->valor }}
            </td>
        </tr>



    </table>
    <table class="table-2">

        <tr style="border:none">
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td>

            </td>
            <td style="text-align:right">

            </td>
            <td style="text-align:right">
                IVA 0%
            </td>
            <td style="text-align:right">
                0.0
            </td>
        </tr>



    </table>

    <table class="table-2" style="margin-top: 20px">

        <tr>

            {{-- <style>
            s{
                font-size: 10px
            }
           </style> --}}
            <td style="text-align:left;font-size:25px">
                TOTAL
            </td>
            <td style="text-align:right;font-size:25px">
                {{  $pagamento->valor+$multa }} AOA
            </td>
        </tr>



    </table>
    <p style="text-align: center;font-size:10px;">Dt. Pagamento:   {{ converterData($pagamento->created_at) }}
    </p>
    <p style="text-align: center;font-size:10px;">Operador:{{ Auth::User()->vc_primemiroNome }}
        {{ Auth::User()->vc_apelido }}</p>
    <p style="text-align: center;font-size:10px;">Processado por computador: {{ date('d/m/Y H:i:s ') }}</p>

</body>

</html>

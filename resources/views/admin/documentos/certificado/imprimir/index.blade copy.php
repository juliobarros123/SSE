<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Certificado</title>
    <style>
        .director {
            font-style: italic;
            font-family: 'Times New Roman', Times, serif;
            text-transform: uppercase;
            font-size: 13px;
            /* color: red */

        }

        .narracao {
            margin-left: 40px;
            margin-top: 162px;
            font-family: 'Times New Roman', Times, serif;
            font-size: 12.8px;
            text-align: justify;
            width: 92%;
            line-height: 20px;
            /* background-color: red; */
        }

        .nota {
            padding-top: 0px;

            margin-top: 0px;
            margin-bottom: 0px;
            width: 93px;
            margin-left: 420px;
            text-align: center;
            line-height: 17.5px;

        }

        .media-1 {
            padding-top: 0px;
            background-color: red;
            line-height: 17px;
            margin-bottom: 0px;
            width: 244px;
            margin-left: 420px;
            margin-top: 28.8px;
            text-align: center;
        }

        .media-apan-1 {
            background-color: yellow;
            margin-left: 10px;

        }

        .table {
            border-collapse: collapse;


            /* background-color: red; */
            margin-left: 40px;
        }



        .desciplina {

            width: 380px;
            padding-bottom: 0px;
            padding-bottom: 0px;
            padding-top: 1.7px;
            /* text-align: center; */
            font-size: 13px;
            padding-left: 6px;
        }

        .nota-valor {

            width: 93px;

            padding-bottom: 0px;
            padding-bottom: 0px;
            padding-top: 1.7px;
            text-align: center;
            font-size: 13px;
            /* background-color: red; */
        }

        .nota-extenso {
            font-size: 13px;
            width: 80px;
            padding-bottom: 0px;
            padding-top: 1.7px;
            padding-left: 12px;
        }

        .valores {
            font-size: 13px;
            width: 70px;
            padding-bottom: 0px;
            padding-top: 1.7px;
            padding-left: 7.5px;
        }

        .data {
            margin-top: 80px;
            margin-left: 40px;
            font-size: 13px;
        }

        .sub-director-td {
            /* background-color: red; */
            width: 228px;
        }

        .director-td {
            width: 400px;
        }

        .table-2 {
            /* background-color: yellow; */
            border-collapse: collapse;
            margin-top: 68px;
            margin-left: 19px;
            /* border: 1px solid red; */
        }

        .font-sujeito {
            text-transform: uppercase;
            font-size: 13px;
            font-style: italic;
        }

        .td {

            /* text-align: left; */
            border: 1px solid black;

            color: black;
        }

        .cab-table {
            font-size: 11px;
            text-align: center;
            padding-bottom: 3px;
            padding-top: 3px;
            padding-left: 5px;
            padding-right: 5px;
            background-color: rgba(153, 204, 255,90%);
            font-weight: bold;

        }
        .table td {
    border: 1px solid black;
    
}
    </style>
</head>

<body
    style="background-image: url('images/certificado/inf/MODELO_CERTIFICADO_INFORM.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">
    <p style="color:white">jjj</p>
    @php

        $disciplinas = collect($notas['disciplinas']);
        $notas = collect($notas['notas']);
      
    @endphp
    <p class="narracao"> <strong><span class="director">CLÁUDIO ANTÓNIO DE ALMEIDA GONÇALVES </span></strong> , Director
        do Instituto de Telecomunicações – ITEL
        nº 1534, criado sob decreto executivo conjunto nº 29/85 de 29 de Abril, certifica que
        <span class="font-sujeito" style="font-weight: bold">
            {{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_ultimoaNome" }}</span>
        , {{ $aluno->vc_genero == 'Masculino' || $aluno->vc_genero == 'MASCULINO' ? 'filho' : 'filha' }} de
        {{ $aluno->vc_namePai }} e de {{ $aluno->vc_nameMae }}, natural da {{ $aluno->vc_naturalidade }},
        @php
            
            $dt = date('d-m-Y', strtotime($aluno->dt_dataNascimento));
            
        @endphp
        Município de Luanda Província de {{ $aluno->vc_provincia }} ,
        {{ $aluno->vc_genero == 'Masculino' || $aluno->vc_genero == 'MASCULINO' ? 'nascido' : 'nascida' }} aos
        {{ $dt }}, portadora do Bilhete de Identidade nº
        {{ $aluno->vc_bi }}, passado pelo Arquivo de Identificação de Luanda aos 08/07/2016, com processo nº
        {{ $aluno->id }}, concluiu no ano lectivo 2021/2022, o Curso do IIº CICLO DO ENSINO SECUNDÁRIO TÉCNICO,
        na especialidade de {{ $aluno->vc_nomeCurso }}, conforme o disposto na alínea f) do artigo 109º da LBSEE 17/16,
        de
        7 de Outubro, com Média Final de {{ $media }} valores obtido nas seguintes classificações por
        disciplinas:
    </p>

    {{-- <p class="director"> <strong>{{$cabecalho->vc_nomeDirector}}</strong></p> --}}

    {{-- @dump($notas->) --}}
    {{-- @foreach ($disciplinas as $item)
   @dump($item)
@endforeach --}}
    {{-- @dump($notas) --}}
    {{-- @dump($notas) --}}
    {{-- @dump(  $notas); --}}
    <table class="table">
        <tr>
            <td class=" td cab-table" style="text-align:left">COMPONENTE SÓCIO-CULTURAL</td>
            <td class=" td cab-table" style="">MÉDIA FINAL</td>
            <td class=" td cab-table" colspan="2" style="">MÉDIA POR EXTENSO</td>
        </tr>
        {{-- @foreach ($ordem_disciplinas as $disciplina)
            @if ($loop->index + 1 == 4)
            <tr>
                <td class=" td cab-table" colspan="3" style="text-align:left">COMPONENTE CIENTÍFICA
                </td>
               
            </tr>
            @endif
            @if ($loop->index + 1 == 9)
            <tr>
                <td class=" td cab-table" colspan="3" style="text-align:left">COMPONENTE TÉCNICA, TECNOLÓGICA E PRÁTICA
                </td>
               
            </tr>
            @endif
            @if ($loop->index + 1 == 18)
                <tr>
                    <td class="nota-valor" style="padding-bottom: 3px;color:transparent">{{ $media }}</td>
                    <td class="nota-extenso" style="padding-bottom: 3px;color:transparent">
                        {{ ucfirst(valorPorExtenso($media, false, false)) }}</td>
                    <td class="valores" style="padding-bottom: 3px;color:transparent">Valores</td>

                </tr>
            @endif
            @foreach ($notas as $nota)
                @isset($nota[$disciplina[0]])
                    <tr>
                        <td class="desciplina td">Física</td>
                        <td class="nota-valor td">{{ $nota[$disciplina[0]][0]['cfd'] }}</td>
                        <td class="nota-extenso td">
                            {{ ucfirst(valorPorExtenso($nota[$disciplina[0]][0]['cfd'], false, false)) }}</td>
                        <td class="valores td">Valores</td>

                    </tr>
                @endisset
            @endforeach
        @endforeach --}}
        <tr>
            <td class="nota-valor td" style="padding-bottom: 1px;color:transparent"></td>
            <td class="nota-extenso td" style="padding-bottom: 1px;color:transparent"></td>
            <td class="valores td" style="padding-bottom: 1px;color:transparent"></td>
        </tr>
        <tr>

            <td class="nota-valor td">{{ round((4 * $media + $ttl_TM) / 6, 0, PHP_ROUND_HALF_UP) }}</td>
            <td class="nota-extenso td">Catorze</td>
            <td class="valores td">Valores</td>

        </tr>
        {{-- <tr>
            <td class="nota-valor" >10</td>
            <td class="nota-extenso">Dezanove</td>
            <td class="valores">Valores</td>
        </tr> --}}
    </table>
    {{-- <h5 class="data">INSTITUTO DE TELECOMUNICAÇÕES - ITEL, EM LUANDA, AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))); ?>.-</h5 style="">
    <table class="table-2" style="">
        <tr>
            <td class="sub-director-td">
                <h5 class="font-sujeito">{{ $cabecalho->vc_nomeSubdirectorPedagogico }}</h5>
            </td>
            <td class="director-td">
                <h5 class="font-sujeito">{{ $cabecalho->vc_nomeDirector }}</h5>
            </td>
        </tr>
    </table> --}}
</body>

</html>

<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">

    <title>Certificado</title>
    <style>
        .logotipo {
            position: absolute;
            margin-top: -100px;
            margin-right: -110px;
            float: left;
            z-index: 1;
        }

        /* .tb{
                position: absolute;
                margin-top: 10px;
                margin-right: -110px;
                float: left;
                z-index: 1;
            } */


        .logo {
            width: 500px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            left: 50px;
            margin-left: 30px;
            margin-top: -170px;
            font-size: 100px;
        }

        .text-center {
            text-align: center;
        }

        .tamanho-font {
            font-size: 20px;
        }

        .director {
            font-style: italic;
            font-family: 'Times New Roman', Times, serif;
            text-transform: uppercase;
            font-size: 13px;
            /* color: red */

        }

        .narracao {
            margin-left: 30px;

            font-family: 'Times New Roman', Times, serif;
            font-size: 12.8px;
            text-align: justify;
            width: 92%;
            line-height: 19px;
            /* background-color: red; */
        }

        .narracao-2 {
            margin-left: 30px;
            /* margin-top: 162px; */
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
            width: 96%;
            /* background-color: red; */
            margin-left: 30px;
        }


        .disciplina {

            width: 270px;
            padding-bottom: 0px;
            padding-bottom: 0px;
            padding-top: 1.7px;
            /* text-align: center; */
            font-size: 11px;
            padding-left: 6px;
        }

        .nota-valor {

            /* width: 70px; */

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
            /* margin-top: 80px; */
            text-transform: uppercase;
            margin-left: 30px;
            font-size: 12px;
            text-align: center;
        }

        .sub-director-td {

            /* background-color: red; */
            width: 310px;
            text-align: center;

        }

        .director-td {
            /* background-color: yellow; */
            width: 310px;
            text-align: center;

        }

        .table-2 {
            /* background-color: yellow; */
            border-collapse: collapse;
            margin-top: 10px;
            margin-left: 30px;
            /* border: 1px solid red; */
        }

        .table-3 {
            /* background-color: yellow; */
            border-collapse: collapse;
            margin-top: 5px;
            margin-left: 30px;
            /* margin-left: 66px; */
            /* border: 1px solid red; */
        }

        .font-sujeito {
            text-transform: uppercase;
            font-size: 13px;
            font-style: italic;
        }

        /* .td {

            text-align: left;
            border: 1px solid black;

            color: black;
        } */

        .cab-table {
            font-size: 10px;
            text-align: center;
            padding-bottom: 3px;
            padding-top: 3px;
            padding-left: 5px;
            padding-right: 5px;

            font-weight: bold;
            text-transform: uppercase
        }

        .clsfc {
            font-size: 11px;

            padding-bottom: 3px;
            padding-top: 3px;

            padding-right: 5px;

            font-weight: bold;

        }

        /* .table td {
            border: 1px solid black;

        } */

        .ident-1 {

            font-size: 13px;
            /* font-style: italic; */
            font-weight: bold;
            /* background-color: yellow; */
            /* padding-left: 40px */
            /* margin-left: 1000px; */
        }

        .ident-2 {
            font-size: 13px;
            /* font-style: italic; */
            font-weight: bold;
            /* background-color: yellow; */
            /* padding-left: 60px */
        }



        .cab-cert {
            /* background-color: red; */
            /* padding-left: 20px; */
            text-transform: uppercase;
            font-size: 11.5px;
            font-weight: bold;

            text-align: center;
            /* padding-top: 1600px; */
            /* height: 100px; */
        }

        .acronimo {
            text-transform: uppercase;
        }

        .td-boder {
            border: 1px solid black;

        }

        .td-boder-bottom {
            border-bottom: 1px solid black;

        }

        .td-boder-top {
            border-top: 1px solid black;

        }

        .td-boder-right {
            border-right: 1px solid black;

        }

        .td {

            /* text-align: left; */
            /* border: 1px solid black; */

            color: black;
        }

        .td-none-border-left {

            text-align: left;
            border: 0px solid black !important;
            /* border-left: 0px solid black; */
            color: black;
        }

        .visto {
            width: 200px;
            height: 100px;
            /* background-color: red; */
            /* position: absolute;
            left: 50px;
            margin-left: 300px; */
            position: absolute;
            /* background: red; */
            margin-left: 96px;
            top: 80px;
            font-size: 20px;
        }
    </style>
</head>

<body
    style="background-image: url('<?php echo ; ?>images/certificado/magisterio/certificado.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">


    <p class="cab-cert">

        <br>
        <br>
        <br>
        <br>

        <br>
        <?php echo $cabecalho->vc_republica; ?>
        <br>
        <?php echo $cabecalho->vc_ministerio; ?>
        <br>

        <?php echo 'ENSINO SECUNDÁRIO PEDAGÓGICO'; ?>

    </p>
    <h3 class="text-center">CERTIFICADO</h3>

    @php
        
        $disciplinas = collect($notas['disciplinas']);
        $notas = collect($notas['notas']);
        $valor = round((4 * $media + $ttl_TM) / 6, 0, PHP_ROUND_HALF_UP);
        
    @endphp



    <p class="narracao"> a) <strong><span class="director">{{ $cabecalho->vc_nomeDirector }}</span></strong>, Director(a)
        do {{ $cabecalho->vc_escola }}, criado sob Decreto Executivo
        n.º___/_____de_______, certifica que <span class="font-sujeito" style="font-weight: bold">
            {{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_ultimoaNome" }}</span>,filho(a) de
        {{ $aluno->vc_namePai }} e de {{ $aluno->vc_nameMae }}, nascido aos
        {{ sub_traco_barra($aluno->dt_dataNascimento) }} natural de
        {{ $aluno->vc_naturalidade }}, Município de(a) {{ $aluno->vc_municipio }} Província de(a)
        {{ $aluno->vc_provincia }}, portador do B.I./Passaporte n.º
        {{ $aluno->vc_bi }}, passado pelo arquivo de identificação de {{ $aluno->vc_provincia }} aos
        {{ sub_traco_barra($aluno->dt_emissao) }}, concluiu no ano
        lectivo {{ sub_traco_barra_string($matricula->vc_anoLectivo) }} o curso do II CICLO DO ENSINO SECUNDÁRIO
        TÉCNICO, na especialidade de
        {{ $aluno->vc_nomeCurso }}, conforme o disposto na alínea f) do artigo 109.º da LBSEE 17/16, de 7 de
        Outubro, conjugada com a Lei nº 32/20 de 12 de Agosto, com a Média Final de {{ $media }} valores obtida
        nas seguintes
        classificações por disciplina:
    </p>
    @php
        
        // dd(componentes_disciplinas()->get());
    @endphp
    <table class="table">
        @php
            $cont = 1;
            $medias_anuas_disciplina = [];
        @endphp

        <tr>
            <td class=" td cab-table td-boder" colspan="1" style="text-align:left">Disciplina
            </td>
            <td class=" td cab-table td-boder" style="">10ª Classe</td>
            <td class=" td cab-table td-boder" style="">11ª Classe</td>
            <td class=" td cab-table td-boder" style="">12ª Classe</td>
            <td class=" td cab-table td-boder" style="">13ª Classe</td>
            <td class=" td cab-table td-boder" style="">MÉDIA FINAL</td>
            <td class=" td cab-table td-boder" colspan="2" style="">MÉDIA POR EXTENSO</td>

        </tr>
        @foreach (componentes() as $componente)
            <tr>

                <td class=" td cab-table td-boder" style="text-align:left">
                    {{ $componente->vc_componente }}
                </td>
                <td class="nota-valor td td-boder"></td>
                <td class="nota-valor td td-boder"></td>
                <td class="nota-valor td td-boder"></td>
                <td class="nota-valor td td-boder"></td>
                <td class="nota-valor td td-boder">


                </td>
                <td class="nota-extenso td td-boder-bottom td-boder-top ">

                </td>
                <td class="valores td td-boder-bottom td-boder-top td-boder-right"></td>

            </tr>

            @foreach (componentes_disciplinas()->where('id_componente', $componente->id)->get() as $disciplina)
                @foreach ($notas as $nota)
                    @isset($nota[$disciplina->vc_acronimo])
                        @php
                            $medias_anuas_disciplina = medias_anuas_disciplina($aluno->id, $disciplina->vc_acronimo, [10, 11, 12, 13]);
                            
                        @endphp

                        <tr>

                            <td class="disciplina td td-boder">{{ $disciplina->vc_nome }}</td>
                            <td class="nota-valor td td-boder">
                                {{ menor_zero($medias_anuas_disciplina[0]) ? $medias_anuas_disciplina[0] : '' }}</td>
                            <td class="nota-valor td td-boder">
                                {{ menor_zero($medias_anuas_disciplina[1]) ? $medias_anuas_disciplina[1] : '' }}</td>
                            <td class="nota-valor td td-boder">
                                {{ menor_zero($medias_anuas_disciplina[2]) ? $medias_anuas_disciplina[2] : '' }}</td>
                            <td class="nota-valor td td-boder">
                                {{ menor_zero($medias_anuas_disciplina[3]) ? $medias_anuas_disciplina[3] : '' }}</td>
                            <td class="nota-valor td td-boder">
                                @php
                                    $cfd = intval(isset($nota[$disciplina->vc_acronimo][0]['rec']) ? $nota[$disciplina->vc_acronimo][0]['rec'] : (isset($nota[$disciplina->vc_acronimo][0]['cfd']) ? $nota[$disciplina->vc_acronimo][0]['cfd'] : 0));
                                @endphp

                                {{ intval($cfd) }}
                                {{-- {{ intval(isset($nota[$disciplina->vc_acronimo][0]['rec']) ? $nota[$disciplina->vc_acronimo][0]['rec'] : (isset($nota[$disciplina->vc_acronimo][0]['cfd'])?$nota[$disciplina->vc_acronimo][0]['cfd']:0)) }} --}}
                            </td>
                            <td class="nota-extenso td td-boder-bottom td-boder-top ">
                                {{ ucfirst(valorPorExtenso(intval(intval($cfd)))) }}
                            </td>
                            <td class="valores td td-boder-bottom td-boder-top td-boder-right">Valores</td>

                        </tr>
                    @endisset
                @endforeach

                {{-- @if ($disciplina->vc_acronimo == 'E.C.S.')
                    <tr>
                        <td class="disciplina td td-boder">Média do Plano Curricular (PC) </td>
                        <td class="nota-valor td td-boder">{{ $media }} </td>
                        <td class="nota-extenso td td-boder-bottom">
                            {{ ucfirst(valorPorExtenso($media, false, false)) }}</td>
                        <td class="valores td  td-boder-bottom td-boder-right">Valores</td>

                    </tr>
                @endif --}}
            @endforeach
            @php
                $cont = 0;
            @endphp
        @endforeach

        {{-- <tr>

            <td class="disciplina td td-boder "><strong>Prova
                    de Aptidão Profissional
                </strong></td>
            <td class="nota-valor td td-boder">
                @foreach (medias_anual($aluno->id, $matricula->it_idClasse) as $item)
                    @if ($item['1'] == 'PROJ. TECN.')
                        {{ $item['2'] }}
                    @break
                @endif
            @endforeach
        </td>
        <td class="nota-extenso td td-boder-bottom">
            {{ ucfirst(valorPorExtenso(0, false, false)) }}
        </td>
        <td class="valores td td-boder-bottom td-boder-right">Valores</td>

    </tr> --}}
        {{-- <tr>

        <td class="disciplina td td-boder "><strong>Nota de Estagio Curricular
            </strong></td>
        <td class="nota-valor td td-boder">

            0
        </td>
        <td class="nota-extenso td td-boder-bottom">
            {{ ucfirst(valorPorExtenso(0, false, false)) }}
        </td>
        <td class="valores td td-boder-bottom td-boder-right">Valores</td>

    </tr> --}}


        {{-- <tr>
            <td class="nota-valor" >10</td>
            <td class="nota-extenso">Dezanove</td>
            <td class="valores">Valores</td>
        </tr> --}}
    </table>

    <p class="narracao-2">Para efeitos legais lhe é passado o presente Certificado, que consta no livro de registo nº
        ____/20___, folha_______ assinado por mim e autenticado com carimbo a óleo/selo branco em uso neste
        estabelecimento de ensino. </p>
    <h5 class="data"> {{ $cabecalho->vc_escola }}, AOS
        {{ hoje_extenso() }}</h5>
    <table class="table-2" style="">
        <tr>
            <td class="sub-director-td ident-1">

                Conferido por: _____________
                <br>
                <br>
                Sub Director Pedagógico

            </td>
            <td class="director-td ident-2">
                <br>
                <br>

                O Director Geral

            </td>
        </tr>
    </table>
    <table class="table-3" style="">
        <tr>
            <td class="sub-director-td">

                <h5 class="font-sujeito">

                    {{ $cabecalho->vc_nomeSubdirectorPedagogico }}</h5>
            </td>
            <td class="director-td">
                <h5 class="font-sujeito">{{ $cabecalho->vc_nomeDirector }}</h5>
            </td>
        </tr>
    </table>


</body>

</html>

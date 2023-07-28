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

        .bg-cab-table {}

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

<body style="background-image: url('images/certificado/magisterio/certificado.png');background-position: top left;
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

        <?php echo 'IIº CICLO DO ENSINO SECUNDÁRIO GERAL'; ?>

    </p>

    @include('admin.documentos.certificado.imprimir.fragments.visto.index')

    <h3 class="text-center">CERTIFICADO</h3>

    @php
    $medias_acumulada_linha = [];
    $medias_acumulada_coluna=[];
    @endphp
    @foreach ($componentes as $componente)

    @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente',
    $componente->id)->select('disciplinas.*')->get() as $disciplina)
    @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
        @php
        $matricula = fh_matriculas()
        ->where('alunnos.processo', $aluno->processo)
        ->where('classes.vc_classe', $i)
        ->get();
        $matricula = $matricula->sortDesc()->first();

        if ($matricula) {

        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'],
        $matricula->it_idAnoLectivo);
        } else {
        $ca = 0;
        }
        array_push($medias_acumulada_linha, $ca);
        @endphp

        @endfor

        @php
        $media = fh_arredondar(media($medias_acumulada_linha));
        array_push($medias_acumulada_coluna, $media);

        @endphp


        @endforeach
        @endforeach

        @php
        $medias_acumulada_coluna = fh_arredondar(media($medias_acumulada_coluna));
        @endphp

        <p class="narracao"> a) <strong><span class="director">{{ $cabecalho->vc_nomeDirector }}</span></strong>,
            Director(a)
            do {{ $cabecalho->vc_escola }}, criado sob Decreto Executivo
            n.º___/_____de_______, certifica que <span class="font-sujeito" style="font-weight: bold">
                {{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_apelido" }}</span>,filho(a) de
            {{ $aluno->vc_nomePai }} e de {{ $aluno->vc_nomeMae }}, nascido aos
            {{ sub_traco_barra($aluno->dt_dataNascimento) }} natural de
            {{ $aluno->vc_naturalidade }}, Município de(a) {{ $aluno->vc_municipio }} Província de(a)
            {{ $aluno->vc_provincia }}, portador do B.I./Passaporte n.º
            {{ $aluno->vc_bi }}, passado pelo arquivo de identificação de {{ $aluno->vc_provincia }} aos
            {{ sub_traco_barra($aluno->dt_emissao) }}, concluiu no ano
            lectivo {{ $aluno->ya_inicio . '/' . $aluno->ya_fim }} o curso do II CICLO DO ENSINO SECUNDÁRIO
            TÉCNICO, na especialidade de
            {{ $aluno->vc_nomeCurso }}, conforme o disposto na alínea f) do artigo 109.º da LBSEE 17/16, de 7 de
            Outubro, conjugada com a Lei nº 32/20 de 12 de Agosto, com a Média Final de {{ $medias_acumulada_coluna}}
            valores obtida
            nas seguintes
            classificações por disciplina:
        </p>
        @php
        $medias_acumulada_linha = [];
        $medias_acumulada_coluna=[];
        @endphp
        <table class="table">
            @php
            $cont = 1;
            $medias_anuas_disciplina = [];
            @endphp

            <tr>
                <td class=" td cab-table bg-cab-table td-boder" colspan="1" style="text-align:left">DISCIPLINA
                </td>
                @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                    <td class=" td cab-table bg-cab-table td-boder" style="">{{ $i }}ª Classe</td>
                    @endfor
                    <td class=" td cab-table bg-cab-table td-boder" style="">MÉDIA FINAL</td>
                    <td class=" td cab-table bg-cab-table td-boder" colspan="2" style="">MÉDIA POR EXTENSO</td>
            </tr>

            @foreach ($componentes as $componente)
            @php
            // dd($componente);
            @endphp
            @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente',
            $componente->id)->select('disciplinas.*')->get() as $disciplina)
            <tr>

                <td class="disciplina upper-case td td-boder">{{ $disciplina->vc_nome }}</td>

                @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                    @php
                    $matricula = fh_matriculas()
                    ->where('alunnos.processo', $aluno->processo)
                    ->where('classes.vc_classe', $i)
                    ->get();
                    $matricula = $matricula->sortDesc()->first();

                    if ($matricula) {
                    // dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->it_idAnoLectivo);
                    $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'],
                    $matricula->it_idAnoLectivo);
                    } else {
                    $ca = 0;
                    }
                    array_push($medias_acumulada_linha, $ca);
                    @endphp
                    <td class="nota-valor td td-boder">
                        {{ menor_zero($ca) ? $ca : '' }}</td>
                    @endfor

                    @php
                    $media = fh_arredondar(media($medias_acumulada_linha));
                    array_push($medias_acumulada_coluna, $media);

                    @endphp

                    <td class="nota-valor td td-boder">

                        {{ intval($media) }}

                    </td>
                    <td class="nota-extenso td td-boder-bottom td-boder-top ">
                        {{ ucfirst(valorPorExtenso(intval(intval($media)))) }}
                    </td>
                    <td class="valores td td-boder-bottom td-boder-top td-boder-right">Valores</td>

            </tr>

            @php
            $cont = 0;
            @endphp
            @php
            $media=0;
            $medias_acumulada_linha=[];
            @endphp
            @endforeach
            @endforeach
        </table>

        <p class="narracao-2">Para efeitos legais lhe é passado o presente Certificado, que consta no livro de registo
            nº
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
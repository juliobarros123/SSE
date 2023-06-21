<!DOCTYPE html>
<html>

<head>
    <title> Lista de Alunos Matriculados</title>
    <style>
        <?php
        echo $css;
        ?>
    </style>
</head>

<body
    style="background-image: url('images/certificado/nona/fundo.png');background-position: top left;
background-repeat: no-repeat;
background-image-resize: 2;
background-image-resolution: from-image;">
    @include('layouts._includes.fragments.certificado.header')
    <div class="title">
        CERTIFICADO
    </div>
    @php
        $medias_acumulada_linha = [];
        $medias_acumulada_coluna = [];
    @endphp
    @foreach ($componentes as $componente)
        @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente', $componente->id)->select('disciplinas.*')->get() as $disciplina)
            @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                @php
                    $matricula = fh_matriculas()
                        ->where('alunnos.processo', $aluno->processo)
                        ->where('classes.vc_classe', $i)
                        ->get();
                    $matricula = $matricula->sortDesc()->first();
                    
                    if ($matricula) {
                        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->id_ano_lectivo);
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
    <div class="bib">
        <div>a) <strong>{{ $cabecalho->vc_nomeDirector }}</strong>, Diretor(a) do {{ $cabecalho->vc_escola }}, criada,
            sob Decreto Executivo nº 40/06 de 15 de Maio.</div>


        <div class="bib-part">
            Certifica que {{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_apelido" }}, filho(a) de
            {{ $aluno->vc_nomePai }} e de
            {{ $aluno->vc_nomeMae }}, nascida(o) aos {{ dataPorExtenso(sub_traco_barra($aluno->dt_dataNascimento)) }},
            natural de(o) {{ $aluno->vc_naturalidade }}, Município de
            {{ $aluno->vc_municipio }}, Província de {{ $aluno->vc_provincia }}, portadora(o) do B.I nº
            {{ $aluno->vc_bi }}, passado(a) pela Direção Nacional de Identificação, aos
            {{ dataPorExtenso(sub_traco_barra($aluno->dt_emissao)) }}.

        </div>

        <div class="bib-part">
            Concluiu no ano lectivo de {{ $aluno->ya_inicio . '/' . $aluno->ya_fim }}, o 1 CICLO DO ENSINO SECUNDÁRIO
            GERAL,
            conforme o disposto na alínea c) do artigo 109º da LBSEE nº 17/16 de 07 de Outubro, com a Média
            Final de {{ $medias_acumulada_coluna }} Valores, obtida nas seguintes classificações por ciclos de
            aprendizagem:
        </div>
    </div>
    <br>



    <table class="table">
        @php
            $medias_acumulada_linha = [];
            $medias_acumulada_coluna = [];
        @endphp
        @php
            $cont = 1;
            $medias_anuas_disciplina = [];
        @endphp

        <tr>
            <th class="th-cab-notas" colspan="1" style="text-align: center">DISCIPLINA
            </th>
            @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                <th class="th-cab-notas" style="text-align: center">{{ $i }}ª Classe</th>
            @endfor
            <th class="th-cab-notas" style="text-align: center">MÉDIA FINAL</th>
            <th class="th-cab-notas" colspan="2" style="text-align: center">MÉDIA POR EXTENSO</th>
        </tr>

        @foreach ($componentes as $componente)
            @php
                // dd($componente);
            @endphp
            @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente', $componente->id)->select('disciplinas.*')->get() as $disciplina)
                <tr>

                    <td class="desciplina td td-boder">{{ $disciplina->vc_nome }}</td>

                    @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                        @php
                            $matricula = fh_matriculas()
                                ->where('alunnos.processo', $aluno->processo)
                                ->where('classes.vc_classe', $i)
                                ->get();
                            $matricula = $matricula->sortDesc()->first();
                            
                            if ($matricula) {
                                // dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->id_ano_lectivo);
                                $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->id_ano_lectivo);
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
                    $media = 0;
                    $medias_acumulada_linha = [];
                @endphp
            @endforeach
        @endforeach
    </table>
    <div class="lib">
        <div class="bib-part">
            Para efeitos legais lhe é passado o presente Certificado, que consta no livro de registo
            nº
            ____/20___, folha_______ assinado por mim e autenticado com carimbo a óleo/selo branco em uso neste
            estabelecimento de ensino. </div>
    </div>
    <div class="lib">
        <div class="bib-part" style="text-align: center"> <strong>{{ $cabecalho->vc_escola }}, aos
                {{ dataPorExtenso(date('Y-m-d')) }}</strong></div>
    </div>
    @section('entidadade1', 'Conferido por')

    @section('entidadade1-valor', $cabecalho->vc_nomeSubdirectorPedagogico)

    @section('entidadade2', ' O Director Geral')
    @section('entidadade2-valor', $cabecalho->vc_nomeDirector)
    @include('layouts._includes.fragments.lista.footer.visto-2')



</body>

</html>
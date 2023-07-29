<!DOCTYPE html>
<html>

<head>
    <title> Declaração {{ $aluno->processo }}</title>
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
    @include('layouts._includes.fragments.declaracao.header')
    <div class="title">
        DECLARAÇÃO/ COM NOTAS Nº {{$numero}}
    </div>
    @php
        $medias_acumulada_linha = [];
        $medias_acumulada_coluna = [];
    @endphp
    @foreach ($componentes as $componente)
        @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente', $componente->id)->select('disciplinas.*')->get() as $disciplina)
            @php
                $medias_acumulada_linha = [];
            @endphp
            @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                @php
                    $classe = fh_classes()
                        ->where('classes.vc_classe', $i)
                        ->first();
                    $matricula = fh_matriculas()
                        ->where('alunnos.processo', $aluno->processo)
                        ->where('classes.vc_classe', $i)
                        ->get();
                    $matricula = $matricula->sortDesc()->first();
                    
                    if ($matricula) {
                        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->it_idAnoLectivo);
                    } else {
                        $ca = 0;
                    }
                    if (fhap_disciplinas_cursos_classes($disciplina->id, $aluno->id_curso, $classe->id)) {
                        array_push($medias_acumulada_linha, $ca);
                    }
                @endphp
            @endfor

            @php
                if (count($medias_acumulada_linha)) {
                    $media = fh_arredondar(media($medias_acumulada_linha));
                    array_push($medias_acumulada_coluna, $media);
                }
                
            @endphp
        @endforeach
    @endforeach

    @php
        $medias_acumulada_coluna = fh_arredondar(media($medias_acumulada_coluna));
    @endphp
    @php
        /* dd($cabecalho); */
    @endphp
    <div class="bib">
        <div>a) <strong>{{ $cabecalho->vc_nomeDirector }}</strong>, Diretor(a) do {{ $cabecalho->vc_escola }} Nº
            {{ $cabecalho->vc_numero_escola }}, criada,
            sob Decreto Executivo nº {{ $info_declaracao->decreto }}.</div>


        <div class="bib-part">
            Declara que <strong>{{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_apelido" }}</strong>, filho(a) de
            {{ $aluno->vc_nomePai }} e de
            {{ $aluno->vc_nomeMae }}, nascida(o) aos {{ dataPorExtenso(sub_traco_barra($aluno->dt_dataNascimento)) }},
            natural de(o) {{ $aluno->vc_naturalidade }}, Município de
            {{ $aluno->vc_municipio }}, Província de {{ $aluno->vc_provincia }}, portadora(o) do B.I./Passaporte nº
            {{ $aluno->vc_bi }}, passado(a) pela Direção Nacional de Identificação, aos
            {{ dataPorExtenso(sub_traco_barra($aluno->dt_emissao)) }}, com processo individual nº <strong>{{$aluno->processo}}</strong>.

        </div>

        <div class="bib-part">
            Concluiu no ano lectivo de {{ $aluno->ya_inicio . '/' . $aluno->ya_fim }}, a
            <strong>{{ $classe_final->vc_classe }}ª Classe</strong> 
            ,
            conforme o disposto na alínea {{ $info_declaracao->alinea }}) do artigo {{ $info_declaracao->artigo }}º
            da LBSEE nº {{ $info_declaracao->LBSEE }}, com a Média
            Final de {{ $medias_acumulada_coluna }} Valores, obtida nas seguintes classificações por disciplina:
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
                <th class="th-cab-notas" style="text-align: center">{{ $i }}ª CLASSE</th>
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

                    <td class="disciplinatd td-boder"> <strong>{{ $disciplina->vc_nome }}</strong></td>

                    @for ($i = $classe_inicial->vc_classe; $i <= $classe_final->vc_classe; $i++)
                        @php
                            $classe = fh_classes()
                                ->where('classes.vc_classe', $i)
                                ->first();
                            $matricula = fh_matriculas()
                                ->where('alunnos.processo', $aluno->processo)
                                ->where('classes.vc_classe', $i)
                                ->get();
                            $matricula = $matricula->sortDesc()->first();
                            
                            if ($matricula) {
                                // dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->it_idAnoLectivo);
                                $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->it_idAnoLectivo);
                            } else {
                                $ca = 0;
                            }
                            if (fhap_disciplinas_cursos_classes($disciplina->id, $aluno->id_curso, $classe->id)) {
                                array_push($medias_acumulada_linha, $ca);
                            } else {
                                $ca = -1;
                            }
                            /* array_push($medias_acumulada_linha, $ca); */
                        @endphp
                        <td class="nota-valor" style="text-align: center">
                            {{ menor_zero($ca) ? $ca : '-------' }}</td>
                        @php
                            $ca = 0;
                        @endphp
                    @endfor

                    @php
                        if (count($medias_acumulada_linha)) {
                            $media = fh_arredondar(media($medias_acumulada_linha));
                            array_push($medias_acumulada_coluna, $media);
                        } else {
                            $media = -1;
                        }
                        
                    @endphp

                    <td class="nota-valor" style="text-align:center">


                        {{ menor_zero($media) ? $media : '-------' }}

                    </td>
                    @php
                        if ($media <= -1) {
                            $media = 0;
                        }
                    @endphp
                                        <td style="text-align:center; " colspan="2">
                        {{ ucfirst(valorPorExtenso(intval(intval($media)))) }} Valores
                    </td>

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
            Para efeitos legais lhe é passado a presente DECLARAÇÃO, assinado por mim e autenticado com carimbo a óleo/selo
            branco em uso neste
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

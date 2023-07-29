<!DOCTYPE html>
<html>

<head>
    <title> Certificado {{ $aluno->processo }}</title>
    <style>
        <?php
        echo $css;
        ?> .disciplina {
            width: 350px;
        }
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
            @php
                $medias_acumulada_linha = [];
            @endphp
            @for ($i = $classe_final->vc_classe; $i <= $classe_final->vc_classe; $i++)
                @php
                    $classe = fh_classes()
                        ->where('classes.vc_classe', $i)
                        ->first();
                    $matricula = fh_matriculas()
                        ->where('alunnos.processo', $aluno->processo)
                        ->where('classes.vc_classe', '<=', $i)
                        ->get();
                    
                    $matricula = $matricula->sortDesc()->first();
                    // dd(   $matricula);
                    if ($matricula) {
                        $ca = fha_ca($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $classe_final->id);
                    } else {
                        $ca = 0;
                    }
                    // dd( $ca,"l");
                    // if (fhap_disciplinas_cursos_classes($disciplina->id, $aluno->id_curso, $classe->id)) {
                    //     // dd("ol");
                    array_push($medias_acumulada_linha, $ca);
                    // }
                    // dd($medias_acumulada_linha);
                @endphp
            @endfor

            @php
                // dd($medias_acumulada_linha);
                if (count($medias_acumulada_linha)) {
                    $media = fh_arredondar(media($medias_acumulada_linha));
                    array_push($medias_acumulada_coluna, $media);
                }
                // dd(  $media);
            @endphp
        @endforeach
    @endforeach

    @php
        // dd($medias_acumulada_coluna);
        $medias_acumulada_coluna = fh_arredondar(media($medias_acumulada_coluna));
        $ec = fha_nota_pap($aluno->processo, 'EC');
        $pc = $medias_acumulada_coluna;
        $pap = fha_nota_pap($aluno->processo, 'PAP');
        $cfc = fh_arredondar((4 * $pc + $pap + $ec) / 6);
    @endphp
    @php
        /* dd($cabecalho); */
    @endphp
    <div class="bib">
        <div>a) <strong>{{ $cabecalho->vc_nomeDirector }}</strong>, Diretor(a) do {{ $cabecalho->vc_escola }} Nº
            {{ $cabecalho->vc_numero_escola }}, criada,
            sob Decreto Executivo nº {{ $info_certificado->decreto }},
            certifica que <strong>{{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_apelido" }}</strong>,
            filho(a) de
            {{ $aluno->vc_nomePai }} e de
            {{ $aluno->vc_nomeMae }}, nascida(o) aos {{ dataPorExtenso(sub_traco_barra($aluno->dt_dataNascimento)) }},
            natural de(o) {{ $aluno->vc_naturalidade }}, Município de
            {{ $aluno->vc_municipio }}, Província de {{ $aluno->vc_provincia }}, portadora(o) do B.I./Passaporte nº
            {{ $aluno->vc_bi }}, passado(a) pela Direção Nacional de Identificação, aos
            {{ dataPorExtenso(sub_traco_barra($aluno->dt_emissao)) }}, com processo individual nº
            <strong>{{ $aluno->processo }}</strong>, concluiu no ano lectivo de
            {{ $aluno->ya_inicio . '/' . $aluno->ya_fim }}, o curso do
            {{ $info_certificado->ensino }}
            , na especialidade de <strong>{{ $aluno->vc_nomeCurso }} </strong>
            conforme o disposto na alínea {{ $info_certificado->alinea }}) do artigo {{ $info_certificado->artigo }}º
            da LBSEE nº {{ $info_certificado->LBSEE }}, com a Média
            Final de {{ $cfc }} Valores, obtida nas seguintes classificações por disciplina:
        </div>
    </div>
    <br>



    <table class="table">
        @php
            $pc = $medias_acumulada_coluna;
            $medias_acumulada_linha = [];
            $medias_acumulada_coluna = [];
        @endphp
        @php
            $cont = 1;
            $medias_anuas_disciplina = [];
        @endphp


        @foreach ($componentes as $componente)
            <tr>
                @if ($loop->index == 0)
                    <td class="disciplina upper-case td td-boder"> <strong>{{ $componente->vc_componente }}</strong></td>

                    <th class="th-cab-notas" style="text-align: center">MÉDIA FINAL</th>
                    <th class="th-cab-notas" colspan="2" style="text-align: center">MÉDIA POR EXTENSO</th>
                @else
                    <td class="disciplina upper-case td td-boder" colspan="4">
                        <strong>{{ $componente->vc_componente }}</strong></td>
                @endif
            </tr>
            @foreach (fh_componentes_disciplinas()->where('componente_disciplinas.id_componente', $componente->id)->select('disciplinas.*')->get() as $disciplina)
                <tr>

                    <td class="disciplina  td td-boder"> <strong>{{ $disciplina->vc_nome }}</strong></td>

                    @for ($i = $classe_final->vc_classe; $i <= $classe_final->vc_classe; $i++)
                        @php
                            $classe = fh_classes()
                                ->where('classes.vc_classe', $i)
                                ->first();
                            // dd(   $classe);
                            $matricula = fh_matriculas()
                                ->where('alunnos.processo', $aluno->processo)
                                ->where('classes.vc_classe', '<=', $i)
                                ->get();
                            $matricula = $matricula->sortBy([['vc_classe', 'desc']])->first();
                            
                            // dd( $matricula );
                            if ($matricula) {
                                // dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $matricula->it_idAnoLectivo);
                                $ca = fha_ca($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $classe->id);
                        //   dd( $ca);
                            }
                            // dd( $ca);
                            // if (fhap_disciplinas_cursos_classes($disciplina->id, $aluno->id_curso, $classe_final->id)) {
                            //     array_push($medias_acumulada_linha, $ca);
                            // } else {
                            //     $ca = -1;
                            // }
                            // dd( $ca );
                            array_push($medias_acumulada_linha, $ca);
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

        <tr>
            <td class="disciplina  td td-boder"> <strong>Classificação Final do Plano Curricular(PC)</strong> </td>
            <td class="nota-valor" style="text-align: center">
                {{ $pc }}
            </td>

            <td style="border-right: none;text-align:right; ">
                {{ ucfirst(valorPorExtenso(intval(intval($pc)))) }}
            </td>
            <td style=" border-left: none">Valores</td>


        </tr>
        <tr>
            <td class="disciplina  td td-boder"> <strong>Classificação do Estágio Curricular(EC)</strong> </td>
            <td class="nota-valor" style="text-align: center">
                {{ $ec = fha_nota_pap($aluno->processo, 'EC') }}
            </td>

            <td style="border-right: none;text-align:right; ">
                {{ ucfirst(valorPorExtenso(intval(intval($ec)))) }}
            </td>
            <td style=" border-left: none">Valores</td>


        </tr>
        <tr>
            <td class="disciplina  td td-boder"> <strong> Classificação da Prova de Aptidão Profissional(PAP)</strong>
            </td>





            <td class="nota-valor" style="text-align: center">
                {{ $pap = fha_nota_pap($aluno->processo, 'PAP') }}
            </td>

            <td style="border-right: none;text-align:right; ">
                {{ ucfirst(valorPorExtenso(intval(intval($pap)))) }}
            </td>
            <td style=" border-left: none">Valores</td>


        </tr>
        <tr>
            <td class="disciplina  td td-boder"> <strong> Classificação Final do Curso = (4*PC+PAP+EC) / 6</strong> </td>





            <td class="nota-valor" style="text-align: center">
                {{ $cfc}}
            </td>

            <td style="border-right: none;text-align:right; ">
                {{ ucfirst(valorPorExtenso(intval(intval($cfc)))) }}
            </td>
            <td style=" border-left: none">Valores</td>


        </tr>
    </table>

    <div class="lib">
        <div class="bib-part">
            Para efeitos legais lhe é passado o presente Certificado, que consta no livro de registo
            nº
            {{ $registo }}, folha {{ $folha }} assinado por mim e autenticado com carimbo a óleo/selo
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

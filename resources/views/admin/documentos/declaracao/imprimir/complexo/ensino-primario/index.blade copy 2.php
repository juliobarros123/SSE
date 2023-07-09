<!DOCTYPE html>
<html>

<head>
    <title> Certificado {{ $aluno->processo }}</title>
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
            sob Decreto Executivo nº {{ $info_certificado->decreto }}.</div>


        <div class="bib-part">
            Certifica que <strong>{{ "$aluno->vc_primeiroNome $aluno->vc_nomedoMeio $aluno->vc_apelido" }}</strong>,
            filho(a) de
            {{ $aluno->vc_nomePai }} e de
            {{ $aluno->vc_nomeMae }}, nascida(o) aos {{ dataPorExtenso(sub_traco_barra($aluno->dt_dataNascimento)) }},
            natural de(o) {{ $aluno->vc_naturalidade }}, Município de
            {{ $aluno->vc_municipio }}, Província de {{ $aluno->vc_provincia }}, portadora(o) do B.I./Passaporte nº
            {{ $aluno->vc_bi }}, passado(a) pela Direção Nacional de Identificação, aos
            {{ dataPorExtenso(sub_traco_barra($aluno->dt_emissao)) }}.

        </div>

        <div class="bib-part">
            Concluiu no ano lectivo de {{ $aluno->ya_inicio . '/' . $aluno->ya_fim }}, o
            {{ $info_certificado->ensino }}
            ,
            conforme o disposto na alínea {{ $info_certificado->alinea }}) do artigo {{ $info_certificado->artigo }}º
            da LBSEE nº {{ $info_certificado->LBSEE }}, com a Média
            Final de {{ $medias_acumulada_coluna }} Valores, obtida nas seguintes classificações por disciplina:
        </div>
    </div>
    <br>


    <table class="table">
        <thead>


            @php
                $estatistica_resultados = collect();
                $disciplinas = fha_disciplinas($turma->it_idCurso, $turma->it_idClasse);
            @endphp

            <tr>
                <th class="th" rowspan="2">Nº ORDEM</th>
                <th class="th" rowspan="2">PROCESSO</th>
                <th class="th" rowspan="2">NOME</th>

                    <th colspan="{{ $colspan }}" rowspan="1" class="th " style="text-align: center;">
                        <?php echo $disciplina->vc_acronimo; ?></th>
        
                <th rowspan="2" class="th">OBS</th>
                <th rowspan="2" class="th">MÉDIA</th>
            <tr>
                <?php foreach ($disciplinas as $disciplina) {?>
                <th colspan="1" rowspan="1" class="th">MT1</th>
                <th colspan="1" rowspan="1" class="th">MT2</th>
                <th colspan="1" rowspan="1" class="th">MT3</th>
                @if (fha_disciplina_exame($turma->it_idClasse, $disciplina->id))
                    <th>MFT</th>
                    <th>EX</th>
                @endif
                <th colspan="1" rowspan="1" class="th">CA</th>
                @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso))
                    <th colspan="1" rowspan="1" class="th">CFD</th>
                @endif
                @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso) && $turma->vc_classe > 9)
                    <th colspan="1" rowspan="1" class="th">REC</th>
                @endif

                <?php }?>
            </tr>

            </tr>

        </thead>
        <tbody>
            @foreach ($alunos as $aluno)
                <tr>
                    <td class="td text-center">
                        {{ $loop->index + 1 }}
                    </td>
                    <td class="td text-center">
                        {{ $aluno->processo }}
                    </td>
                    <td class="td">
                        {{ $aluno->vc_primeiroNome . ' ' . $aluno->vc_nomedoMeio . ' ' . $aluno->vc_apelido }}
                    </td>

                    <?php foreach ($disciplinas as $disciplina) {?>
                    @php
                    /* dd($disciplinas); */
                        $mt1 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I'], $turma->it_idAnoLectivo);
                        $mt2 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['II'], $turma->it_idAnoLectivo);
                        $mt3 = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['III'], $turma->it_idAnoLectivo);
                        /* dd($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo) */
                        $ca = fha_media_trimestral_geral($aluno->processo, $disciplina->id, ['I', 'II', 'III'], $turma->it_idAnoLectivo);
                        /* dd(  $ca ); */
                    @endphp
                    <td colspan="1" class="td " style="{{ $mt1 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt1 }}</td>
                    <td colspan="1" class="td" style="{{ $mt2 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt2 }}</td>
                    <td colspan="1" class="td" style="{{ $mt3 >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $mt3 }}</td>
                    @if (fha_disciplina_exame($turma->it_idClasse, $disciplina->id))
                        @php
                            $mft = fha_mfd_sem_exame($aluno->processo, $disciplina->id, $turma->it_idAnoLectivo);
                            
                            $exame = fha_nota_exame($aluno->processo, $disciplina->id, $turma->it_idAnoLectivo);
                        @endphp
                        <td colspan="1" class="td" style="{{ $mft >= 10 ? 'color:blue' : 'color:red' }}">
                            {{ $mft }}</td>
                        <td colspan="1" class="td" style="{{ $exame >= 10 ? 'color:blue' : 'color:red' }}">
                            {{ $exame }}</td>
                    @endif

                    <td colspan="1" class="td" style="{{ $ca >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $ca }}</td>


             
                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso))
                        @php
                            $cfd = fha_cfd_ext($aluno->processo, $disciplina->id,$turma->it_idClasse);
                        @endphp

                        <td colspan="1" class="td" style="{{ $cfd >= 10 ? 'color:blue' : 'color:red' }}">
                            {{ $cfd }}</td>
                    @endif

                    @if (fha_disciplina_terminal($disciplina->id, $turma->it_idClasse, $turma->it_idCurso) && $turma->vc_classe > 9)
                        @php
                            $rec = fh_nota_recurso($aluno->processo, $disciplina->id);
                        @endphp

                        <td colspan="1" class="td" style="{{ $rec >= 10 ? 'color:blue' : 'color:red' }}">
                            {{ $rec }}</td>
                    @endif
                    <?php }?>
                    @php
                        $media = fhap_media_geral($aluno->processo, $turma->it_idClasse, $turma->it_idAnoLectivo);
                    @endphp
                    @php
                        
                        $color = 'red';
                        $resultados = fhap_aluno_resultato_pauta($aluno->processo, $turma->it_idCurso, $turma->it_idClasse, $turma->it_idAnoLectivo);
                        
                        if ($resultados[0] == 'TRANSITA' || $resultados[0] == 'TRANSITA/DEFICIÊNCIA') {
                            $color = 'blue';
                        }
                        $r = ['processo' => $aluno->id, 'genero' => $aluno->vc_genero, 'resultado' => $resultados[0]];
                        $estatistica_resultados->push($r);
                        
                    @endphp
                    <td colspan="1" class="td " style="color:{{ $color }}">

                        {{ $resultados[0] }}</td>


                    <td colspan="1" class="td" style="{{ $media >= 10 ? 'color:blue' : 'color:red' }}">
                        {{ $media }}</td>
                </tr>
            @endforeach



        </tbody>

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

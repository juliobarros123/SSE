<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Candidatura</title>
    <style>
        <?php echo $bootstrap;
        echo $style; ?>
        .table1,
        .tr1,
        .td1,
        .th1 {
            border: none;
        }
    </style>
</head>

<body>
    <div class="text-center">
        <p>
           <img src="<?php echo __full_path()?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
            <br>
            <?php echo $cabecalho->vc_republica; ?>
            <br>
            <?php echo $cabecalho->vc_ministerio; ?>
            <br>
            
            <?php echo $cabecalho->vc_escola; ?>
            <br>
            <table class="table1" style="width:40% ;">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> VISTO <br>
            O DIRECTOR
          <br>
            
            </th>
            
        </tr>
        <tr class="tr1">
            <td class="td1" style=" padding-right:10px; "> <?php echo $cabecalho->vc_nomeDirector; ?>
            </td>
            
        </tr>

    </table>
        </p>

    </div>
    <br>
    <h4 class="text-center"><?php echo $titulo; ?>  de <?php echo $data_inicio; ?> /<?php echo $data_final; ?> </h4>
    <br>

    <table class="table tabelaStyle text-center">
        <thead>
            <tr>
                <th>CURSOS</th>
                <th>FEMENINO</th>
                <th>MASCULINO</th>
                <th>Per TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use App\Models\Alunno;
                  use Illuminate\Support\Facades\DB;
            if ($data == "Todos") {
                $cursos =DB::table('alunnos')->groupby('vc_nomeCurso')->get('vc_nomeCurso');
            } else {
                $cursos = DB::table('alunnos')->where([['vc_anoLectivo', $data]])->groupby('vc_nomeCurso')->get('vc_nomeCurso');
            }


            foreach ($cursos as $curso) : ?>

                <tr>
                    <td class="text-left"><?php echo $curso->vc_nomeCurso; ?></td>
                    <?php

                    if ($data == "Todos") {
                        $MporC = DB::table('alunnos')->where([['vc_nomeCurso', $curso->vc_nomeCurso], ['vc_genero', '=', "Masculino"]])->whereDate('created_at','>=', $data_inicio)
                        ->whereDate('created_at','<=', $data_final)->count();
                        $FporC =DB::table('alunnos')->where([['vc_nomeCurso', $curso->vc_nomeCurso], ['vc_genero', '=', "Feminino"]])->whereDate('created_at','>=', $data_inicio)
                        ->whereDate('created_at','<=', $data_final)->count();
                    } else {
                        $MporC =DB::table('alunnos')->where([['vc_anoLectivo', $data], ['vc_nomeCurso', $curso->vc_nomeCurso], ['vc_genero', '=', "Masculino"]])->whereDate('created_at','>=', $data_inicio)
                        ->whereDate('created_at','<=', $data_final)->count();
                        $FporC = DB::table('alunnos')->where([['vc_anoLectivo', $data], ['vc_nomeCurso', $curso->vc_nomeCurso], ['vc_genero', '=', "Feminino"]])->whereDate('created_at','>=', $data_inicio)
                        ->whereDate('created_at','<=', $data_final)->count();
                    }
                    ?>
                    <td><?php echo $FporC ?></td>
                    <td><?php echo $MporC ?></td>
                    <td><?php echo $MporC + $FporC ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>TOTAL GERAL</th>
                <th><?php echo $totalF; ?></th>
                <th><?php echo $totalM; ?></th>
                <th><?php echo $totalGeral ?></th>
            </tr>

        </tfoot>
    </table>

    <?php
    setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
    date_default_timezone_set('Africa/Luanda');
    ?>
    <p class="text-center" style="margin-top: 6%;"> <?php echo  strtoupper("Uíge"); ?> , AOS <?php echo strtoupper(strftime('%d de %B de %G', strtotime(date('d-m-Y', strtotime(date('Y-m-d')))))) ?></p>
    <table class="table1">
        <tr class="tr1">
            <th class="th1" style="padding-right: 20px;"> O COORDENADOR DA COMISSÃO <br>
                
            </th>
            <th class="th1"> O SUBDIRECTOR PEDAGÓGICO <br>
                
            </th>
        </tr>
        <tr class="tr1">
            <td class="td1"> <?php echo "" ?>
            </td>
            <td class="td1"> <?php echo $cabecalho->vc_nomeSubdirectorPedagogico; ?> <br>
            </td>
        </tr>

    </table>
</body>

</html>
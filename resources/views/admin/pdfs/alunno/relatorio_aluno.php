<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de Candidatura</title>
    <style>
        <?php echo $bootstrap;
        echo $style; ?>
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
                      <!--  <img src="<?php /*echo $cabecalho->vc_logo;*/ ?>" class="logotipo" width="100" height="100"> -->
            <?php echo $cabecalho->vc_escola; ?>
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

</body>

</html>
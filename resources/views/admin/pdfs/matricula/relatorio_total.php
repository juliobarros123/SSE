<!DOCTYPE html>
<html lang="pt-pt">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatório de matrícula</title>
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
           <img src="<?php echo ?>images/ensignia/<?php echo $cabecalho->vc_ensignia; ?>.png" class="" width="50" height="50">
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
                <!-- _____________________________________ -->
                <br>
                 <br>
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
    <h4 class="text-center"><?php echo $titulo; ?> <?php echo isset($data) ? ' no ano lectivo de ' . $data : 'alunos'; ?> <?php echo isset($vc_curso) ? 'no curso de ' . $vc_curso : 'de todos cursos ' ?><?php echo isset($vc_classe) && $vc_classe != 'Todos' ? ' da ' . $vc_classe . ' ª classe' : ' e de todas as classes' ?> </h4>
    <br>

    <table class="table tabelaStyle text-center">
        <thead>
            <tr>
                <th>CURSOS</th>
                <th width="120">PORTADOR DE DEFICIêNCIA</th>
                <th>FEMENINO</th>
                <th>MASCULINO</th>
                <th>Per TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php

            use Illuminate\Support\Facades\DB;

            $mpc = DB::table('matriculas')
                ->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')
                ->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id');

            if ($data == "Todos") {
                $cursos = $mpc->groupby('cursos.vc_nomeCurso')->get('cursos.vc_nomeCurso');
            } else {
                $cursos = $mpc->where([['matriculas.vc_anoLectivo', $data]])->groupby('cursos.vc_nomeCurso')->get('cursos.vc_nomeCurso');
            }
            if (isset($id_curso) && $id_curso != "Todos") {
                $cursos = $mpc->where('matriculas.it_idCurso', $id_curso)->groupby('cursos.vc_nomeCurso')->get('cursos.vc_nomeCurso');
            }

            foreach ($cursos as $curso) : ?>

                <tr>
                    <td class="text-left"><?php echo $curso->vc_nomeCurso; ?></td>
                    <?php

                    if ($data == "Todos") {
                        if (!isset($dia)) {
                            $DporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_dificiencia', '=', "Sim"]])->where('matriculas.it_estado_matricula', 1);
                            $MporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Masculino"]])->where('matriculas.it_estado_matricula', 1);
                            $FporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Feminino"]])->where('matriculas.it_estado_matricula', 1);
                        } else {
                            $DporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_dificiencia', '=', "Sim"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                            $MporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Masculino"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                            $FporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Feminino"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                        }
                    } else 
                        if (!isset($dia)) {
                        $DporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_dificiencia', '=', "Sim"]])->where('matriculas.it_estado_matricula', 1);
                        $MporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Masculino"]])->where('matriculas.it_estado_matricula', 1);
                        $FporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Feminino"]])->where('matriculas.it_estado_matricula', 1);
                    } else {
                        $DporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_dificiencia', '=', "Sim"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                        $MporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Masculino"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                        $FporC = DB::table('matriculas')->join('classes', 'matriculas.it_idClasse', '=', 'classes.id')->join('cursos', 'matriculas.it_idCurso', '=', 'cursos.id')->join('alunnos', 'matriculas.it_idAluno', '=', 'alunnos.id')->where([['matriculas.vc_anoLectivo', $data], ['cursos.vc_nomeCurso', $curso->vc_nomeCurso], ['alunnos.vc_genero', '=', "Feminino"]])->where('matriculas.it_estado_matricula', 1)->whereDate('matriculas.created_at', $dia);
                    }
                    ?>
                    <?php

                    if (isset($vc_classe)) {
                        $DporC =    $DporC->where('classes.vc_classe', $vc_classe)->count();
                        $FporC =    $FporC->where('classes.vc_classe', $vc_classe)->count();
                        $MporC =    $MporC->where('classes.vc_classe', $vc_classe)->count();
                    } else {
                        $DporC =    $DporC->count();
                        $FporC =    $FporC->count();
                        $MporC = $MporC->count();
                    }
                    ?>
                    <td><?php echo $DporC ?></td>
                    <td><?php echo $FporC ?></td>
                    <td><?php echo $MporC ?></td>
                    <td><?php echo $MporC + $FporC ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <th>TOTAL GERAL</th>
                <th><?php echo $totalD; ?></th>
                <th><?php echo $totalF; ?></th>

                <th><?php

                    echo $data != ""  && !isset($vc_classe) && !isset($vc_curso) ? $totalM + 1 : $totalM; ?></th>
                <th><?php echo $data != ""  && !isset($vc_classe) && !isset($vc_curso) ? $totalGeral + 1 : $totalGeral; ?>
                </th>
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
        <th class="th1" style="padding-left: 80px;padding-right: 100px;"><br><br> O COORDENADOR DA COMISSÃO <br>
                <!-- _____________________________________________________ -->
                <br><br><br>

            </th>
            <th class="th1"><br><br> O SUBDIRECTOR PEDAGÓGICO <br>
                <!-- ____________________________________________________ -->
                <br><br><br>

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
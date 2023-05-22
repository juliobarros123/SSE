<?php
use App\Models\Alunno;
use App\Models\Classe;
use App\Models\Disciplinas;
use App\Models\Nota;
function notasDeOutrosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe)
{
    $nota = new Nota;

    $data = mediaDosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe);
    dd($data, $id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe);
    return $data;

}

function mediaDosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $id_ultima_classe)
{

    $nota = new Nota;
    $notas = collect();
    $CAS = collect();
    $classe = Classe::find($id_ultima_classe);
    $classe->vc_classe;
    $ttlClasses = 0;
    for ($cont = $classe->vc_classe; $cont >= 10; $cont--) {

//    dd(notasFakes($id_aluno,$id_disciplina,$id_anoLectivo,$classe->id));

        $classe = Classe::where('vc_classe', $cont)->first();

        $notas->push($nota->notasNoutrosAnos($id_aluno, $id_disciplina, $id_anoLectivo, $classe->id)->get());

        $ttlClasses++;

        //  dd( $ttlClasses);
        $mediaDosAnos = 0;
        $classe = Classe::find($id_ultima_classe);
        // $notas[1][1]=['f'=>0];
        // for ($contAno = 0; $contAno < 3; $contAno++) {
        //     for ($contAno1 = 0; $contAno1 < 3; $contAno1++) {

        //         if (!isset($notas[$contAno][$contAno1])) {
        //             $notas[$contAno][1]='';
        //         }
        //     }
        // dd($notas);
        //     }

    }

//  dd($notas);
    // if ($id_aluno == '13518') {
    //     addNotasFakes($id_aluno,$notas, $classe->vc_classe,$id_disciplina,$id_anoLectivo);
    // }
    $notas=  addNotasFakes($id_aluno,$notas, $classe->vc_classe,$id_disciplina,$id_anoLectivo);
    // dd($notas);
    foreach ($notas as $notasAnual) {

        //  dd($notasAnual->where('vc_tipodaNota', 'I')->fl_media);
        $ca = 0;
        $mat1 = isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media : 0;
        $mat2 = isset($notasAnual->where('vc_tipodaNota', 'II')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'II')->first()->fl_media : 0;
        $mat3 = isset($notasAnual->where('vc_tipodaNota', 'III')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'III')->first()->fl_media : 0;
    //    dd($notas[2]);
//       if ($id_aluno == '13518' && $notasAnual[]) {
//       dd($notasAnual);
//   }
        if ($notasAnual->count()) {
            /* $ca = ceil(($mat1 + $mat2 + $mat3) / 3); */
            $ca = round((($mat1 + $mat2 + $mat3) / 3), 0, PHP_ROUND_HALF_UP);
            //guardar acs dos anos anteriores

            $id_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->first()->id_classe : 0;
            $vc_classe = isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->first()->vc_classe : 0;
            $vc_nome = isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ? $notasAnual->where('vc_tipodaNota', 'I')->first()->vc_nome : 0;

            if ($classe->vc_classe > $vc_classe) {
                $CAS->push(['id_classe' => $id_classe, 'ca' => $ca, 'id_diciscplina' => $id_disciplina, 'vc_classe' => $vc_classe, 'vc_nome' => $vc_nome]);
            } else {
                // dd($classe->vc_classe,$vc_classe);
            }

        } else {
            //  dd($notasAnual->count(),$notasAnual, $notas,$mediaDosAnos);
            $ca = 0;
        }

        $mediaDosAnos += $ca;

    }
//    dd(  $CAS);
    $media = round(($mediaDosAnos / $notas->count()), 0, PHP_ROUND_HALF_UP);
    $dados['media'] = $media;
    $dados['ACS'] = $CAS;

// dd($dados['ACS'] );
    return $dados;
}
function addNotasFakes($id_aluno,$notas, $ultimaClasse,$id_disciplina,$id_anoLectivo)
{
    // dd($notas,$ultimaClasse);
    for ($cont = $ultimaClasse; $cont >= 10; $cont--) {

    for ($cont1 = 0; $cont1 <= $ultimaClasse - 10; $cont1++) {
            // dd($notas[$cont1]);
            if (isset($notas[$cont1])) {
                for ($cont2 = 0; $cont2 <= 2; $cont2++) {
                    if (isset($notas[$cont1][$cont2])) {
                 
                    }else{
                    
                        if( $cont1==0){
                            $classe=12;
                        }else  if( $cont1==1){
                            $classe=11;
                        }else  if( $cont1==2){
                            $classe=10;
                        }
                        $aluno=Alunno::find($id_aluno);
                        $id_classe=Classe::where('vc_classe',$classe)->first()->id;
                        // dd(    $notas[$cont1]);
                     $notas[$cont1] =  $notas[$cont1]->push(["it_idAluno"=>13518,
                     "vc_nome"=>Disciplinas::find($id_disciplina)->vc_nome,
                     "vc_acronimo"=>Disciplinas::find($id_disciplina)->vc_acronimo,
                     "vc_tipodaNota"=>"FK",
                     "id_classe"=>$id_classe,
                     "vc_classe"=>$classe,
                     "id_disciplina"=>$id_disciplina,
                     "fl_media"=>0.0,
                     "fl_nota1"=>0.0,
                     "fl_nota2"=>0.0,
                     "fl_mac"=>0.0,
                     "id"=>$id_aluno,
                     "vc_primeiroNome"=>  $aluno->vc_primeiroNome,
                     "vc_nomedoMeio"=>  $aluno->vc_nomedoMeio,
                     "vc_ultimoaNome"=>  $aluno->vc_ultimoaNome,
                     "ya_inicio"=>2021,
                     "ya_fim"=>2022,
                     "id_anolectivo"=>$id_anoLectivo]);
 
                     $notas[$cont1]->all();
                       
                    }

                }
            }
        }

    }
return $notas;

}

function notasFakes($id_aluno, $id_disciplina, $id_anoLectivo, $id_classe)
{

    $disciplina = Disciplinas::find($id_disciplina);
    // $classe = Classe::find($id_classe);
    $aluno = Alunno::find($id_aluno);
    //Alun
    //  $AnoLectivo=AnoLectivo::find($id_anoLectivo);
    //  dd( $AnoLectivo);

    $fkNotas =
        ["it_idAluno" => $id_aluno,
        "vc_nome" => $disciplina->vc_nome,
        "vc_acronimo" => $disciplina->vc_acronimo,
        "vc_tipodaNota" => 'FK',
        "id_classe" => $id_classe,
        "vc_classe" => 'FK',
        "id_disciplina" => $id_disciplina,
        "fl_media" => 0,
        "fl_nota1" => 0,
        "fl_nota2" => 0,
        "fl_mac" => 0,
        "id" => $id_aluno,
        "vc_primeiroNome" => $aluno->vc_primeiroNome,
        "vc_nomedoMeio" => $aluno->vc_nomedoMeio,
        "vc_ultimoaNome" => $aluno->vc_ultimoaNome,
        "ya_inicio" => '',
        "ya_fim" => '',
        "id_anolectivo" => $id_anoLectivo];
    //
    return $fkNotas;

}

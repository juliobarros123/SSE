<?php  
use App\Models\Nota;
use App\Models\Matricula;
use App\Models\AnoLectivo;
use App\Models\Classe;
 function notasDeOutrosAnos($id_aluno,$id_disciplina, $id_anoLectivo,$id_ultima_classe){
    $nota=new Nota;

    $data=mediaDosAnos($id_aluno,$id_disciplina, $id_anoLectivo,$id_ultima_classe);
    dd( $data);
return   $data;

}

function mediaDosAnos($id_aluno,$id_disciplina, $id_anoLectivo,$id_ultima_classe){
    $nota=new Nota;
    $notas=collect();
    $CAS=collect();
    $classe=Classe::find($id_ultima_classe);
    $classe->vc_classe;
    $ttlClasses=0;
   for($cont=$classe->vc_classe;$cont>=10;$cont--){

   $classe= Classe::where('vc_classe',$cont)->first();
   
    $notas->push($nota->notasNoutrosAnos($id_aluno,$id_disciplina,$id_anoLectivo,$classe->id)->get());
    $ttlClasses++;
   }
  //  dd( $ttlClasses);
    $mediaDosAnos=0;
    $classe=Classe::find($id_ultima_classe);
   foreach(  $notas as   $notasAnual){
    //  dd($notasAnual->where('vc_tipodaNota', 'I')->fl_media);
    $ca=0;
    $mat1 = isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media : 0;
    $mat2 =  isset($notasAnual->where('vc_tipodaNota', 'II')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'II')->first()->fl_media : 0;
    $mat3 =  isset($notasAnual->where('vc_tipodaNota', 'III')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'III')->first()->fl_media : 0;
   if($notasAnual->count()){
  /*   $ca= ceil(($mat1 + $mat2 + $mat3) / $notasAnual->count()); */
    $ca = round(($mat1 + $mat2 + $mat3) / $notasAnual->count(), 0, PHP_ROUND_HALF_UP);
    //guardar acs dos anos anteriores
   
    $id_classe=isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'I')->first()->id_classe : 0;
    $vc_classe=isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'I')->first()->vc_classe : 0;
    $vc_nome=isset($notasAnual->where('vc_tipodaNota', 'I')->first()->fl_media) ?$notasAnual->where('vc_tipodaNota', 'I')->first()->vc_nome : 0;

    if( $classe->vc_classe>$vc_classe){
        $CAS->push( ['id_classe'=>$id_classe,'ca'=>$ca,'id_diciscplina'=>$id_disciplina,'vc_classe'=>$vc_classe,'vc_nome'=>$vc_nome]);
    }else{
        // dd($classe->vc_classe,$vc_classe);
    }
    

   }else{
    //  dd($notasAnual->count(),$notasAnual, $notas,$mediaDosAnos);
    $ca=0;
   }

    $mediaDosAnos+=$ca;
   

}
//    dd(  $CAS);
$media=round(($mediaDosAnos/$notas->count()), 0, PHP_ROUND_HALF_UP);
$dados['media']=$media;
$dados['ACS']=$CAS;
return $dados;
}
?> 
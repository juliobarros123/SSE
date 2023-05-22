<?php
 namespace App\Http\ViewComposers;

use App\Models\AnoLectivo;


class AnoLectivoComposer {

    public $id;
    public function compose($view)
    {
       
            $anoLectivo= AnoLectivo::find($this->id);
            $view->with('id_anoLectivo', $anoLectivo->id); 
            $view->with('anoLectivo', $anoLectivo->ya_inicio . '-' . $anoLectivo->ya_fim); 
    }

}
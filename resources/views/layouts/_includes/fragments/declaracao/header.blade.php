<div class="header">
    <img src="images/insignia-certificado.png" alt="Logo da Escola">
   
  
    <h3>{{$cabecalho->vc_republica}} <br>{{$cabecalho->vc_ministerio}} 
        <br>{{$cabecalho->vc_escola}} 
        <br>{{$info_declaracao->ensino}}
        
    </h3>
  

</div>

@if ($visto=="Sim")
<div class="visa-container visto-director-municipal" style="width: 26%;" >
    <h3>  Visto
       
    </h3>
    <div>O(A) Director(a) Municipal</div>
    <br>
    <hr>

    <div >
        <i>{{$cabecalho->director_municipal}}   </i>

    </div>
</div>
@endif

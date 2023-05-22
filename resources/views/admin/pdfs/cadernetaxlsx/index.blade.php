

@foreach ($alunos as $aluno)

<table>
    <tr>
        <td style="text-align: center; width:70%; font-size:10px"><h1 style="font-weight: lighter"><strong><?php echo $cabecalho->vc_escola; ?></strong></h1></td>
    </tr>

    <tr>
        <td style="text-align: center; width:70%; font-size:10px"><h1><strong>Caderneta do Aluno</strong></h1></td>
    </tr>
    <tr>
        <td>

            @php
            $data = public_path().'/'.$aluno->vc_imagem;
            $data2 = public_path().'/images/caderneta/cadernetabottom.jpg';
            $data3 = public_path().'/images/caderneta/caderneta2.jpg';
            @endphp
            <img width="110" height="100" src="{{$data}}" />
            <div style="display: flex; background-color : red; padding: 200px" >
                <p style="flex: 1 1 auto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;              Nome {{$aluno->vc_primeiroNome}} {{$aluno->vc_ultimoaNome}} </p>
                <p style="flex: 1 1 auto">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;     &nbsp;     Processo {{$aluno->id}}  </p>
                <p style="flex: 1 1 auto">  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Telefone {{$aluno->it_telefone}}  </p>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <table>
                <tr>
                    <td>sdsd</td>
                    <td>sdsd</td>
                    <td>sdsd</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <img style="width:600px!important; height: 90px !important;" src="{{$data3}}" />

    </tr>
    <tr>
        <img style="width:98% !important; height: 90px !important;" src="{{$data2}}" />

    </tr>
    <tr>
        <td> </td>
    </tr>
    <tr>
        <td> </td>
    </tr>
    <tr>
        <td style="border: 2px solid rgb(48, 47, 47);paddind:10px">
            <p>Nome do Enc. de Educação: {{isset($aluno->vc_namePai)  ? $aluno->vc_namePai : $aluno->vc_nameMae }}</p>
        </td>
    </tr>
    <tr>
        <td> </td>
    </tr>
    <tr>
        <td>
            <p><strong>OBS</strong>________________________________________________________________________________________________________</p>
        </td>
    </tr>

</table>

@endforeach

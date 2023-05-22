@extends('layouts.site')
@section('conteudo')






    <div class="main">

        <div class="container mt-5 p-5">
            <div class="mb-5">
                <h3 class="text-center">ATUALIZAÇÃO DOS DADOS</h3>
            </div>
            <div class="mt-5 col-md-12">


                <form method="post" action="{{ route('admin.admitidoPost') }}" enctype="multipart/form-data"
                    class="col-md-12">
                    @csrf
                    @include('forms._formadmitido.index')

                    <div class="col-md-12 ">
                        <div class="row">
                            <button class="btn btn-success p-4 mx-auto col-md-2" type="submit">Atualizar</button>

                        </div>

                    </div>
                </form>

            </div>


        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('aluno'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Dados actualizados',
        })
    </script>
@endif

@if (session('aviso'))
<script>
    Swal.fire(
        'Erro ao actualizar os dados!',
        '',
        'error'
    )

</script>
@endif

<script src="{{asset('/vendor/jquery/jquery.min.js')}}"></script>


<script>
    $("#vc_bi").keyup(function() {
        var bi = $(this).val();
        let url_origin = "{{url('/')}}";
        limpar() ;
        $.ajax({
            type: 'GET',
            url: url_origin+'/admin/cidadao/' + bi,
            success: function(response) {

                console.log(response["ObterContribuinte"]["contribuinte"])
               
                var nome = response["ObterContribuinte"]["contribuinte"].denominacao
                nome = nome.split(' ').at(0);

                var sobrenome = response["ObterContribuinte"]["contribuinte"].denominacao
                sobrenome = sobrenome.split(' ').pop();

                var nomedomeio = response["ObterContribuinte"]["contribuinte"].denominacao
                nomedomeio = getStringBetween(nomedomeio, nome+' ', ' '+sobrenome);
                




                $("#vc_primeiroNome").val(nome);
                $("#vc_apelido").val(sobrenome);
                $("#vc_nomedoMeio").val(nomedomeio);

                
                $("#vc_nomePai").val(response["ObterContribuinte"]["contribuinte"].nomePai);
                $("#vc_nomeMae").val(response["ObterContribuinte"]["contribuinte"].nomeMae);
                $("#vc_genero").val(response["ObterContribuinte"]["contribuinte"].sexo);
                $("#dt_dataNascimento").val(response["ObterContribuinte"]["contribuinte"].dataNascimento);

                $("#vc_estadoCivil").val(response["ObterContribuinte"]["contribuinte"].estadoCivil);
                /* $("#dt_emissao").val(response[0].ISSUE_DATE);
                $("#vc_localEmissao").val(response[0].ISSUE_PLACE);
                $("#vc_residencia").val(response[0].RESIDENCE_ADDRESS);
                $("#vc_naturalidade").val(response[0].BIRTH_PROVINCE_NAME);
                $("#vc_provincia").val(response[0].BIRTH_PROVINCE_NAME); */

            }
        });
    });

    function getStringBetween(str, start, end) {
    const result = str.match(new RegExp(start + "(.*)" + end));

        return result[1];
    }

    


    function limpar() {
        $("#vc_primeiroNome").val("");
        $("#vc_apelido").val("");
        $("#vc_nomePai").val("");
        $("#vc_nomeMae").val("");
        $("#vc_genero").val("");
        $("#dt_dataNascimento").val("");

        $("#vc_estadoCivil").val("");
        $("#dt_emissao").val("");
        $("#vc_localEmissao").val("");
        $("#vc_residencia").val("");
        $("#vc_naturalidade").val("");
        $("#vc_provincia").val("");
    }
</script>
@endsection

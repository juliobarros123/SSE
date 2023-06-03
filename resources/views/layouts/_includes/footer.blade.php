<!-- JS -->
<script src="{{ asset('/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('/vendor/boostrap/bootstrap.min.js') }}"></script>
<script src="{{ asset('/vendor/acc-wizard-master/release/acc-wizard.min.js') }}"></script>
<script src="{{ asset('/vendor/jquery-validation/dist/jquery.validate.min.js') }}"></script>
<script src="{{ asset('/vendor/jquery-validation/dist/additional-methods.min.js') }}"></script>
<script src="{{ asset('/vendor/jquery-steps/jquery.steps.min.js') }}"></script>
<script src="{{ asset('/vendor/minimalist-picker/dobpicker.js') }}"></script>
<script src="{{ asset('/js/main.js') }}"></script>

<script>
    $("#vc_bi").keyup(function() {
        var bi = $(this).val();

        limpar();
        $.ajax({
            type: 'GET',
            url: 'admin/cidadao/' + bi,
            success: function(response) {

                /*  console.log(response["ObterContribuinte"]["contribuinte"]) */
                /*  $("#vc_primeiroNome").val(response[0].FIRST_NAME);
                 $("#vc_apelido").val(response[0].LAST_NAME);
                 $("#vc_nomePai").val(response[0].FATHER_FIRST_NAME + ' ' + response[0]
                     .FATHER_LAST_NAME);
                 $("#vc_nomeMae").val(response[0].MOTHER_FIRST_NAME + ' ' + response[0]
                     .MOTHER_LAST_NAME);
                 $("#vc_genero").val(response[0].GENDER_NAME);
                 $("#dt_dataNascimento").val(response[0].BIRTH_DATE);

                 $("#vc_estadoCivil").val(response[0].MARITAL_STATUS_NAME);
                 $("#dt_emissao").val(response[0].ISSUE_DATE);
                 $("#vc_localEmissao").val(response[0].ISSUE_PLACE);
                 $("#vc_residencia").val(response[0].RESIDENCE_ADDRESS);
                 $("#vc_naturalidade").val(response[0].BIRTH_PROVINCE_NAME);
                 $("#vc_provincia").val(response[0].BIRTH_PROVINCE_NAME); */

                /* $("#vc_primeiroNome").val(response[0].FIRST_NAME);
                $("#vc_apelido").val(response[0].LAST_NAME);
                
                $("#vc_nomePai").val(response["ObterContribuinte"]["contribuinte"].nomePai);
                $("#vc_nomeMae").val(response["ObterContribuinte"]["contribuinte"].nomeMae);
                $("#vc_genero").val(response["ObterContribuinte"]["contribuinte"].sexo);
                $("#dt_dataNascimento").val(response["ObterContribuinte"]["contribuinte"].dataNascimento);

                $("#vc_estadoCivil").val(response["ObterContribuinte"]["contribuinte"].estadoCivil); */
                /* $("#dt_emissao").val(response[0].ISSUE_DATE);
                $("#vc_localEmissao").val(response[0].ISSUE_PLACE);
                $("#vc_residencia").val(response[0].RESIDENCE_ADDRESS);
                $("#vc_naturalidade").val(response[0].BIRTH_PROVINCE_NAME);
                $("#vc_provincia").val(response[0].BIRTH_PROVINCE_NAME); */

            }
        });
    });

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

@if (session('feedback'))
    {{-- @dump(session('feedback')); --}}

    @if (isset(session('feedback')['type']))
        <script>
            Swal.fire(
                '{{ session('feedback')['sms'] }}',
                '',
                '{{ session('feedback')['type'] }}'
            )
        </script>
    @endif
@endif
<script>
    $('#id_curso').change(function() {
        var curso = $(this).find("option:selected").text();
        var url = "{{ url('/') }}"
        url = url + '/classes_por_curso/' + curso;
    
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            success: function(classes) {

                console.log(classes);
                $("#id_classe").empty();
                $("#id_classe").append('<option value="">Selecciona a Classe</option>');
                $.each(classes, function(index,classe) {

                //  console.log(classe,)
                        $("#id_classe").append('<option value="' + classe.id + ' " >' +classe.vc_classe +
                            'ª Classe</option>');
                

                });




            }
        });


    });
</script>
</body>

</html>

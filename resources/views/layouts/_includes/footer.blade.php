<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->

<div id="sidebar-overlay"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery -->
<script src="{{ asset('/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
{{-- <!-- ChartJS -->
<script src="{{asset('/plugins/chart.js/Chart.min.js')}}"></script> --}}
<!-- Sparkline -->
<script src="{{ asset('/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
{{-- <script src="{{asset('/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script> --}}
<!-- jQuery Knob Chart -->
<script src="{{ asset('/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/jquery.mask.min.js') }}"></script>
<script src="{{ asset('/js/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('/js/jquery.steps.min.js') }}"></script>
<script src="{{ asset('/js/select2.min.js') }}"></script>
<script src="{{ asset('/js/jquery.timepicker.js') }}"></script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js')}}"></script> --}}

<script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/dist/js/adminlte.js') }}"></script>
{{-- <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/dist/js/pages/dashboard.js')}}"></script> --}}

<!-- AdminLTE for demo purposes -->
<script src="{{ asset('/dist/js/demo.js') }}"></script>
{{-- Datatables --}}
<script src="{{ asset('/js/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/js/datatables/dataTables.bootstrap4.min.js') }}"></script>
<!-- sweetalert -->
<script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>



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
{{-- <script>
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
                $.each(classes, function(index, classe) {

                    //  console.log(classe,)
                    $("#id_classe").append('<option value="' + classe.id + ' " >' + classe
                        .vc_classe +
                        'ª Classe</option>');


                });




            }
        });


    });
</script> --}}
<script>
    $('#id_curso_sem_todas').change(function() {
        var curso = $(this).find("option:selected").text();
        // console.log(curso);
        // alert("ola");
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
                // alert("ola");
                $("#id_classe").empty();
                $("#id_classe").append('<option value="">Selecciona a Classe</option>');


                $.each(classes, function(index, classe) {

                    //  console.log(classe,)
                    $("#id_classe").append('<option value="' + classe.id + ' " >' + classe
                        .vc_classe +
                        'ª Classe</option>');


                });




            }
        });


    });
</script>
<script>
    $('#id_provincia').change(function() {
        var provincia = $(this).val();
        // var idMunicipio = $('#id_municipio').val();
        // alert(provincia);
        let url_origin = "{{ url('/') }}";

        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url_origin + `/buscar/municipios/${provincia}/nome`,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            success: function(municipios) {

                // response.forEach(element => {
                //     console.log
                // })
                // console.log(municipios);
                // alert("ol");
                $("#id_municipio").empty();
                $("#id_municipio").append('<option select value=""> Selecionar o Município</option>');
                $.each(municipios, function(municipio) {

                    console.log(municipios[municipio].vc_nome);

                    $("#id_municipio").append('<option value="' + municipios[
                            municipio].id + ' " selected>' + municipios[municipio]
                        .vc_nome +
                        '</option>');


                });




            }
        });


    });
</script>
<script>
    $(document).ready(function() {
        $('.select-dinamico').select2();
    });
</script>

</body>

</html>

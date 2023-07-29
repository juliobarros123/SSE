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
    $(".so_nota").hide();
    $(".nota_idade").hide();
    $(".so_idade").hide();
    $(".intervalo_de_idade").hide();
    $(".intervalo_de_idade_nota").hide();
    $(".intervalo_de_idade_intervalo_de_media").hide();
    $('#tipo_filtro').change(function() {
        if ($('#tipo_filtro').val() == "1") {
            $(".so_nota").show();
        } else {
            $(".so_nota").hide();
        }

        if ($('#tipo_filtro').val() == "2") {
            $(".so_idade").show();
        } else {
            $(".so_idade").hide();
        }

        if ($('#tipo_filtro').val() == "3") {
            $(".nota_idade").show();
        } else {
            $(".nota_idade").hide();
        }
        if ($('#tipo_filtro').val() == "4") {
            $(".intervalo_de_idade").show();
        } else {
            $(".intervalo_de_idade").hide();
        }
        if ($('#tipo_filtro').val() == "5") {
            $(".intervalo_de_idade_nota").show();
        } else {
            $(".intervalo_de_idade_nota").hide();
        }
        if ($('#tipo_filtro').val() == "6") {
            $(".intervalo_de_idade_intervalo_de_media").show();
        } else {
            $(".intervalo_de_idade_intervalo_de_media").hide();
        }
    });
</script>


<script>
    $(document).ready(function() {
        $('.select-dinamico').select2();
    });
</script>

<script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>

@if (session('mensagem_dinamica'))
    <script>
        Swal.fire(
            '{{ session('mensagem_dinamica') }}',
            '{{ session('obs') }}',
            '{{ session('tipo') }}'
        )
    </script>
@endif

<script>
    // function consulta() {
    //     $.ajax({
    //         url: "http://localhost/SiteITEL/api/inscritos/take",
    //         type: "GET",
    //         dataType: "json",
    //         success: function(dados) {
    //             console.log(dados)
    //             $('#data').val(Object.values(dados));
    //             $.ajax({
    //                 url: "{{ route('admin.candidatos-api.create') }}",
    //                 type: "POST",
    //                 data: $(this).serialize(),
    //                 dataType: "json",
    //                 success: function(response) {
    //                     console.log(response.success)
    //                 }
    //             })

    //         },
    //         error: function(data) {
    //             alert("Algum erro ocorreu, consulte o log.");
    //         },
    //         complete: function() {
    //             loading.hide();
    //         }
    //     });
    // }

    // $(function() {
    //     $('form[name= formulario]').submit(
    //         function(event) {
    //             event.preventDefault();
    //             consulta()
    //     }
    // )
    // })

    // $.ajax({
    //     url: "{{ route('admin.candidatos-api.create') }}"),
    // type: "POST",
    // data: $(this).serialize() dataType: "json",
    // success: function(response) {
    //     console.log(response)
    // }
    // })
</script>

<style>
    /* style a mexer */
    .select2-container .select2-selection--single {
        box-sizing: border-box;
        cursor: pointer;
        display: block;
        height: 35px;
        user-select: none;
        -webkit-user-select: none;
    }
</style>

<script>
    $('.select2').select2({
        theme: 'bootstrap4',
    });

    $('.select2-multi').select2({
        multiple: true,
        theme: 'bootstrap4',
    });

    $('.drgpicker').daterangepicker({
        singleDatePicker: true,
        timePicker: false,
        showDropdowns: true,
        locale: {
            format: 'MM/DD/YYYY'
        }
    });
    $('.time-input').timepicker({
        'scrollDefault': 'now',
        'zindex': '9999' /* fix modal open */
    });
    /** date range picker */
    if ($('.datetimes').length) {
        $('.datetimes').daterangepicker({
            timePicker: true,
            startDate: moment().startOf('hour'),
            endDate: moment().startOf('hour').add(32, 'hour'),
            locale: {
                format: 'M/DD hh:mm A'
            }
        });
    }
    var start = moment().subtract(29, 'days');
    var end = moment();

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf(
                'month')]
        }
    }, cb);

    cb(start, end);
    $('.input-placeholder').mask("00/00/0000", {
        placeholder: "__/__/____"
    });
    $('.input-zip').mask('00000-000', {
        placeholder: "____-___"
    });
    $('.input-money').mask("#.##0,00", {
        reverse: true
    });
    $('.input-phoneus').mask('(000) 000-0000');
    $('.input-mixed').mask('AAA 000-S0S');
    $('.input-ip').mask('0ZZ.0ZZ.0ZZ.0ZZ', {
        translation: {
            'Z': {
                pattern: /[0-9]/,
                optional: true
            }
        },
        placeholder: "___.___.___.___"
    });
    // editor
    var editor = document.getElementById('editor');
    if (editor) {
        var toolbarOptions = [
            [{
                'font': []
            }],
            [{
                'header': [1, 2, 3, 4, 5, 6, false]
            }],
            ['bold', 'italic', 'underline', 'strike'],
            ['blockquote', 'code-block'],
            [{
                    'header': 1
                },
                {
                    'header': 2
                }
            ],
            [{
                    'list': 'ordered'
                },
                {
                    'list': 'bullet'
                }
            ],
            [{
                    'script': 'sub'
                },
                {
                    'script': 'super'
                }
            ],
            [{
                    'indent': '-1'
                },
                {
                    'indent': '+1'
                }
            ], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                    'color': []
                },
                {
                    'background': []
                }
            ], // dropdown with defaults from theme
            [{
                'align': []
            }],
            ['clean'] // remove formatting button
        ];
        var quill = new Quill(editor, {
            modules: {
                toolbar: toolbarOptions
            },
            theme: 'snow'
        });
    }
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function() {
        'use strict';
        window.addEventListener('load', function() {
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.getElementsByClassName('needs-validation');
            // Loop over them and prevent submission
            var validation = Array.prototype.filter.call(forms, function(form) {
                form.addEventListener('submit', function(event) {
                    if (form.checkValidity() === false) {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                    form.classList.add('was-validated');
                }, false);
            });
        }, false);
    })();
</script>

<script>
    console.log("Entrada")
</script>
{{-- Existe dataTable server side? --}}
@if (!isset($dt_server_side))
    <script>
        $(document).ready(function() {
            $('#example').DataTable({

                "order": [
                    [0, 'desc']
                ]
            });
        });
    </script>
@endif


@if (session('permissao'))
    <script>
        Swal.fire(
            'Você não tem permissão para acessar essa aba',
            '',
            'error'
        )
    </script>
@endif
@if (session('error_tem_registro'))
    <script>
        Swal.fire(
            'Erro ',
            ' Verifica se esta relação já existe',
            'error'
        )
    </script>
@endif



<script>
    $("#img-input").click(function() {
        $("#image_visible").hide();
    });
</script>

<script>
    function readImage() {
        if (this.files && this.files[0]) {
            var file = new FileReader();
            file.onload = function(e) {
                document.getElementById("preview").src = e.target.result;
            };
            file.readAsDataURL(this.files[0]);
        }
    }

    document.getElementById("img-input").addEventListener("change", readImage, false);
</script>
<script>
    function showImage(imagePath, item) {

        let nome = imagePath;
        // let image = null;
        if (item.hasOwnProperty("id_m")) {
            nome = document.getElementById("imageoption").src = "{{ url('/') }}" + "/" + nome
        } else {
            nome = document.getElementById("imageoption").src = "{{ url('/') }}" + "/confirmados/" + nome
        }
        let file = document.getElementById("file")
        document.getElementById("vc_nameImage").value = nome
        document.getElementById("nome").innerHTML = "Nome: " + item.vc_primeiroNome + " " + item.vc_nomedoMeio + " " +
            item.vc_ultimoaNome


    }
</script>


<script type="text/javascript">
    let url_origin = "{{ url('/') }}";

    $('.buscarEscola').select2({
        placeholder: 'Selecionar Escola',
        ajax: {
            url: url_origin + '/buscar/escolas',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_escola,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });




    $('.buscarTurmaMatricula').select2({
        placeholder: 'Selecionar a Turma',
        ajax: {
            url: url_origin + '/buscar/turmas-matricula',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nomedaTurma + "| " + item.vc_turnoTurma + "| " + item
                                .vc_cursoTurma + "| " + item.vc_classeTurma + " ª Classe" +
                                "| Ano Lectivo " + item.vc_anoLectivo,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });


    $('.buscarTurmaAtrib').select2({
        placeholder: 'Selecionar a Turma',
        ajax: {
            url: url_origin + '/buscar/turmas-atrib',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nomedaTurma + "| " + item.vc_turnoTurma + "| " + item
                                .vc_cursoTurma + "| " + item.vc_classeTurma + " ª Classe",
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    function getTurma() {
        $('#selectT').change(function() {
            var data = $('#valueTurma').val();
            console.log(data)
        })



    }
    getTurma();
    $('.buscarDisciplinaAttrib').select2({
        placeholder: 'Selecionar a Disciplina',
        ajax: {
            url: url_origin + '/buscar/disciplinas/attrib',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nome,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.buscarProcesso').select2({
        placeholder: 'Selecionar o Numero de Processo',

        ajax: {
            url: url_origin + '/buscar/processos',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {

                //var url2 = "{{ url('/') }}" + '/api/' + data[0].id + '/pauta-final';
                var url2 = "{{ url('/') }}" + '/api/' + data[0].id + '/pauta-final';
                $.ajax({
                    type: 'GET',
                    url: url2,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data2) {
                        $("#resultado").val();
                        if ("Pendente" != data2) {
                            $("#resultado").val(data2.notas[data2.notas.length - 1].resultado);
                            // $("#resultado").val();
                            console.log(data2.notas[data2.notas.length - 1].resultado);
                        } else {
                            $("#resultado").val(data2);
                        }

                    }
                });
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        //alert(item)
                        showImage(item.foto, item)
                        return {
                            text: item.id,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });



    $('.buscarClasse').select2({
        placeholder: 'Selecionar a classe',
        ajax: {
            url: url_origin + '/buscar/classes',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_classe,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.buscarProvincia').select2({
        /* placeholder: 'Selecionar a Província',
        ajax: {
            url: url_origin+'/buscar/provincias',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nome,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        } */
    });

    $('.buscarMunicipio').select2({

    });

    $('#it_id_provincia').change(function() {
        var id = $(this).val();
        var idMunicipio = $('#it_id_municipio').val();
        //alert(idMunicipio)
        $.ajax({
            type: 'GET',
            dataType: 'json',
            url: url_origin + '/buscar/municipios/' + id,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            async: false,
            success: function(municipios) {

                // response.forEach(element => {
                //     console.log
                // })
                //console.log(municipios);
                $("#it_id_municipio").empty();
                $("#it_id_municipio").append('<option select  "> Selecionar o Município</option>');
                $.each(municipios, function(municipio) {

                    //console.log(municipios[municipio].vc_nome);
                    //alert(municipios[municipio].id )
                    if (idMunicipio == municipios[municipio].id) {
                        //alert("igual")
                        $("#it_id_municipio").append('<option value="' + municipios[
                                municipio].id + ' " selected>' + municipios[municipio]
                            .vc_nome +
                            '</option>');
                    } else {
                        $("#it_id_municipio").append('<option value="' + municipios[
                                municipio].id + ' ">' + municipios[municipio].vc_nome +
                            '</option>');
                    }

                });




            }
        });


    });









    $('.buscarTurma').select2({
        placeholder: 'Selecionar a Turma',
        ajax: {
            url: url_origin + '/buscar/turmas',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nomeDaTurma,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
    $('.buscarCurso').select2({
        placeholder: 'Selecionar o curso',
        ajax: {
            url: url_origin + '/buscar/cursos',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nomeCurso,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.buscarDisciplina').select2({
        placeholder: 'Selecionar a Disciplina',
        ajax: {
            url: url_origin + '/buscar/disciplinas',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_nome,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });



    $('.buscarAnoLetivo').select2({
        placeholder: 'Selecionar o ano lectivo',
        ajax: {
            url: url_origin + '/buscar/anoletivo',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.ya_inicio + '-' + item.ya_fim,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });



    $('.buscarDiasSemana').select2({
        placeholder: 'Selecionar o dia da semana',
        ajax: {
            url: url_origin + '/buscar/diasSemana',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                console.log('aqui', data)

                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.vc_dia,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
@isset($view_turma)
    <script>
        $('#id_curso').change(function() {
            var curso = $(this).find("option:selected").text();
            console.log(curso);
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
                    // $("#id_classe").append('<option value="">Selecciona a Classe</option>');


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
@else
    <script>
        $('#id_curso').change(function() {
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
                    // $("#id_classe").append('<option value="">Selecciona a Classe</option>');
                    $("#id_classe").append('<option value="Todas">Todas</option>');

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
@endisset

<script>
    $(".cand_para_aluno").on("click", function() {
        var id = $(this).attr('id_candidato');
        var url = "{{ url('/') }}";
        // alert(id);
        if (id) {
            $.ajax({
                type: 'GET',
                url: url + `/admin/candidatos/${id}/transferir`,
                success: function(data) {

                    if (data == 'candidato_transferido') {
                        $("#cnt" + id).html('Tranferido').addClass('text-green');
                        // $(`a[id_candidato='${id}'']`).hide();
                        $('a[id_candidato="' + id + '"]').remove();
                    }
                }
            });
        }

    });
</script>

<script>
    function limpar() {
        $("#id_turma").val("");
        $("#classe").val("");
        $("#curso").val("");
        $("#anoLectivo").val("");
        $("#nome-completo").val("");

        $("#processo").val("")
        $("#disciplina").val("")
    }
    $("#estudando").change(function() {
        $("#id-notas").empty();

        if ($(this).val() == "0") {
            $("#id-notas").append(
                '<div class="form-group col-md-4"><label>Nota seca:</label>' +
                '<input type="text" max="20" min="0" id="processo" value="0" class="form-control border-secondary  "' +
                ' placeholder="Digita a nota da seca" name="nota"> </div>');
        }

        $("#processo").attr('readonly', false);
        console.log("ola");
        limpar();
    });



    // $("#processo").on("keyup", function() {
    //     var processo = $(this).val();
    //     // var estudando = $("#estudando").val();
    //     // $("#turma").val();
    //     // $("#classe").val();
    //     // $("#curso").val();
    //     // $("#anoLectivo").val();
    //     // $("#nome-completo").val();

    //     $.ajax({
    //         type: 'GET',
    //         url: `aluno-processos/${processo}`,
    //         success: function(data) {
    //             console.log(data);

    //             $("#classe").val(data['processosAluno'].vc_classe);
    //             $("#curso").val(data['processosAluno'].vc_nomeCurso);
    //             $("#anoLectivo").val(data['processosAluno'].ya_fim + '-' + data['processosAluno']
    //                 .ya_inicio);
    //             $("#nome-completo").val(data['processosAluno'].vc_primeiroNome + ' ' + data[
    //                 'processosAluno'].vc_ultimoaNome);

    //             $("#disciplina").empty();
    //             console.log(data['disciplinas'].classe10);
    //             // data['disciplinas'].classe10.forEach(element => {
    //             //             console.log(element);
    //             data['disciplinas'].classe10.forEach(element => {
    //                 console.log(element);
    //             });
    //             $("#id-notas").append(
    //                 '<div class="form-group col-md-4"><label>Nota ' +
    //                 element +
    //                 'ª classe:</label>' +
    //                 '<input type="text" max="20" min="0" id="processo" value="0" class="form-control border-secondary  "' +
    //                 ' placeholder="Digita a nota da ' + element +
    //                 'ª classe" name="nota' + element + '"> </div>');

    //             // });
    //             $("#id_turma").empty();


    //             $("#id_turma").append('<option  value="' + data['processosAluno'].it_idTurma +
    //                 '">' + data['processosAluno'].vc_nomedaTurma +
    //                 '</option>');


    //             id - dados - aluno
    //         }
    //     });
    // });

    $("#disciplina").change(function() {
        var id_disciplina = $(this).val();
        var id_turma = $("#id_turma").val();
        var estado = $("#estudando").val();
        if (estado) {
            var classe = $("#classe").val();
            var processo = $("#processo").val();
            $.ajax({
                type: 'GET',
                url: `vrf_disciplina_terminal/${id_disciplina}/${id_turma}/${estado}/${processo}/${classe}`,
                success: function(data) {
                    $("#id-notas").empty();
                    console.log(data);
                    if (data.length === 0) {
                        Swal.fire(
                            'Aviso',
                            'Existe a possibilidade de o aluno não estar matriculado noutras classes, ou não ter essa disciplina noutras classes',
                            'warning'
                        );
                    } else {
                        data.forEach(element => {
                            console.log(element);

                            $("#id-notas").append(
                                '<div class="form-group col-md-4"><label>Nota ' +
                                element +
                                'ª classe:</label>' +
                                '<input type="text" max="20" min="0" id="processo" value="0" class="form-control border-secondary  "' +
                                ' placeholder="Digita a nota da ' + element +
                                'ª classe" name="nota' + element + '"> </div>');

                        });

                    }


                }
            });
        }
    });
</script>

<script>
    $("a[id^='tag']").on("click", function() {
        var id = $(this).attr('codigod');
        // alert(id);
        var url = "{{ url('/') }}";
        let id_int = parseInt(id);
        if (id_int) {
            $.ajax({
                type: 'GET',
                url: url + `/admin/pre_candidatos/${id_int}/admitir`,
                success: function(data) {
                    console.log(data);
                    if (data.state == 0) {
                        $("#NO" + data.id).html('Selecionado').addClass('text-green');
                        $(".p" + data.id).remove();
                    }
                }
            });
        }

    });
</script>

<script>
    $(".adimito-para-aluno").on("click", function() {
        //    alert($(this).attr('codigoD'));
        var id = $(this).attr('codigoD');
        let id_int = parseInt(id);
        var url = "{{ url('/') }}";
        //  alert(id_int);
        if (id_int) {
            // console.log('será'+id_int);
            $.ajax({
                type: 'GET',
                url: url + `/admin/selecionados/${id_int}/transferir`,
                success: function(data) {
                    console.log('opa' + data)

                    $("#nu" + id).html('Transferido').addClass('text-green');
                    $(".pre" + id).remove();
                    //console.log(data)

                }
            });
        }

    });
</script>

{{-- @php
vc_tipodaNota
    isst($vc_tipodaNota)
@endphp --}}
@isset($vc_tipodaNota)
    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
            Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
            Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico')
    @elseif($vc_tipodaNota == 'III')
        <script>
            var inputs = $(".nota2");
            for (let index = 0; index < inputs.length; index++) {
                var element = inputs[index];
                element.setAttribute("disabled", "true");
                element.setAttribute("hidden", "true");
            }
            var colsNota = $("#col-nota2").attr("hidden", "true");
        </script>
    @endif
@endisset
<script>
    function activadorNota(campo) {
        var inputs = $("." + campo);

        for (let index = 0; index < inputs.length; index++) {
            var element = inputs[index];
            // console.log(element);
            element.removeAttribute('readonly');
            // element.setAttribute("disabled", "false");


        }
    }
</script>
<script>
    var ordem = 1;
    $("#processo0").keyup(function() {

    });
    $("#maisCampoProcesso").click(function() {
        ordem = novoCampoProcesso(ordem + 1);
        ordem = ordem;
    });

    function novoCampoProcesso(ordem) {
        $("#camposProcesso").append(
            '<div class="col-md-12 row " id="caixa-aluno-' + ordem + '">' +
            '<div class="col-md-12 d-flex justify-content-end " id="x' + ordem +
            '" > <i class="fas fa-eraser delele-aluno" id="icon-delete-' + ordem + '"></i></div>' +
            '<div class="form-group col-md-6"><label>Processo</label>' +
            '<input type="text" id="ordemProcesso-' + ordem + '" name="ordemNota-' + ordem +
            '"  class="form-control border-secondary processoNotaRecurso  "' +
            ' placeholder="Digita o nº de processo"  > </div>' +
            '<div class="form-group col-md-6"><label>Nota</label>' +
            '<input type="text" max="20" min="0" step="0.01" id="ordemNota-' + ordem + '" name="ordemNota-' +
            ordem +
            '"  class="form-control border-secondary  "' +
            ' placeholder="Digita a nota"  >' +
            '</div><p class=" col-md-12" id="nome-' + ordem + '"></p> </div>');

        $(".processoNotaRecurso").keyup(function() {
            var atributo = $(this).attr('id');
            array = atributo.split("-");

            $(this).removeAttr('name');
            $("#ordemNota-" + array[1]).removeAttr('name');
            $(this).attr("name", "processo-" + $(this).val());
            $("#ordemNota-" + array[1]).attr("name", "notaProcesso-" + $(this).val());
            $(".processoNotaRecurso").on("keyup", function() {
                var processo = $(this).val();
                // alert(processo);
                // var url = window.location.origin + `/notas-recurso/aluno-processos/${processo}`;
                var url = "{{ url('/') }}" + `/notas-recurso/aluno-processos/${processo}`;
                $.ajax({
                    type: 'GET',
                    url: url,
                    success: function(data) {
                        console.log(data.processosAluno);
                        if (data.processosAluno) {
                            var nome = data.processosAluno.vc_primeiroNome + ' ' + data
                                .processosAluno.vc_apelido;
                            $("#nome-" + array[1]).empty();
                            $("#nome-" + array[1]).append(nome);
                        } else {
                            $("#nome-" + array[1]).empty('');
                        }
                    }
                });
            });
        });
        $(".delele-aluno").click(function() {
            var arrayIconDeleteSplit = $(this).attr('id').split('-');
            $("#caixa-aluno-" + arrayIconDeleteSplit[2]).remove();
        });
        return ordem;
    }

    $("#selectDisciplinaRecurso").change(function() {
        if ($(this).val() == "") {
            $("#camposProcesso").empty();
        } else if ($(this).val() != "") {
            $("#maisCampoProcesso").attr("hidden", false)
        }
    });
</script>

<script>
    $("#processo").on("keyup", function() {
        var processo = $(this).val();
        //    alert("ola");
        if (processo) {
            //var url = window.location.origin + `/aluno/${processo}`;
            var url = "{{ url('/') }}" + `/admin/aluno/${processo}`;
            // alert(url);
            $.ajax({
                type: 'GET',
                url: url,
                success: function(data) {
                    console.log(data);
                    $("#card_aluno").empty();
                    var selectTurmas = $('#id_turma');
                    selectTurmas.empty();


                    $("#card_aluno").append(`
                   <img class="card-img-top" src="/${data.aluno.vc_imagem}" alt="Card image cap">
                    <div class="card-body">
                   <h5 class="card-title">Nome:${data.aluno.vc_primeiroNome}
                    ${data.aluno.vc_nomedoMeio?data.aluno.vc_nomedoMeio:''} ${data.aluno.vc_apelido}</h5>
                   <p class="card-text">Curso: ${data.aluno.vc_shortName}</p>
              
               </div>
                `);


                    // Percorre o array de turmas e adiciona cada uma como uma opção no select
                    $.each(data.turmas, function(index, turma) {
                        if (turma.it_qtdeAlunos - turma.it_qtMatriculados > 0) {
                            var option = $('<option>', {
                                value: turma.id,
                                text: `${turma.vc_nomedaTurma}/${turma.vc_classe}ª classe/${turma.vc_nomeCurso}/${turma.vc_turnoTurma}(${turma.ya_inicio}/${turma.ya_fim})`
                            });
                            selectTurmas.append(option);
                        }
                    });
                    // console.log(data.aluno);
                    // // let nome = imagePath
                    // alert(data)
                    // let image = document.getElementById("imageoption").src = "/" + data;
                    // // $request
                    // $("#input-file").attr("value", data);
                    // attr("value", data);

                }
            });
        }
    });
</script>

<script>
    $("#tipo_pagamento").on("change", function() {
        var tipo = $(this).val();
        //    alert("ola");
        var inputs = $(".box-hidden");
        if (tipo == 'Mensalidades') {
            for (let index = 0; index < inputs.length; index++) {
                var element = inputs[index];
                // console.log(element);
                element.removeAttribute("hidden");
            }
        } else {
            for (let index = 0; index < inputs.length; index++) {
                var element = inputs[index];
                // console.log(element);
                element.hidden = true;
            }

        }

    });
</script>
<script>
    function dataConfirmDelete() {
        $('a[data-confirm]').click(function(ev) {
            var href = $(this).attr('href');
            if (!$('#confirm-delete').length) {
                $('table').append(
                    '<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"> <div class="modal-header"> <h5 class="modal-title" id="exampleModalLabel">Eliminar os dados</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">Tem certeza que pretende eliminar?</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button> <a  class="btn btn-info" id="dataConfirmOk">Eliminar</a> </div></div></div></div>'
                );
            }
            $('#dataConfirmOk').attr('href', href);
            $('#confirm-delete').modal({
                shown: true
            });
            return false;

        })
    };
</script>
@if (session('feedback'))


    @if (isset(session('feedback')['status']))
        <script>
            Swal.fire(
                '{{ session('feedback')['sms'] }}',
                '',
                'success'
            )
        </script>
    @endif

    @if (isset(session('feedback')['error']))
        <script>
            Swal.fire(
                '{{ session('feedback')['sms'] }}',
                '',
                'error'
            )
        </script>
    @endif
@endif
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

    @if (isset(session('feedback')['error']))
        <script>
            Swal.fire(
                '{{ session('feedback')['sms'] }}',
                '',
                'error'
            )
        </script>
    @endif
@endif


<script>
    $(document).ready(function() {
        $('.js-example-basic-multiple-faltas').select2({
            placeholder: "Seleccione as disciplinas",
            maximumSelectionLength: 3

        });
    });
</script>
<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2({
            placeholder: "Seleccione uma opção"
        });
    });
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
    $("#dt_limiteaesquerda").change(function() {
        // var dataNascimento = $(this).val();
        var dataNascimento = new Date($(this).val());
        // alert(dataNascimento);
        // Obter a data atual
        var dataAtual = new Date();

        // Calcular a diferença entre as datas em milissegundos
        var diferencaTempo = dataAtual - dataNascimento;

        // Converter a diferença em anos
        var idade = Math.floor(diferencaTempo / (1000 * 60 * 60 * 24 * 365.25));
        console.log(idade, "ol");
        $("#dt_limiteaesquerda_span").text(idade + ' anos');
        // console.log(idade,"ol");
    });
</script>

<script>
    $("#dt_limitemaxima").change(function() {
        // var dataNascimento = $(this).val();
        var dataNascimento = new Date($(this).val());
        // alert(dataNascimento);
        // Obter a data atual
        var dataAtual = new Date();

        // Calcular a diferença entre as datas em milissegundos
        var diferencaTempo = dataAtual - dataNascimento;

        // Converter a diferença em anos
        var idade = Math.floor(diferencaTempo / (1000 * 60 * 60 * 24 * 365.25));
        console.log(idade, "ol");
        $("#dt_limitemaxima_span").text(idade + ' anos');
        // console.log(idade,"ol");
    });
</script>
<script>
    $(document).ready(function() {
        $('.mySelect').select2();
    });
</script>

{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" /> --}}

{{-- <style>
@media (max-width: 767px) {
    .table-responsive{
        overflow-x: auto;
        overflow-y: auto;
    }
}
@media (min-width: 767px) {
    .table-responsive{
        overflow: inherit !important; /* Sometimes needs !important */
    }
}

</style> --}}
<script>
    $(document).on('shown.bs.dropdown', '.table-responsive', function(e) {
        // The .dropdown container
        var $container = $(e.target);

        // Find the actual .dropdown-menu
        var $dropdown = $container.find('.dropdown-menu');
        if ($dropdown.length) {
            // Save a reference to it, so we can find it after we've attached it to the body
            $container.data('dropdown-menu', $dropdown);
        } else {
            $dropdown = $container.data('dropdown-menu');
        }

        $dropdown.css('top', ($container.offset().top + $container.outerHeight()) + 'px');
        $dropdown.css('left', $container.offset().left + 'px');
        $dropdown.css('position', 'absolute');
        $dropdown.css('display', 'block');
        $dropdown.appendTo('body');
    });

    $(document).on('hide.bs.dropdown', '.table-responsive', function(e) {
        // Hide the dropdown menu bound to this button
        $(e.target).data('dropdown-menu').css('display', 'none');
    });
</script>

@if(Request::url() === url('/'))
<script>
  
    var url_origem = "{{ url('/') }}";
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url_origin + '/alunos_por_classes',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function(response) {
            console.log(response);
            var barChartData = {
                labels: response.classes,
                datasets: [{
                    label: 'Gráfico de Barras',
                    data: response.matriculados,
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            };
            new Chart(document.getElementById('bar-chart'), {
                type: 'bar',
                data: barChartData,
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url_origin + '/alunos_por_turmas',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function(response) {
            console.log(response);
            var pieChartData = {
                labels: response.turmas,
                datasets: [{
                    label: 'Gráfico de Pizza',
                    data: response.matriculados,
                    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            new Chart(document.getElementById('pie-chart'), {
                type: 'pie',
                data: pieChartData
            });
        }
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url_origin + '/candidatos_por_ano_lectivo',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function(response) {
            console.log(response);
            var lineChartData = {
                labels: response.anos_lectivos,
                datasets: [{
                    label: 'Gráfico de Linhas',
                    data: response.candidatos,
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderWidth: 1
                }]
            };
            new Chart(document.getElementById('line-chart'), {
                type: 'line',
                data: lineChartData
            });
        }
    });
    $.ajax({
        type: 'GET',
        dataType: 'json',
        url: url_origin + '/alunos_por_cursos',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        async: false,
        success: function(response) {
            console.log(response);
            var polarAreaChartData = {
                labels:response.cursos,
                datasets: [{
                    label: 'Gráfico de Área Polar',
                    data: response.alunos,
                    backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                        'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)',
                        'rgba(153, 102, 255, 0.5)'
                    ],
                    borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                    ],
                    borderWidth: 1
                }]
            };
            new Chart(document.getElementById('polar-area-chart'), {
                type: 'polarArea',
                data: polarAreaChartData
            });
        }
    });
 
</script>

@endif
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


</body>

</html>

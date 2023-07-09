<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('titulo')</title>
    {{-- Favicons --}}
    <link href="{{ asset('/' . $caminhoLogo) }}" rel="icon">
    {{-- EndFavicons --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('/css/ionicons.min.css') }}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet"
        href="{{ asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{ asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{ asset('/plugins/jqvmap/jqvmap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="{{ asset('/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
    <!-- Daterange picker -->
    {{-- <link rel="stylesheet" href="{{ asset('/plugins/da terangepicker/daterangepicker.css') }}"> --}}
    <!-- summernote -->
    {{-- <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}"> --}}

    <link rel="stylesheet" href="{{ asset('/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/select2-bootstrap4.css') }}">

    {{-- <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}"> --}}

    <!-- Google Font: Source Sans Pro -->
    {{-- <link href="{{ asset('/css/fontfamily.css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet"> --}}
    <link rel="stylesheet" href="{{ asset('/css/datatables/dataTables.bootstrap4.min.css') }}">
    {{-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"> <!-- Adicione o link da fonte personalizada aqui --> --}}

    {{-- Gráficos --}}
    {{--  --}}
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('/graficos/chart.min.css') }}">
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('css/select-2.css') }}">

 
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light d-flex flex-row flex-wrap">
            <!-- Left navbar links -->
            <ul class="navbar-nav mt-1">
                <li class="nav-item ">
                    <div class="nav-item-user">
                        School management: {{ fh_cabecalho()->vc_escola }}
                    </div>
                </li>
            </ul>
            <!-- Start Right navbar links -->
            <ul class="navbar-nav ml-auto d-flex flex-row flex-wrap mt-1">
                <!-- itens a direita do menu -->
{{-- @dump($ano_lectivo_publicado) --}}
                {{-- <li class="nav-item ">
                    <div class="nav-item-user">
                        School management: {{ fh_cabecalho()->vc_escola }}
                    </div>
                </li> --}}
                @isset($ano_lectivo_publicado)
                    <li class="nav-item ">
                        <div class="nav-item-user">
                            {{ $ano_lectivo_publicado }}
                        </div>
                    </li>
                    <li class="nav-item ">


                        <div class="nav-item-user dropbtn ">
                            <div class="dropdown">
                                <div class="dropbtn">
                                    {{ obter_iniciais(Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido) }}
                                </div>
                                <div class="dropdown-content card ">
                                    <div class="container  d-flex justify-content-center">

                                        <div class="">

                                            <div class="d-flex align-items-center">

                                                <div>
                                                    <img src="https://images.unsplash.com/photo-1522075469751-3a6694fb2f61?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=500&q=80"
                                                        class="rounded" width="155">
                                                </div>

                                                <div class="ml-3 w-100">

                                                    <h4 class="mb-0 mt-0 text-dark">
                                                        {{ Auth::user()->vc_primemiroNome . ' ' . Auth::user()->vc_apelido }}
                                                    </h4>
                                                    <span class="text-dark">{{ Auth::user()->vc_email }}</span>
                                                    <br>
                                                    <span class="text-dark">{{ Auth::user()->vc_tipoUtilizador }}</span>




                                                    <div class="button mt-2 d-flex flex-row align-items-center">

                                                        <a class="btn btn-sm btn-outline-primary w-100">Editar perfil</a>
                                                        <a class="btn btn-sm btn-primary w-100 ml-2"
                                                            href="{{ route('logout') }}"
                                                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Sair</a>


                                                        <form id="logout-form" action="{{ route('logout') }}"
                                                            method="POST">
                                                            @csrf
                                                        </form>
                                                    </div>


                                                </div>


                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </li>
                 
                    <li class="nav-item ml-1 d-flex align-items-center">
                        <a class="nav-link img-circle  bg-danger" data-widget="pushmenu" href="#" role="button"><i
                                class="right fas fa-angle-left"></i></a>
                    </li>
                    {{-- <li class="nav-item ">


                        <a class="nav-link text-info container-fluid">
                            Ano lectivo publicado: {{ $ano_lectivo_publicado }}

                        </a>
                    </li> --}}
                @endisset
                {{-- <li class="nav-item ">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Terminar a Sessão
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li> --}}

                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                </form>
                <!-- End itens a direita do menu -->

            </ul>
        </nav>
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @if (null !== Auth::user())
            {{-- @dump($id_anoLectivo,$ano_lectivo); --}}
            {{-- @dump(isset(session('ano_lectivo')['0']['ano_lectivo'])?session('ano_lectivo')['0']['id']:'AVATAR') --}}
            <aside class="main-sidebar  elevation-4" style="background: white">
                <!-- Brand Logo -->

                <!-- Sidebar -->
                <div class="sidebar">

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-header box-li-sidebar d-flex ">
                                <a href="{{ url('/') }}" class="nav-link w-75">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Dashboard

                                    </p>
                                </a>
                                <a class="nav-link img-circle  w-25  " data-widget="pushmenu" href="#" role="button">
                                    <i
                                    class="right fas fa-angle-left mt-1 " ></i>
                                </a>
                            </li>

                            <li class="nav-item has-treeview ">

                                @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                        Auth::user()->vc_tipoUtilizador == 'RH' ||
                                        Auth::user()->vc_tipoUtilizador == 'Visitante' ||
                                        Auth::user()->vc_tipoUtilizador == 'Visitante' ||
                                        Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                                        Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico')
                            <li class="nav-header">Mod. de Gestão de Participantes</li>
                            <li class="nav-item has-treeview ">
                                <a href="{{ url('admin/users/listar') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Utilizadores

                                    </p>
                                </a>


                            </li>
                            <li class="nav-item has-treeview ">
                                <a href="{{ route('admin.funcionarios.listar') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Funcionários

                                    </p>
                                </a>




                            </li>
                            <li class="nav-item has-treeview ">
                                <a href="{{ route('admin.funcionarios.listar') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Cartão


                                    </p>
                                </a>
                            <li class="nav-item has-treeview ">
                                <a href="{{ url('admin/logs/pesquisar') }}" class="nav-link ">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Logs do Sistema

                                    </p>
                                </a>

                            </li>
        @endif





        @if (Auth::user()->vc_tipoUtilizador == 'Comissão' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                Auth::user()->vc_tipoUtilizador == 'Preparador' ||
                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-header">Mód. de Gestão de Matrículas</li>

            <li class="nav-item has-treeview ">
                <a href="{{ url('candidatos/pesquisar') }}" class="nav-link ">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Candidatos

                    </p>
                </a>

            <li class="nav-item has-treeview ">
                <a href="{{ url('admin/alunos/pesquisar') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Alunos

                    </p>
                </a>

            </li>

            </li>


            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Matriculas

                    </p>
                </a>
                <ul class="nav nav-treeview">

                    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                        <li class="nav-item">
                            <a href="{{ url('Admin/matriculas/cadastrar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Matricular Aluno</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('Admin/matriculas/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lista de Matriculados</p>
                        </a>
                    </li>





                </ul>
            </li>
            <li class="nav-item has-treeview ">
                <a href="{{ route('admin.alunos.importar') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Importar

                    </p>
                </a>
            </li>


            <li class="nav-item has-treeview ">

                @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                    <a href="{{ url('/admin/cartaoaluno') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Cartão

                        </p>
                    </a>
                @endif

            </li>



            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                <li class="nav-item has-treeview ">

{{-- 
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Ano validade de cartão

                        </p>
                    </a> --}}

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('anos-validade-cartao.criar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cadastrar </p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('anos-validade-cartao') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Listar </p>
                            </a>
                        </li>

                    </ul>
                </li>
            @endif


        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-header">Mod. de Gestão de Listas</li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Listas

                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ url('Admin/candidaturas/pesquisar/imprimir') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Candidatos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('Admin/candidatos/aceitos/pesquisar/imprimir') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Candidatos Aceitos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/matriculas/pesquisar_pdf') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Matriculados</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('admin/funcionarios/listas/imprimir') }}" class="nav-link" target="_blank">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Funcionários</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('listas.propinas_turmas.pesquisar') }}" class="nav-link" target="_blank">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Propinas(Turma)</p>
                        </a>
                    </li>

                </ul>
            </li>
        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-header">Mod. de Gestão de Relatórios</li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Relatórios

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('relatorios.candidaturas.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Candidatura</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('relatorios.candidatos_aceitos.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Candidatos Aceitos</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ route('relatorios.matriculados.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Matriculas</p>
                        </a>
                    </li>


                </ul>
            </li>
        @endif




        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-header">Mod. de Relatórios
                de Propinas
            </li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Relatórios

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('relatorios.propinas.alunos.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Por Alunos</p>
                        </a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="{{ route('relatorios.candidaturas.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p> Em Atraso</p>
                        </a>
                    </li> --}}


                </ul>
            </li>
        @endif




        @if (acc_admin_desenvolvedor())
            <li class="nav-header">Mod. de Configuração P.A.E</li>

            <li class="nav-item has-treeview">
                <a href="{{ route('admin.provincia') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Províncias

                    </p>
                </a>

            </li>

            <li class="nav-item has-treeview">
                <a href="{{ route('admin.municipio') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Municipio

                    </p>
                </a>

            </li>


            <li class="nav-item has-treeview">
                <a href="{{ url('admin/escola') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Escola

                    </p>
                </a>

            </li>
        @endif
























        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica'
                ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header"> Mod. de Recuperação(Aluno)</li>

            <li class="nav-item has-treeview">
                <a href="{{ route('admin.notas-recurso.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Notas(Recurso/Exame)

                    </p>
                </a>

            </li>
        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header">Mod. de Configuração de Pauta</li>
            <li class="nav-item has-treeview">
                <a href="{{ route('configuracoes.pautas.n_negativas') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                       Nº de Negativas

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('configuracoes.pautas.disciplinas_exames') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                       Disciplinas de Exame

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('configuracoes.pautas.pesos_notas_exames') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                       Pesos de notas(Exames)

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('configuracoes.pautas.criterio_disciplinas') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                      Critério de Disciplina

                    </p>
                </a>

            </li>
        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header">Mod. de Configuração básica</li>
            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/anolectivo') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Anos Lectivo

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('inicio-termino-ano-lectivo') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Início-Fim(Ano Lectivo)

                    </p>
                </a>

            </li>



            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/idadedecandidatura') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Idades de admissão

                    </p>
                </a>

            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('admin/cadeado_candidatura') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Cadeado de Candidatura
                    </p>
                </a>

            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('Admin/cursos/index/index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Cursos

                    </p>
                </a>

            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('Admin/processos/index/index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Processo Atual

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/classes') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Classes

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ url('disciplina/ver') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Disciplinas

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('admin.disciplina_curso_classe') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Disciplina\Curso\Classe

                    </p>
                </a>

            </li>
        @endif



        @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header">Mod. de Gestão de Turmas</li>

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Turmas

                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ url('turmas/cadastrar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Turma</p>
                        </a>
                    </li>



                    <li class="nav-item">
                        <a href="{{ url('/turmas/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lista de Turmas</p>
                        </a>
                    </li>


                </ul>


            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('direitores-turmas.index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Director de Turma

                    </p>
                </a>

            </li>
        @endif
        @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                Auth::user()->vc_tipoUtilizador == 'Professor')
            <li class="nav-item has-treeview ">
                <a href="{{ route('admin.atribuicoes.pesquisar') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Turmas(Professores)


                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('direitores-turmas.meus') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Turmas (Diretor)

                    </p>
                </a>

            </li>
        @endif





        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header"> Mod. de Pagamentos</li>

            <li class="nav-item has-treeview">
                <a href="{{ route('tipos-pagamento') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Tipo de Pagamento

                    </p>
                </a>

            </li>
            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Pagamento

                    </p>
                </a>
                <ul class="nav nav-treeview">


                    <li class="nav-item">
                        <a href="{{ route('pagamentos.pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Pesquisar</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pagamentos.filtrar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar Pagamentos</p>
                        </a>
                    </li>





                </ul>
            </li>
        @endif

        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
        Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
    <li class="nav-header"> Mod. de Documentos</li>
    <li class="nav-item has-treeview">
        <a href="{{route('admin.documentos.componentes')}}" class="nav-link">
              <i class="nav-icon fas fa-chalkboard"></i>
            <p>
                Componete
               
            </p>
        </a>
    </li>
    <li class="nav-item has-treeview">
        <a href="{{route('admin.documentos.componentes-disciplinas')}}" class="nav-link">
              <i class="nav-icon fas fa-chalkboard"></i>
            <p>
                Componete disciplina
               
            </p>
        </a>
    </li>
    <li class="nav-item has-treeview">
        <a href="{{route('admin.documentos.infos_certificado')}}" class="nav-link">
              <i class="nav-icon fas fa-chalkboard"></i>
            <p>
                Info. Certificados
               
            </p>
        </a>
    </li>
    
    <li class="nav-item has-treeview">
        <a href="{{route('documentos.certificados.emitir')}}" class="nav-link">
            <i class="nav-icon fas fa-chalkboard"></i>
            <p>
                Certificado
            
            </p>
        </a>
    </li>
        
    <li class="nav-item has-treeview">
        <a href="{{route('documentos.declaracoes.emitir')}}" class="nav-link">
            <i class="nav-icon fas fa-chalkboard"></i>
            <p>
                Declaração 
            
            </p>
        </a>
    </li>
@endif


        </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    </aside>
    @endif

    <script src="{{ asset('/js/sweetalert2.all.min.js') }}"></script>
    @if (session('url_404'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'URL não encontrada com',
            })
        </script>
    @endif
    @if (session('error_limite_requisicao'))
        <script>
            Swal.fire({
                icon: 'info',
                title: 'Ocorreu uma paragem, persiste em  enviar os dados!',
            })
        </script>
    @endif

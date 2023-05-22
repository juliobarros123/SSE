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
    <link rel="stylesheet" href="{{ asset('/plugins/daterangepicker/daterangepicker.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">

    <link rel="stylesheet" href="{{ asset('/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('/css/select2-bootstrap4.css') }}">

    <link rel="stylesheet" href="{{ asset('/plugins/summernote/summernote-bs4.css') }}">

    <!-- Google Font: Source Sans Pro -->
    <link href="{{ asset('/css/fontfamily.css?family=Source+Sans+Pro:300,400,400i,700') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('/css/datatables/dataTables.bootstrap4.min.css') }}">

    {{-- Gráficos --}}
    {{--  --}}
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('/graficos/chart.min.css') }}">
    <style>
        canvas {
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link img-circle  bg-danger" data-widget="pushmenu" href="#" role="button"><i
                            class="right fas fa-angle-left"></i></a>
                </li>
            </ul>
            <!-- Start Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- itens a direita do menu -->

                <li class="nav-item ">
                    <div class="nav-item-user">
                        School management: {{ fh_cabecalho()->vc_escola }}
                    </div>
                </li>
                @isset($ano_lectivo_publicado)
                    <li class="nav-item ">
                        <div class="nav-item-user">
                            {{ $ano_lectivo_publicado }}
                        </div>
                    </li>
                    <li class="nav-item ">


                        <div class="nav-item-user dropbtn ">
                            <div class="dropdown">
                                <div class="dropbtn">JB</div>
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
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->

                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->



                    <!-- Sidebar Menu -->

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                            data-accordion="false">
                            <li class="nav-header box-li-sidebar ">
                                <a href="{{ url('/') }}" class="nav-link">
                                    <i class="nav-icon fas fa-user"></i>
                                    <p>
                                        Dashboard

                                    </p>
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
                            <li class="nav-header">Utilizadores</li>
                            <li class="nav-item has-treeview ">
                                <a href="{{ url('admin/users/listar') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Utilizadores

                                    </p>
                                </a>

                                {{-- <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('admin/users/cadastrar') }}" class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Utilizador</p>
                                                </a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a href="{{ url('admin/users/listar') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Utilizadores</p>
                                            </a>
                                        </li>

                                    </ul> --}}
                            </li>

                            <li class="nav-header"> Funcionários</li>
                            <li class="nav-item has-treeview ">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Funcionários

                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    {{-- @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('/admin/funcionario/cadastrar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-dot-circle nav-icon"></i>
                                                    <p>Cadastrar</p>
                                                </a>
                                            </li>
                                        @endif --}}
                                    <li class="nav-item">
                                        <a href="{{ route('admin.funcionarios.listar') }}" class="nav-link">
                                            <i class="far fa-dot-circle nav-icon"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>
                                    @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/funcionarios') }}" class="nav-link">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Emissão de Cartão</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('admin/funcionarios/listas/imprimir') }}"
                                                class="nav-link" target="_blank">
                                                <i class="far fa-dot-circle nav-icon"></i>
                                                <p>Imprimir Listas</p>
                                            </a>
                                        </li>
                                    @endif


                                </ul>
                            <li class="nav-item has-treeview ">
                                <a href="{{ url('admin/atribuicoes/listar') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Professores-Turmas


                                    </p>
                                </a>
                                {{-- <ul class="nav nav-treeview">

                                         @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('admin/atribuicoes/cadastrar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Atribuir Turma</p>
                                                </a>
                                            </li>
                                        @endif 
                                         <li class="nav-item">
                                            <a href="{{ url('admin/atribuicoes/listar') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Atribuições</p>
                                            </a>
                                        </li> 
                                    </ul> --}}
                            </li>



                            </li>
                            <li class="nav-header">Registros de Actidades</li>
                            <li class="nav-item has-treeview ">
                                <a href="{{ url('admin/logs/pesquisar') }}" class="nav-link ">
                                    <i class="nav-icon fas fa-chalkboard"></i>
                                    <p>
                                        Registros

                                    </p>
                                </a>
                                {{-- <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{ url('admin/logs/pesquisar') }}" class="nav-link ">
                                            <i class="nav-icon fas fa-chalkboard"></i>
                                            <p>Registros de Actividades</p>
                                        </a>
                                    </li>


                                </ul> --}}
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
            <li class="nav-header">Candidatos</li>

            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link ">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Candidatos

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (Auth::user()->vc_tipoUtilizador == 'Director Geral')
                        <li class="nav-item">
                            <a href="{{ url('admin/candidatos/filtro') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Candidatos</p>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                            Auth::user()->vc_tipoUtilizador == 'Comissão' ||
                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                            Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                            Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                            Auth::user()->vc_tipoUtilizador == 'Visitante')
                        <li class="nav-item">
                            <a href="{{ url('candidatos/pesquisar') }}" class="nav-link ">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Candidatos</p>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a href="{{ url('Admin/pesquisarCandidaturas') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Imprimir Lista</p>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                    Auth::user()->vc_tipoUtilizador == 'Comissão' ||
                    Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                    Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                    Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                    Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                    Auth::user()->vc_tipoUtilizador == 'Visitante')


                <li class="nav-item has-treeview ">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Selecção de Candidatos

                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        @if (Auth::user()->vc_tipoUtilizador == 'Director Geral')
                            <li class="nav-item">
                                <a href="{{ url('admin/admitidos/filtro') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Admitidos</p>
                                </a>
                            </li>
                        @endif
                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                                Auth::user()->vc_tipoUtilizador == 'Comissão' ||
                                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                                Auth::user()->vc_tipoUtilizador == 'Visitante')

                            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                <li class="nav-item">
                                    <a href="{{ url('admin/candidatos/selecionar') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Selecionar manualmente</p>
                                    </a>
                                </li>
                            @endif

                            <li class="nav-item">
                                <a href="{{ url('admin/selecionados/pesquisar') }}" class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Lista de Admitidos</p>
                                </a>
                            </li>


                            <li class="nav-item">
                                <a href="{{ route('admin.ListadSelecionado.pesquisar_selecionados') }}"
                                    class="nav-link">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Imprimir Lista</p>
                                </a>
                            </li>
                        @endif
                    </ul>


                </li>
            @endif
            <li class="nav-header">Alunos</li>
            <li class="nav-item has-treeview ">
                <a href="{{ route('admitido') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Adicionar aluno

                    </p>
                </a>
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
                        <a href="{{ url('Admin/pesquisarMatriculados') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lista de Matriculados</p>
                        </a>
                    </li>




                    <li class="nav-item">
                        <a href="{{ url('admin/matriculas/pesquisar_pdf') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Imprimir Lista</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Alunos

                    </p>
                </a>
                <ul class="nav nav-treeview">

                    <li class="nav-item">
                        <a href="{{ url('admin/alunos/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lista de Alunos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('Admin/pesquisarSelecionados') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Imprimir Lista</p>
                        </a>
                    </li>

                </ul>
            </li>


            <li class="nav-item has-treeview ">

                @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Emissão de Cartão

                        </p>
                    </a>
                @endif
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('/admin/cartaoaluno') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cartão de Aluno</p>
                        </a>
                    </li>

                </ul>
            </li>



            @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                <li class="nav-item has-treeview ">


                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Ano validade de cartão

                        </p>
                    </a>

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

        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->

        <!-- @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                Auth::user()->vc_tipoUtilizador == 'Preparador' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
<li class="nav-header">Diplomados</li>
                                <li class="nav-item has-treeview ">
                                    <a href="#" class="nav-link ">
                                        <i class="nav-icon fas fa-user-plus"></i>
                                        <p>
                                            Diplomados
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
<li class="nav-item">
                                                <a href="{{ route('admin.diplomados.cadastrar') }}"
                                                    class="nav-link ">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Diplomado</p>
                                                </a>
                                            </li>
@endif

                                        <li class="nav-item">
                                            <a href="{{ route('admin.diplomados.listar') }}" class="nav-link ">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Diplomados</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.diplomados.imprimir') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Imprimir Lista</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
@endif  -->

        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Gabinete Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-header">Relatórios Estatísticos</li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Relatórios

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ url('Admin/pesquisarRec') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Candidatura</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('Admin/pesquisarRes') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Selecção de Candidatos</p>
                        </a>
                    </li>

                    {{-- <li class="nav-item">
                                            <a href="{{ url('Admin/pesquisarRem') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Matriculas/Alunos</p>
                                            </a>
                                        </li> --}}
                    <li class="nav-item">
                        <a href="{{ url('Admin/relatorio/matricula/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Matriculas/Alunos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('Admin/pesquisar_alunos') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Alunos</p>
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
            <li class="nav-header">Estatística</li>
            {{-- <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">

                                <i class="nav-icon fas fa-bolt"></i>
                                <p>
                                    Notas
                                    
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{ url('estatisticas/nota') }}" class="nav-link">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Ver</p>
                                    </a>
                                </li>



                            </ul>
                        </li> --}}

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>

                    <p>
                        Quadro de honra


                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('admin.quadros.honra') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Ver</p>
                        </a>
                    </li>



                </ul>
            </li>
        @endif
        <li class="nav-header">Dependências do sistema</li>
        @if (acc_admin_desenvolvedor())
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
        @endif
        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Preparador' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/anolectivo') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Anos Lectivo

                    </p>
                </a>
                {{--   <ul class="nav nav-treeview">

                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('/admin/anolectivo/cadastrar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Ano Lectivo</p>
                                                </a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a href="{{ url('/admin/anolectivo') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista dos Anos Lectivos</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('admin/escola') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Escola

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">



                                        <li class="nav-item">
                                            <a href="{{ url('admin/escola') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista escola</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/idadedecandidatura') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Idades de Candidatura

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">

                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('/admin/idadedecandidatura/cadastrar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Idade</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/idadedecandidatura') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Idades</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('admin/cadeado_candidatura') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Cadeado de Candidatura
                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href="{{ url('/admin/cadeado_candidatura') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Chave</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                Auth::user()->vc_tipoUtilizador == 'Preparador' ||
                Auth::user()->vc_tipoUtilizador == 'Visitante')
            <li class="nav-item has-treeview">
                <a href="{{ url('Admin/cursos/index/index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Cursos

                    </p>
                </a>
                {{--  <ul class="nav nav-treeview">

                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('Admin/cursos/create/index') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Curso</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ url('Admin/cursos/index/index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Cursos</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ url('Admin/processos/index/index') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Processo Atual

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">


                                        @if (Auth::user()->vc_tipoUtilizador != 'Visitante')
                                            <li class="nav-item">
                                                <a href="{{ url('Admin/processos/create/index') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Processo</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ url('Admin/processos/index/index') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Processos</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif

        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Nota|Idade|Candidatura

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                            Auth::user()->vc_tipoUtilizador == 'Preparador')
                        {{-- <li class="nav-item">
                                                <a href="{{ route('permissao_selecao.criar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar</p>
                                                </a>
                                            </li> --}}
                        <li class="nav-item">
                            <a href="{{ url('admin/permissao_selecao/index/index') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Permissões</p>
                            </a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                                        <a href="{{ route('admin.disciplina_curso_classe') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Disciplinas Relacionadas</p>
                                        </a>
                                    </li> --}}

                </ul>
            </li>

        @endif

        @if (Auth::user()->vc_tipoUtilizador != 'Professor')
            <li class="nav-item has-treeview">
                <a href="{{ url('/admin/classes') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Classes

                    </p>
                </a>
                {{--  <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                            <li class="nav-item">
                                                <a href="{{ url('/admin/classes/cadastrar') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Cadastrar Classe</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ url('/admin/classes') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Classes</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif


        @if ($coordenador_turno_composer->where('id_user', Auth::id())->count())
            <li class="nav-item has-treeview ">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard-teacher"></i>
                    <p>
                        Professores-Turno


                    </p>
                </a>
                <ul class="nav nav-treeview">


                    <li class="nav-item">
                        <a href="{{ url('professores_turno/consultar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Consultar</p>
                        </a>
                    </li>


                </ul>
            </li>
        @endif
        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                    Turmas

                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                        Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                        Auth::user()->vc_tipoUtilizador == 'Preparador')
                    <li class="nav-item">
                        <a href="{{ url('turmas/cadastrarTurmas') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar Turma</p>
                        </a>
                    </li>
                @endif

                @if ($coordenadorCurso->where('id_user', Auth::id())->count())
                    <li class="nav-item">
                        <a href="{{ route('coordernadores_cursos.pesquisar_turmas') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Como coordenador</p>
                        </a>
                    </li>
                @endif

                @if ($director_turma_composer->where('id_user', Auth::id())->count())
                    <li class="nav-item">
                        <a href="{{ route('direitor-turma.consultar_turmas') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Como director</p>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->vc_tipoUtilizador == 'Professor' || Auth::user()->vc_tipoUtilizador == 'Administrador')
                    @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                        <li class="nav-item">
                            <a href="{{ route('turmas.professor', Auth::user()->id) }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Turmas</p>
                            </a>
                        </li>
                    @endif
                    @if (Auth::user()->vc_tipoUtilizador != 'Professor')
                        <li class="nav-item">
                            <a href="{{ route('admin.turmas.pesquisar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Lista de Turmas</p>
                            </a>
                        </li>
                    @endif
                @else
                    <li class="nav-item">
                        <a href="{{ url('/turmas/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Lista de Turmas</p>
                        </a>
                    </li>



                @endif

            </ul>
        </li>

        @if (Auth::user()->vc_tipoUtilizador != 'Professor')
            <li class="nav-item has-treeview">
                <a href="{{ route('admin.viewListarDireitores') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Director de Turma

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                            <li class="nav-item">
                                                <a href="{{ url('/direitor-turma/cadastrarDireitor') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Atribuir Director</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route('admin.viewListarDireitores') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Directores</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif



        <li class="nav-item has-treeview">
            <a href="{{ url('disciplina/ver') }}" class="nav-link">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                    Disciplinas

                </p>
            </a>
            {{--  <ul class="nav nav-treeview">
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                        <li class="nav-item">
                                            <a href="{{ url('disciplina') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Disciplina</p>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ url('disciplina/ver') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Lista das Disciplinas</p>
                                        </a>
                                    </li>

                                </ul> --}}
        </li>







        <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                    Coordenador|Curso

                </p>
            </a>
            <ul class="nav nav-treeview">
                @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                        Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                        Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                        Auth::user()->vc_tipoUtilizador == 'Preparador')
                    <li class="nav-item">
                        <a href="{{ url('coordernadores_cursos/criar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('coordernadores_cursos') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                @endif
                @if (Auth::user()->vc_tipoUtilizador == 'Professor')
                    <li class="nav-item">
                        <a href="{{ url('coordernadores_cursos/meus_coordenadores') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar</p>
                        </a>
                    </li>
                @endif
            </ul>
        </li>


        <li class="nav-item has-treeview">
            <a href="{{ url('coordernadores_turno') }}" class="nav-link">
                <i class="nav-icon fas fa-chalkboard"></i>
                <p>
                    Coordenador|Turno

                </p>
            </a>
            {{-- <ul class="nav nav-treeview">
                                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                        <li class="nav-item">
                                            <a href="{{ url('coordernadores_turno/criar') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar</p>
                                            </a>
                                        </li>
                                    @endif
                                    <li class="nav-item">
                                        <a href="{{ url('coordernadores_turno') }}" class="nav-link">
                                            <i class="far fa-circle nav-icon"></i>
                                            <p>Listar</p>
                                        </a>
                                    </li>

                                </ul> --}}
        </li>

        @if (Auth::user()->vc_tipoUtilizador != 'Professor')
            <li class="nav-item has-treeview">
                <a href="{{ route('admin.disciplinaTerminal.list.get') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Disciplinas Terminais

                    </p>
                </a>
                {{--                                     <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                            <li class="nav-item">
                                                <a href="{{ route('admin.disciplinaTerminal.criar.get') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Relacionar</p>
                                                </a>
                                            </li>
                                        @endif
                                        <li class="nav-item">
                                            <a href="{{ route('admin.disciplinaTerminal.list.get') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif
        @if (Auth::user()->vc_tipoUtilizador != 'Professor')
            <li class="nav-item has-treeview">
                <a href="{{ route('admin.disciplina_curso_classe') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Relacionar Disciplinas

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                                        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' || Auth::user()->vc_tipoUtilizador == 'Preparador')
                                            <li class="nav-item">
                                                <a href="{{ route('admin.disciplina_curso_classe.create') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Relacionar Disciplina</p>
                                                </a>
                                            </li>
                                        @endif

                                        <li class="nav-item">
                                            <a href="{{ route('admin.disciplina_curso_classe') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Disciplinas Relacionadas</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
        @endif

        @if (Auth::user()->vc_tipoUtilizador != 'Professor')

            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Cadeados de Notas

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if (Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                            Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                            Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica' ||
                            Auth::user()->vc_tipoUtilizador == 'Preparador')
                        <li class="nav-item">
                            <a href="{{ route('permissao.editar') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Editar</p>
                            </a>
                        </li>
                    @endif


                </ul>
            </li>
        @endif
        {{-- @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
                                <li class="nav-item has-treeview ">
                                    <a href="#" class="nav-link ">
                                        <i class="nav-icon fas fa-shield-alt"></i>
                                        <p>
                                            Políticas de Aprovação
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('admin/politica_de_aprovacao/cadastrar') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Política</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endif --}}

        @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-header">Pautas</li>
            <li class="nav-item has-treeview">
                <a href="{{ url('admin/pauta/pesquisar') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Pautas

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('admin/pauta/pesquisar') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Visualizar Pautas</p>
                                            </a>
                                        </li>
                                    </ul> --}}

            </li>



            {{-- <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                          <i class="nav-icon fas fa-chalkboard"></i>
                                        <p>
                                            Pauta Final
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href=""
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Visualizar Pautas</p>
                                            </a>
                                        </li>
                                    </ul>

                                </li> --}}
        @endif


        @if (Auth::user()->vc_tipoUtilizador == 'Professor' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
            <li class="nav-item has-treeview">
                <a href="" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Notas

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    @if ($estado_permissao_nota == 1)
                        <li class="nav-item">
                            <a href="{{ url('nota_em_carga/buscar_alunos') }}" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Inserir Notas</p>
                            </a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a href="{{ url('nota_em_carga/pesquisar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Visualizar Notas</p>
                        </a>
                    </li>
                </ul>
            </li>

            @if (Auth::user()->vc_tipoUtilizador == 'Chefe de Departamento Pedagógico' ||
                    Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                    Auth::user()->vc_tipoUtilizador == 'Director Geral' ||
                    Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')
                <li class="nav-item has-treeview">
                    <a href="{{ route('admin.notas-recurso.index') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Notas(Recurso/Exame)

                        </p>
                    </a>
                    {{-- <ul class="nav nav-treeview">

                                        <li class="nav-item">
                                            <a href="{{ route('admin.notas-recurso.inserir') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Inserir Nota</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('admin.notas-recurso.index') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Notas</p>
                                            </a>
                                        </li>


                                    </ul> --}}
                </li>
            @endif
            {{-- @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral' || Auth::user()->vc_tipoUtilizador == 'Cordenação Pedagógica')



                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                          <i class="nav-icon fas fa-chalkboard"></i>
                                        <p>
                                            Notas(Diplomado/Exame...)
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">

                                            <li class="nav-item">
                                                <a href="{{ url('notas-seca/inserir') }}"
                                                    class="nav-link">
                                                    <i class="far fa-circle nav-icon"></i>
                                                    <p>Inserir Nota</p>
                                                </a>
                                            </li>

                                    </ul>
                                </li>
                                @endif
                                --}}
        @endif

        @if (Auth::user()->vc_tipoUtilizador == 'Secretaria' ||
                Auth::user()->vc_tipoUtilizador == 'Administrador' ||
                Auth::user()->vc_tipoUtilizador == 'Director Geral')
            <li class="nav-header">Documentos</li>
            <li class="nav-item has-treeview">
                <a href="{{ url('Declaracoes/paginaListar') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Declarações Sem Notas

                    </p>
                </a>
                {{-- <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('Declaracoes/paginaCadastrar') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Declaracoes/paginaListar') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar</p>
                                            </a>
                                        </li>

                                    </ul> --}}
            </li>
            {{-- <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link">
                                         <i class="nav-icon fas fa-chalkboard"></i>
                                        <p>
                                            Declarações Com Notas
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('declaracaoComNotas/home') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Requisitar</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('declaracaoComNotas/listar') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Requisitadas</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li> --}}

            <li class="nav-item has-treeview">
                <a href="{{ route('documentos.certificados.emitir') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Certificado

                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ route('documentos.anulacao_matricula.emitir') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Anulação de Matrícula

                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ route('documentos.boletim_justificativo_falta.emitir') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Bole. de Justifi. de Faltas

                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ route('documentos.dispensa_administrativa.emitir') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Dispensa Administrativa

                    </p>
                </a>
            </li>

            <li class="nav-item has-treeview">
                <a href="{{ route('documentos.dispensa_professor.emitir') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Dispensa do Professor

                    </p>
                </a>
            </li>

            @if (isset($cab) && $cab->vc_tipo_escola == 'Instituto')
                <li class="nav-item has-treeview">
                    <a href="{{ route('documentos.declaracao_frequencia.emitir') }}" class="nav-link">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p>
                            Declaração de Frequência

                        </p>
                    </a>
                </li>
            @endif

            <li class="nav-item has-treeview">
                <a href="{{ route('admin.documentos.componentes') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Componete

                    </p>
                </a>
            </li>
            <li class="nav-item has-treeview">
                <a href="{{ route('admin.documentos.componentes-disciplinas') }}" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Componete disciplina

                    </p>
                </a>
            </li>
        @endif
        @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
            <li class="nav-header">Configurações técnica</li>
            <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                    <i class="nav-icon fas fa-chalkboard"></i>
                    <p>
                        Caminho /Ficheiro

                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('caminho-files.criar') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Cadastrar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('caminho-files') }}" class="nav-link">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Listar</p>
                        </a>
                    </li>

                </ul>
            </li>
        @endif




        {{--
                            @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                <li class="nav-header">Gestão de Patrimónios</li>
                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="nav-icon fas fa-university"></i>
                                        <p>
                                            Gestão de Patrimonio
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ url('admin/patrimonios/cadastrar') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Património</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('admin/patrimonios/visualizar') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Lista de Patrimónios</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ url('Admin/pesquisarPatrimonios') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Imprimir Listas</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                            @endif --}}

        {{-- @if (Auth::user()->vc_tipoUtilizador == 'Administrador' || Auth::user()->vc_tipoUtilizador == 'Director Geral')
                                <li class="nav-header">Finanças</li>
                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-tools"></i>
                                        <p>
                                            Manutenção de Seviços
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('verCadastrarServico') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Serviço</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarServico') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Serviços</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('verCadastrarManutecaoServico') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Fazer Manuteção</p>
                                            </a>
                                        </li>

                                        <li class="nav-item">
                                            <a href="{{ route('listarManutecaoServico') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Manuteção</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="fab fa-readme"></i>
                                        <p>
                                            Folhas de Salario
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('listarFolhaSalarioFuncionario') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Gerar Folha de Sálarios</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('verFolhaSalarioFuncionarioMensal') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Ver Folha de Sálarios</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-arrow-down"></i>
                                        <p>
                                            Entradas
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('verCadastrarCredito') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Entrada</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarCredito') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Entradas</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="fa fa-arrow-up"></i>
                                        <p>
                                            Saídas
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('verCadastrarDebito') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Cadastrar Saída</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarDebito') }}" class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Saídas</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>

                                <li class="nav-item has-treeview mb-4">
                                    <a href="#" class="nav-link">
                                        <i class="fas fa-balance-scale"></i>
                                        <p>
                                            Balanço Mensal
                                            
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item">
                                            <a href="{{ route('verCadastrarTotalEntradaGastosRemanescente') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Criar Balanço</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="{{ route('listarTotalEntradaGastosRemanescente') }}"
                                                class="nav-link">
                                                <i class="far fa-circle nav-icon"></i>
                                                <p>Listar Balanço</p>
                                            </a>
                                        </li>

                                    </ul>
                                </li>
                                <!-- <a href="{{ route('admin.alunos.post') }}"
                                    class="btn btn-success text-white">Conexão</a> -->

                            @endif --}}

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

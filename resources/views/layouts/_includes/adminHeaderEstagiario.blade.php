<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('titulo')</title>
    {{-- Favicons --}}
    <link href="{{asset('/'.$caminhoLogo')}}" rel="icon">
    {{-- EndFavicons --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('/css/ionicons.min.css')}}">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="{{asset('/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
    <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <!-- JQVMap -->
    <link rel="stylesheet" href="{{asset('/plugins/jqvmap/jqvmap.min.css')}}">
    <!-- Theme style -->
    <!-- overlayScrollbars -->
    <!-- summernote -->
    <link rel="stylesheet" href="{{asset('/plugins/summernote/summernote-bs4.css')}}">

    <link rel="stylesheet" href="{{asset('/css/select2.css')}}">
    <link rel="stylesheet" href="{{asset('/css/select2-bootstrap4.css')}}">

    <link rel="stylesheet" href="{{asset('/plugins/summernote/summernote-bs4.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="{{asset('/css/fontfamily.css?family=Source+Sans+Pro:300,400,400i,700')}}" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('/css/datatables/dataTables.bootstrap4.min.css')}}">

    {{-- Gráficos --}}
{{--  --}}

    <link rel="stylesheet" href="{{asset('/graficos/chart.min.css')}}">
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
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i
                            class="fas fa-bars"></i></a>
                </li>
            </ul>
            <!-- Start Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- itens a direita do menu -->
                @isset($ano_lectivo_publicado)
                    <li class="nav-item ">


                        <a class="nav-link text-info container-fluid">
                            Ano lectivo publicado: {{ $ano_lectivo_publicado }}

                        </a>
                    </li>
                @endisset
                <li class="nav-item ">
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Terminar a Sessão
                        <i class="fas fa-sign-out-alt"></i>
                    </a>
                </li>

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
                <a href="{{ url('/') }}" class="brand-link">
                    @isset($cab)
                        <img src="{{asset($caminhoLogo)}}" alt="Logo"
                            class=" brand-image img-circle bg-white elevation-3">
                        <span class="brand-text font-weight-light">Gestão<b> {{ $cab->vc_acronimo }}</b>
                        @else
                            Erro escola
                            não cadastrada </span><br>
                        {{-- <small
                            class="brand-text text-center"><i>{{ $cab->vc_escola }}</i></small> --}}
                    @endisset
                </a>
                <!-- Sidebar -->
                <div class="sidebar">
                    <!-- Sidebar user panel (optional) -->

                    <div class=" row justify-content-center col-12 user-panel mt-3 pb-3 mb-3 d-flex">
                        <div class="image">
                            {{-- <img src="{{asset('/dist/img/1_6888.png"
                                class="img-circle elevation-2" alt="User Image"> --}}
                        </div>

                        <div class="info col-sm-12">
                            <a href="#" class="d-block text-center">{{ Auth::user()->vc_primemiroNome }}
                                {{ Auth::user()->vc_apelido }}</a>
                        </div>
                        <div class="info col-sm-12 ">
                            <a href="#" class="d-block text-center">{{ Auth::user()->vc_tipoUtilizador }}</a>
                        </div>

                    </div>

                    <!-- Sidebar Menu -->

                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">Alunos</li>
                        <li class="nav-item has-treeview ">
                            <a href="{{route('admitido')}}" class="nav-link">
                                <i class="nav-icon fas fa-paste"></i>
                                <p>
                                    Adicionar aluno
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                    </li>
                        </ul>
                    </nav>
                    <!-- /.sidebar-menu -->
                </div>
                <!-- /.sidebar -->
            </aside>
        @endif

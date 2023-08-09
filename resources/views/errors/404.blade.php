<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>404</title>
    {{-- Favicons --}}
    <link href="/{{icon_escola()}}" rel="icon">
    {{-- EndFavicons --}}

    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/css/ionicons.min.css">
    <!-- Tempusdominus Bbootstrap 4 -->
    <link rel="stylesheet" href="/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="/plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="/plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="/plugins/summernote/summernote-bs4.css">
    <!-- Google Font: Source Sans Pro -->
    <link href="/css/fontfamily.css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="/css/datatables/dataTables.bootstrap4.min.css">

</head>

<body class="hold-transition sidebar-mini ">

 
    <style>
        /* Personalize o estilo da página de erro */
        body {
          background-color: #f8f9fa;
          padding-top: 50px;
          text-align: center;
        }
        h1 {
          font-size: 4rem;
        }
        p {
          font-size: 1.5rem;
        }
      </style>
    </head>
    <body>
      <div class="container">
        <h1>Erro 404</h1>
        <p>Desculpe, a página que você está procurando não foi encontrada.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Voltar para a página inicial</a>
      </div>
</body>

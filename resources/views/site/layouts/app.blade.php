<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel de Administração Escolar</title>
    {{-- <link rel="stylesheet" href="{{ asset('/vendor/boostrap/bootstrap.min.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('/dist/css/adminlte.min.css') }}">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">{{ fh_cabecalho()->vc_escola }}</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('painel.alunos') }}">Página Inicial</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('painel.alunos.pauta') }}">Pauta</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('painel.alunos.professores')}}">Professores</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('painel.alunos.cartoes_pagamento')}}">Cartão de pagamento</a>
                </li>
           
                <li class="nav-item">
                    
                    <a class="nav-link text-danger" href="{{ route('logout') }}"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Sair
                    <i class="fas fa-sign-out-alt"></i>
                </a>
           
      
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
            </form>
                </li>

            </ul>
        </div>
    </nav>

    <div class="container mt-5">
        @isset($sms)
        <div class="card mb-3">
            <div class="card-body">
                <div class="card-title text-danger">{{$sms}} </div>
            </div>
        </div>  
        @endisset
     
        @yield('conteudo')

        <script src="{{ asset('js/aluno/jquery-3.5.1.slim.min.js') }}"></script>
        <script src="{{ asset('js/aluno/popper.min.js') }}"></script>
        <script src="{{ asset('js/aluno/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>

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

        {{-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}

        <!-- Adicione aqui seus scripts para os gráficos -->
        <script>
            // Exemplo de script para gráfico de Alunos por Curso
            var ctx = document.getElementById('alunosPorCursoChart').getContext('2d');
            var alunosPorCursoChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Engenharia', 'Administração', 'Medicina'],
                    datasets: [{
                        label: 'Alunos',
                        data: [100, 200, 300],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Exemplo de script para gráfico de Professores por Departamento
            var ctx2 = document.getElementById('professoresPorDepartamentoChart').getContext('2d');
            var professoresPorDepartamentoChart = new Chart(ctx2, {
                type: 'pie',
                data: {
                    labels: ['Departamento 1', 'Departamento 2', 'Departamento 3'],
                    datasets: [{
                        label: 'Professores',
                        data: [10, 20, 30],
                        backgroundColor: ['rgba(75, 192, 192, 0.2)', 'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 99, 132, 0.2)'
                        ],
                        borderColor: ['rgba(75, 192, 192, 1)', 'rgba(54, 162, 235, 1)',
                            'rgba(255, 99, 132, 1)'
                        ],
                        borderWidth: 1
                    }]
                }
            });
        </script>
</body>

</html>

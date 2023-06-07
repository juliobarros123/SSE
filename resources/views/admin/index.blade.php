@extends('layouts.admin')

@section('titulo', 'Página Principal')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-8">

                        <h3>
                            Painel Administrativo
                        </h3>

                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4 class="mb-3">Alunos por Classe</h4>
                        <p>Total: 200</p>
                        <p>Classe A: 50</p>
                        <p>Classe B: 40</p>
                        <p>Classe C: 30</p>
                        <p>Classe D: 45</p>
                        <p>Classe E: 35</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4 class="mb-3">Alunos por Turmas</h4>
                        <p>Total: 150</p>
                        <p>Turma 1: 30</p>
                        <p>Turma 2: 25</p>
                        <p>Turma 3: 20</p>
                        <p>Turma 4: 35</p>
                        <p>Turma 5: 40</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4 class="mb-3">Candidatos por Aluno Letivo</h4>
                        <p>Total: 500</p>
                        <p>2020: 120</p>
                        <p>2021: 180</p>
                        <p>2022: 100</p>
                        <p>2023: 200</p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4 class="mb-3">Alunos por Curso</h4>
                        <p>Total: 300</p>
                        <p>Curso A: 80</p>
                        <p>Curso B: 70</p>
                        <p>Curso C: 50</p>
                        <p>Curso D: 60</p>
                        <p>Curso E: 40</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Gráfico de Barras - Alunos por Classe</h4>
                    <div class="chart-container">
                        <canvas id="bar-chart"></canvas>
                    </div>
                    <h4 class="mb-3">Gráfico de Linhas - Candidatos por Aluno Letivo</h4>
                    <div class="chart-container">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Gráfico de Pizza - Alunos por Turmas</h4>
                    <div class="chart-container">
                        <canvas id="pie-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <h4 class="mb-3">Gráfico de Área Polar - Alunos por Curso</h4>
                    <div class="chart-container">
                        <canvas id="polar-area-chart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Gráfico Radar - Alunos por Curso</h4>
                    <div class="chart-container">
                        <canvas id="radar-chart"></canvas>
                    </div>
                </div>
            </div>
        
        </div>
    </div>
    </div>

    <script src="{{asset('js/chart.js')}}"></script>
    <script>
        // Dados de exemplo
        var barChartData = {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                label: 'Alunos por Classe',
                data: [50, 40, 30, 45, 35],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var pieChartData = {
            labels: ['Turma 1', 'Turma 2', 'Turma 3', 'Turma 4', 'Turma 5'],
            datasets: [{
                label: 'Alunos por Turmas',
                data: [30, 25, 20, 35, 40],
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        var lineChartData = {
            labels: ['2020', '2021', '2022', '2023'],
            datasets: [{
                label: 'Candidatos por Aluno Letivo',
                data: [120, 180, 100, 200],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            }]
        };

        var radarChartData = {
            labels: ['Curso A', 'Curso B', 'Curso C', 'Curso D', 'Curso E'],
            datasets: [{
                label: 'Alunos por Curso',
                data: [80, 70, 50, 60, 40],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            }]
        };

        var polarAreaChartData = {
            labels: ['Curso A', 'Curso B', 'Curso C', 'Curso D', 'Curso E'],
            datasets: [{
                label: 'Alunos por Curso',
                data: [80, 70, 50, 60, 40],
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Renderizando os gráficos
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

        new Chart(document.getElementById('pie-chart'), {
            type: 'pie',
            data: pieChartData
        });

        new Chart(document.getElementById('line-chart'), {
            type: 'line',
            data: lineChartData
        });

        new Chart(document.getElementById('radar-chart'), {
            type: 'radar',
            data: radarChartData
        });

        new Chart(document.getElementById('polar-area-chart'), {
            type: 'polarArea',
            data: polarAreaChartData
        });
    </script>


    @include('admin.layouts.footer')

    {{-- Javascript e PHP dos graficos --}}
    @include('grafics.home')
    {{-- ./Javascript e PHP dos graficos --}}




    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Dados de exemplo
        var barChartData = {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                label: 'Gráfico de Barras',
                data: [10, 20, 15, 25, 18],
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        };

        var pieChartData = {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                label: 'Gráfico de Pizza',
                data: [10, 20, 15, 25, 18],
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        var lineChartData = {
            labels: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho'],
            datasets: [{
                label: 'Gráfico de Linhas',
                data: [10, 15, 20, 18, 25, 22],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            }]
        };

        var radarChartData = {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                label: 'Gráfico Radar',
                data: [10, 15, 20, 18, 25],
                borderColor: 'rgba(54, 162, 235, 1)',
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderWidth: 1
            }]
        };

        var polarAreaChartData = {
            labels: ['A', 'B', 'C', 'D', 'E'],
            datasets: [{
                label: 'Gráfico de Área Polar',
                data: [10, 15, 20, 18, 25],
                backgroundColor: ['rgba(54, 162, 235, 0.5)', 'rgba(255, 99, 132, 0.5)',
                    'rgba(75, 192, 192, 0.5)', 'rgba(255, 205, 86, 0.5)', 'rgba(153, 102, 255, 0.5)'
                ],
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(75, 192, 192, 1)',
                    'rgba(255, 205, 86, 1)', 'rgba(153, 102, 255, 1)'
                ],
                borderWidth: 1
            }]
        };

        // Renderizando os gráficos
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

        new Chart(document.getElementById('pie-chart'), {
            type: 'pie',
            data: pieChartData
        });

        new Chart(document.getElementById('line-chart'), {
            type: 'line',
            data: lineChartData
        });

        new Chart(document.getElementById('radar-chart'), {
            type: 'radar',
            data: radarChartData
        });

        new Chart(document.getElementById('polar-area-chart'), {
            type: 'polarArea',
            data: polarAreaChartData
        });
    </script>
@endsection

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
            <div class="row mb-4">
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4>Candidatos</h4>
                        <p>Total: {{fh_candidatos()->where('candidatos.id_ano_lectivo', fha_ano_lectivo_publicado()->id_anoLectivo)->count()}}</p>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4>Alunos</h4>
                        <p>Total: {{fh_candidatos()->where('candidatos.id_ano_lectivo', fha_ano_lectivo_publicado()->id_anoLectivo)->count()}}</p>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4>Matriculados</h4>
                        <p>Total: 200</p>

                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="statistic-card">
                        <h4>Turmas</h4>
                        <p>Total: 200</p>

                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-5">
                    <h4 class="mb-3">Alunos Matriculados por Classe</h4>
                    <div class="chart-container">
                        <canvas id="bar-chart"></canvas>
                    </div>
                    <h4 class="mb-3">Candidatos por Aluno Lectivo</h4>
                    <div class="chart-container">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <h4 class="mb-3">Alunos por Curso</h4>
                    <div class="chart-container">
                        <canvas id="polar-area-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="row d-flex justify-content-center">
            
           
                <div class="col-md-10">
                    <h4 class="mb-3">Alunos por Turmas</h4>
                    <div class="chart-container">
                        <canvas id="pie-chart"></canvas>
                    </div>
                </div>
            </div>
          

        </div>
    </div>
    </div>

    <script src="{{ asset('js/chart.js') }}"></script>
  

    @include('admin.layouts.footer')

    {{-- Javascript e PHP dos graficos --}}
    @include('grafics.home')
    {{-- ./Javascript e PHP dos graficos --}}




    
@endsection

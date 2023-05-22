@extends('layouts.admin')

@section('titulo', 'Página Principal')

@section('conteudo')

    <div class="card mt-3">
        <div class="card-body">
            <div class="col-md-12">
                <div class="row">

                    <div class="col-md-8">
                        @isset($cabecalho->vc_escola)
                            <h3>
                                School management(Dashboard)
                                {{-- {{ $cabecalho->vc_escola . ' - ' . $cabecalho->vc_acronimo }} --}}
                            </h3>
                        @endisset
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
    <!--  -->



    {{-- Estatisticas superior inicio --}}
    <div class="row">

        <div class="col-md-6">
            <div class="info-box">
                <span class="info-box-icon bg-dark elevation-1"><i class="nav-icon fas fa-graduation-cap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Candidatos</span>
                    <span class="info-box-number text-right">
                        @isset($selecionados){{ $selecionados }}
                        @endisset
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <div class="info-box mb-3">
                <span class="info-box-icon bg-dark elevation-1"><i class="nav-icon fas fa-graduation-cap"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Matriculados</span>

                    <span class="info-box-number text-right">
                        @isset($candidaturas){{ $candidaturas }}
                        @endisset
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <div class="info-box mb-3">
                <span class="info-box-icon bg-dark elevation-1"><i class="nav-icon fas fa-scroll"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Turmas</span>
                    <span class="info-box-number  text-right">
                      
                        @isset($candidaturas){{ $candidaturas }}
                        @endisset
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
        
            <!-- /.info-box -->
        </div>
        <div class="col-md-6">
            <div class="info-box">
                <div class="info-box-content">
                            <canvas id="myChart"></canvas>
                        
                </div>
                <!-- /.info-box-content -->
            </div>
        
        
            <!-- /.info-box -->
        </div>


        <div class="col-6col-sm-6 col-lg-6">
            <div class="info-box">
                <div class="info-box-content">
                            <canvas id="canvas"></canvas>
                        
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <div class="col-6col-sm-6 col-lg-6">
            <div class="info-box">
                <div class="info-box-content">
                            <canvas id="chart-area"></canvas>
                        
                </div>
                <!-- /.info-box-content -->
            </div>
        
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    {{-- Estatisticas superior fim --}}


    {{-- gráficos html --}}

    {{-- ./gráficos html --}}




    @include('admin.layouts.footer')

    {{-- Javascript e PHP dos graficos --}}
    @include('grafics.home')
    {{-- ./Javascript e PHP dos graficos --}}



    @if (session('succes'))
    <script>
        Swal.fire(
            'Dados enviados',
            '',
            'success'
        )

    </script>
@endif

    @if (session('aviso'))
        <script>
            Swal.fire(
                'Cadastre primeiro o Ano lectivo',
                '',
                'error'
            )

        </script>
    @endif
@endsection

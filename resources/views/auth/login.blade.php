@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/auth/style.css') }}">

    <div class="container mt-5">
        <section class="ftco-section">
            <div class="container">
           
                <div class="row justify-content-center">
                    <div class="col-md-7 col-lg-5">
                        <div class="login-wrap p-4 p-md-5">
                            <div class="icon d-flex align-items-center justify-content-center">
                                <img rel="icon" src="{{ asset($caminhoLogo) }}" style="margin:auto;height:100%" />

                            </div>
                            <h3 class="text-center mb-4"> {{ $cab->vc_escola }} - {{ $cab->vc_acronimo }}</h3>
                            <form class="login-form" action="{{ route('login') }}" method="POST">
                                @csrf
                                
                                <div class="form-group">
                                    <input type="text" class="form-control rounded-left" placeholder="Seu e-mail"
                                        name="vc_email" value="{{ old('vc_email') }}" required>
                                </div>
                                <div class="form-group d-flex">
                                    <input type="password" class="form-control rounded-left" placeholder="Sua senha"
                                        required name="password">
                                </div>
                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn btn-primary rounded submit px-3">Acessar</button>
                                </div>
                                <div class="form-group d-md-flex">
                                    <div class="w-50">
                                        <label class="checkbox-wrap checkbox-primary"> Lembre de mim
                                            <input type="checkbox" checked>
                                            <span class="checkmark"></span>
                                        </label>
                                    </div>
                                    <div class="w-50 text-md-right">
                                        <a href="#" data-toggle="modal" data-target="#exampleModal">Conta aluno</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div><!-- Button trigger modal -->


    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('login.alunos') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Preencha os dados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control rounded-left" name="processo"
                                value="{{ old('processo') }}" required autocomplete="processo"
                                placeholder="Seu Nº de Processo" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="text" class="form-control rounded-left" placeholder="Seu código de acesso"
                                required name="codigo" required autocomplete="current-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        {{-- <button type="button" type="submit" class="btn btn-primary">Continuar </button> --}}
                        <input type="submit" class="btn btn-secondary" value="Continuar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" action="{{ route('login.alunos') }}">
                    @csrf

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Preencha os dados</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="text" class="form-control rounded-left" name="processo"
                                value="{{ old('processo') }}" required autocomplete="processo"
                                placeholder="Seu Nº de Processo" required>
                        </div>
                        <div class="form-group d-flex">
                            <input type="text" class="form-control rounded-left" placeholder="Seu código de acesso"
                                required name="codigo" required autocomplete="current-text">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        {{-- <button type="button" type="submit" class="btn btn-primary">Continuar </button> --}}
                        <input type="submit" class="btn btn-secondary" value="Continuar">
                    </div>
                </form>
            </div>
        </div>
    </div>
    @include('admin.layouts.footer')
@endsection

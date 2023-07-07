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
                            <h3 class="text-center mb-4"> <b>
                                    {{ $cab->vc_escola }} - {{ $cab->vc_acronimo }}
                                    <br>
                                    Entrar
                                </b></h3>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf


                                <div class="form-group">
                                    <input type="text" class="form-control rounded-left" name="vc_email"
                                        value="{{ old('vc_email') }}" required autocomplete="vc_email"
                                        placeholder="Seu E-mail" required>
                                </div>
                                <div class="form-group d-flex">
                                    <input type="password" class="form-control rounded-left" placeholder="Passe" required
                                        name="password" required autocomplete="current-password">
                                </div>

                                <div class="form-group">
                                    <button type="submit"
                                        class="form-control btn text-white bg-danger rounded submit px-3">Entrar</button>

                                    <div class="d-sm-flex mb-3 align-items-center">
                                        <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">
                                                Lembre de mim</span>
                                            <input type="checkbox" checked="checked">
                                            <div class="control__indicator"></div>
                                        </label>
                                        {{-- <span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> --}}
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <a href="#" class="btn btn-primary p-2 pl-4 pr-4 btn-facebook " data-toggle="modal"
                                            data-target="#exampleModal">
                                            <span class="icon-facebook"></span> Dados Alunos
                                        </a>

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
    @include('admin.layouts.footer')
@endsection

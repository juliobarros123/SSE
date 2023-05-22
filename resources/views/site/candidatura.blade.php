@extends('layouts.site')
@section('conteudo')
    <div class="main p-5">

        <div class="card">
            {{-- @if (isset($errors) && count($errors) > 0)
                <div class="text-center mt-4 mb-4 alert-danger">
                    @foreach ($errors->all() as $erro)
                        <h5>{{ $erro }}</h5>
                    @endforeach
                </div>
            @endif
            <h3 class="text-center">

                Candidatura

            </h3> --}}

            <div class="  mb-2  rounded  rounded-sm d-flex justify-content-center ">
                <img rel="icon" src="{{asset($caminhoLogo)}}"  class="logo" />
            </div>
            <h3 class="text-center">

                Candidatura

            </h3>
            <div class="">
                <form method="post" action="{{ route('site.candidatura') }}">

                    @csrf
                
                    @include('site.forms._formCandidatura.index')
                    <div class="form-group col-sm-12 d-flex justify-content-center">
                       
                        <button class="form-control btn btn-dark w-25">Adicionar</button>
                    </div>
                </form>
            </div>
            {{-- </div>
    </div> --}}
        </div>
    </div>
    <style>
        .logo{
            height: 100px;
            width: 100px;
            border-radius: 15px;
        }
    </style>
@endsection

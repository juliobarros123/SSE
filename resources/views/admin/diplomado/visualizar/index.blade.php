@extends('layouts.admin')

@section('titulo', 'Disciplina/Cadastrar')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Visualizar Diplomado</h3>
        </div>
    </div>

    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('disciplina'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Disciplina Inexistente',
            })

        </script>
    @endif



    <div class="card">
        <div class="card-body">


            <div class="row">
                <div class="col-md-12">
                    <h4 class="text-center mb-5">Disciplinas do Curso</h4>
                </div>
                <div class="col-md-12 ">
                    <div class="row">
                        @foreach ($disciplinas as $disciplina)
                            <div class="col-md-3 card p-2 mx-2">
                                <div class="col-md-12">
                                    <h6>{{$disciplina->vc_nome}}</h6>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-6">
                                            Classe : {{$disciplina->fl_classe}}
                                        </div>
                                        <div class="col-md-5">
                                            <p class="text-success">
                                                @if (isset($disciplina->fl_mfd))
                                              <span class="text-primary">MFD</span> : {{$disciplina->fl_mfd}}
                                            @endif
                                             @if (isset($disciplina->fl_cfd))
                                             <span class="text-primary">CFD</span>: {{$disciplina->fl_cfd}}
                                            @endif
                                            </p>
                                        </div>

                                    </div>

                                </div>
                            </div>
                        @endforeach


                        {{-- @foreach ($disciplinas as $disciplina)



                            <div class="col-md-3 mx-2 card ">
                                <!-- Button trigger modal -->
                                <button type="button" class="btn btn- col-md-12" data-toggle="modal"
                                    data-target="#exampleModal{{ $disciplina->id }}">

                                        <div class="col-md-12">
                                            <p class="text-left">{{ $disciplina->vc_nome }}   </p>

                                        </div>

                                        <div class="col-md-6">
                                            <p class="text-left">{{ $disciplina->vc_classe }}ª Classe </p>

                                        </div>

                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="exampleModal{{ $disciplina->id }}" role="dialog"
                                    aria-labelledby="#exampleModalLabel{{ $disciplina->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel{{ $disciplina->id }}"> {{ $disciplina->vc_nome }}</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">



                                                {{ $disciplina->vc_nome }}



                                                <form action="{{ route('admin.nota-diplomados.store') }}" method="post" id="{{ $disciplina->id }}">
                                                    @csrf
                                                    <div class="col-md-12">
                                                        <div class="row">
                                                            @if ($disciplina->vc_classe !== "12")
                                                            <div class="col-md-2">
                                                                <div class="form-group ">
                                                                    <label for="fl_mfd">{{ __('MFD') }}</label>
                                                                    <input value="{{ isset($nota->fl_mfd) ? $nota->fl_mfd : '' }}"
                                                                        id="vc_apelido" type="text" placeholder="Primeira Nota  "
                                                                        class="form-control @error('fl_mfd') is-invalid @enderror border-secondary"
                                                                        name="fl_mfd" value="{{ old('fl_mfd') }}" required
                                                                        autocomplete="fl_mfd" autofocus>

                                                                    @error('fl_mfd')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            @endif



                                                            <input type="text" name="id_disciplina" value="{{$disciplina->id}}" hidden>

                                                            @if ($disciplina->vc_classe === "12")
                                                            <div class="col-md-2">
                                                                <div class="form-group ">
                                                                    <label for="fl_cfd">{{ __('CFD') }}</label>
                                                                    <input
                                                                        value="{{ isset($nota->fl_ca) ? $nota->fl_ca : '' }}"
                                                                        id="fl_cfd" type="text" placeholder="CFD "
                                                                        class="form-control @error('fl_cfd') is-invalid @enderror border-secondary"
                                                                        name="fl_cfd" value="{{ old('fl_cfd') }}" required
                                                                        autocomplete="fl_cfd" autofocus>

                                                                    @error('fl_cfd')
                                                                        <span class="invalid-feedback" role="alert">
                                                                            <strong>{{ $message }}</strong>
                                                                        </span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            @endif





                                                            <input type="number" hidden name="id_diplomado" id="id_diplomado"
                                                                value="{{ isset($id_diplomado) }}">




                                                            <div class="col-md-4">
                                                                <label for="it_estado">{{ __('Estado') }}</label>
                                                                <select type="text" class="form-control border-secondary"
                                                                    name="it_estado" required>
                                                                    @isset($user)
                                                                        <option
                                                                            value="{{ isset($nota->it_estado) ? $nota->it_estado : '' }}">
                                                                            {{ $nota->it_estado }}</option>
                                                                    @else
                                                                        <option disabled value="" selected>selecione o estado</option>
                                                                    @endisset
                                                                    <option value="1">Ativado</option>
                                                                    <option value="0">Desativado</option>


                                                                </select>
                                                            </div>


                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" id="{{ $disciplina->id }}" class="btn btn-success">Inserir</button>
                                                    </div>
                                                </form>


                                            </div>

                                        </div>
                                    </div>
                                </div>


                            </div>


                        @endforeach --}}
                    </div>

                </div><br>
            </div>

        </div>
    </div>


    <!-- Footer-->
    @include('admin.layouts.footer')
@endsection

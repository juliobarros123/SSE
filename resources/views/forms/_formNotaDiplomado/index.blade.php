<div class="row">
    <div class="col-md-12">
        <h4 class="text-center mb-5">Disciplinas do Curso</h4>
    </div>
    <div class="col-md-12 ">
        <div class="row">



            @foreach ($disciplinas as $disciplina)



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
                                                <input type="text" name="fl_classe" value="{{$disciplina->vc_classe}}" hidden>

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




                                                <input type="hidden" name="id_diplomado" id="id_diplomado"
                                                    value="{{ $id_diplomado }}">


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


            @endforeach
        </div>

    </div><br>
</div>


{{-- <div class="col-md-8">
                            <div class="row">

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="fl_npt">{{ __('NPT3') }}</label>
                                        <input value="{{ isset($nota->fl_npt) ? $nota->fl_npt : '' }}" id="vc_apelido" type="text"
                                        placeholder="Primeira Nota  " class="form-control @error('fl_npt') is-invalid @enderror border-secondary" name="fl_npt{{$disciplina->id}}"
                                            value="{{ old('fl_npt') }}" required autocomplete="fl_npt" autofocus>

                                        @error('fl_npt')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>



                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="fl_mfd">{{ __('MFD') }}</label>
                                        <input value="{{ isset($nota->fl_mfd) ? $nota->fl_mfd : '' }}" id="fl_mfd" type="text"
                                        placeholder="MFD " class="form-control @error('fl_mfd') is-invalid @enderror border-secondary" name="fl_mfd{{$disciplina->id}}"
                                            value="{{ old('fl_mfd') }}" required autocomplete="fl_mfd" autofocus>

                                        @error('fl_mfd')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="fl_mt3">{{ __('MT3') }}</label>
                                        <input value="{{ isset($nota->fl_mt3) ? $nota->fl_mt3 : '' }}" id="fl_mt3" type="text"
                                        placeholder="MT3 " class="form-control @error('fl_mt3') is-invalid @enderror border-secondary" name="fl_mt3{{$disciplina->id}}"
                                            value="{{ old('fl_mt3') }}" required autocomplete="fl_mt3" autofocus>

                                        @error('fl_mt3')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <input type="number" hidden name="id_diplomado" id="id_diplomado" value="{{isset($id_diplomado)}}">



                                <div class="col-md-2">
                                    <div class="form-group ">
                                        <label for="fl_mac">{{ __('MAC') }}</label>
                                        <input value="{{ isset($nota->fl_mac) ? $nota->fl_mac : '' }}" id="fl_mac" type="text"
                                        placeholder="MAC" class="form-control @error('fl_mac') is-invalid @enderror border-secondary" name="fl_mac{{$disciplina->id}}"
                                            value="{{ old('fl_mac') }}" required autocomplete="fl_mac" autofocus>

                                        @error('fl_mac')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <label for="it_estado">{{ __('Estado') }}</label>
                                    <select type="text" class="form-control border-secondary" name="it_estado{{$disciplina->id}}" required>
                                        @isset($user)
                                            <option value="{{ isset($nota->it_estado) ? $nota->it_estado : '' }}">
                                                {{ $nota->it_estado }}</option>
                                        @else
                                            <option disabled value="" selected>selecione o estado</option>
                                        @endisset
                                        <option value="1">Ativado</option>
                                        <option value="0">Desativado</option>


                                    </select>
                                </div>


                            </div>

                        </div> --}}

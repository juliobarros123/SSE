@extends('layouts.admin')
@section('titulo', 'Turma-Pautas/Listar')
@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Lista de Turmas - Pautas</h3>
        </div>
    </div>



    @if (session('aviso'))
        <h5 class="text-center alert alert-danger">{{ session('aviso') }}</h5>
    @endif
    <table id="example" class="display table table-hover">
           <thead class="">
            <tr class="text-center">
                <th>TURMA</th>
                <th>TURNO</th>
                <th>CLASSE</th>
                <th>CURSO</th>
                <th>ANO LECTIVO</th>
                <th>PAUTA</th>
            </tr>
        </thead>
        <tbody class="bg-white">

            @foreach ($dadosDaTabelaTurma as $row)

                <tr class="text-center">
                    <td>{{ $row->vc_nomedaTurma }}</td>
                    <td>
                        @if ($row->vc_turnoTurma == 'DIURNO')
                            <b class="bg-warning">DIURNO</b>
                        @elseif($row->vc_turnoTurma == "NOITE")
                            <b class="bg-dark">NOITE</b>
                        @elseif($row->vc_turnoTurma == "MANHÃ")
                            <b class="bg-info">MANHÃ</b>
                        @elseif($row->vc_turnoTurma == "TARDE")
                            <b class="bg-primary">TARDE</b>
                        @elseif($row->vc_turnoTurma == "Sabática")
                            <b class="bg-secondary">Sabática</b>
                        @else
                            <b>{{ $row->vc_turnoTurma }}</b>
                        @endif
                    </td>
                    <td>{{ $row->vc_classeTurma }}ª</td>
                    <td class="text-left">{{ $row->vc_cursoTurma }}</td>

                    <td>{{ $row->vc_anoLectivo }}</td>
                    <td>
                        <div class="dropdown">
                            <button class="btn btn-dark dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-clone" aria-hidden="true"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a href="{{ url('/admin/pauta/gerar/' . $row->id . '/I') }}" class="dropdown-item"
                                    target="_blank">Iº Trimestre</a>
                                <a href="{{ url('/admin/pauta/gerar/' . $row->id . '/II') }}" class="dropdown-item"
                                    target="_blank">IIº Trimestre</a>
                                <a href="{{ url('/admin/pauta/gerar/' . $row->id . '/III') }}" class="dropdown-item"
                                    target="_blank">IIIº Trimestre</a>

                               
                            </div>
                        </div>

                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    @include('admin.layouts.footer')

@endsection

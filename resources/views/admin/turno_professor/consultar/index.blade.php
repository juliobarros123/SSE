@extends('layouts.admin')

@section('titulo', 'Consultar professores por turno')

@section('conteudo')
    <div class="card mt-3">
        <div class="card-body">
            <h3>Consultar professores por turno</h3>
        </div>
    </div>
    <script src="{{asset('/js/sweetalert2.all.min.js')}}"></script>
    @if (session('curso'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'O curso já existe ',
            })
        </script>
    @endif

    <div class="card">
        <div class="card-body">


            <form method="POST" action="{{ url('/professores_turno') }}">
                @csrf
                <div class="row">


                    <div class="form-group col-md-8">
                        <label class="form-label" for="turno">Turnos:</label>
                        <select class="form-control " name="turno" id="turno" required>

                            <option value="" disabled selected>Seleciona o turno:</option>
                            @foreach ($turnos as $item)
                            <option value="{{$item->turno}}">{{$item->turno}}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group col-md-4 mt-2">

                        <button class=" btn btn-dark mt-4 w-100" type="submit">Consultar</button>
                    </div>


                </div>
            </form>

        </div>

    </div>


    <!-- Footer-->

    @include('admin.layouts.footer')
@endsection

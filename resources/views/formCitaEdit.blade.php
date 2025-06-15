@extends('layouts.app')

@section('content')
    @php
        $horas = [];
        $horaInicio = 540;
        $horaFin = 1260;
        for ($minutos = $horaInicio; $minutos < $horaFin; $minutos += 30) {
            $horas[] = sprintf('%02d:%02d', intdiv($minutos, 60), $minutos % 60);
        }
    @endphp
    <div class="d-flex flex-column mx-auto w-100">

        <div class="formCitaAux d-flex flex-row">
            <div class="horarioAux">
                @include('partials.horario')
            </div>

            <div class="formContPadre justify-content-center mx-2">
                <div class="formCont justify-content-start">
                    <div class="d-flex flex-row justify-content-between">
                        <h1 class="w-100 text-center">Editando cita para {{ $nombreClient }} </h1>

                        <a class="btn botonAzul botonBB m-auto text-white justify-content-center"
                            href="{{ route('panelCliente', ['id' => $cita->id_client]) }}">
                            Ir al perfil
                        </a>
                    </div>

                    <form method="GET" action="{{ route('editaCita', ['id' => $cita->id_cita]) }}">
                        @csrf
                        @if (session('status'))
                            <div class="alert estado text-center">
                                {{ session('status') }}
                            </div>
                        @endif
                        @if ($errors->any())
                            <div class="alert alerta">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="form-group mb-3">
                            <label for="dia">Dia</label>
                            <input type="date" class="form-control bg-dark text-white" id="dia" name="dia"
                                value="{{ date('Y-m-d', strtotime($cita->date_ini)) }}">
                        </div>

                        <div class="form-group mb-3 mt-0">
                            <label for="inicio">Hora inicio</label>
                            <select name="inicio" id="inicio" class="form-control bg-dark text-white" required>
                                <option value="{{ date('H:i', strtotime($cita->date_ini)) }}">
                                    {{ date('H:i', strtotime($cita->date_ini)) }}
                                </option>
                                @foreach ($horas as $hora)
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="fin">Hora fin</label>
                            <select name="fin" id="fin" class="form-control bg-dark text-white" required>
                                <option value="{{ date('H:i', strtotime($cita->date_fin)) }}">
                                    {{ date('H:i', strtotime($cita->date_fin)) }}
                                </option>
                                @foreach ($horas as $hora)
                                    <option value="{{ $hora }}">{{ $hora }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label for="precio">Precio</label>
                            <input type="number" class="form-control bg-dark text-white" id="precio" name="precio"
                                value="{{ $cita->precio }}">
                        </div>

                        <label for="gab">Elige el gabinete:</label>
                        <select id="gab" name="gab" class="form-control bg-dark text-white mb-3">
                            <option value="{{ $cita->gab }}">{{ $cita->gab }}</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                        </select>

                        <label for="dent">Elige al dentista:</label>
                        <select id="dent" name="dent" class="form-control bg-dark text-white mb-3">
                            @if ($nombreDent != '')
                                <option value="{{ $cita->id_dent }}">{{ $nombreDent }}</option>
                            @endif

                            @foreach ($fullDent as $dent)
                                <option value="{{ $dent[0] }}">{{ $dent[1] }}</option>
                            @endforeach
                        </select>

                        <div class="form-group">
                            <label for="desc">Descripción</label>
                            <input type="text" name="desc" id="desc" class="form-control bg-dark text-white mb-3"
                                value="{{ $cita->descri }}">
                        </div>

                        <div class="form-group text-center">
                            <button type="submit" class="btn botonAzul text-white">Editar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

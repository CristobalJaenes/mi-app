@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert estadoAlert text-center m-auto mb-5">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alerta text-center m-auto mb-5">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel-cliente d-flex flex-wrap mx-auto">

        <div class="infoUser w-50 m-auto">
            @include('partials.infoCliente')

            @if ($esUser && auth()->user()->esAdmin())
                <form action="{{ route('gestUsuPass', ['id' => $infoCliente->id_persona]) }}">
                    @csrf
                    <div class="form-group text-center">
                        <button type="submit" class="btn botonAzul text-white">Configurar usuario</button>
                    </div>
                </form>
            @endif

            @if (!$esUser && auth()->user()->esAdmin())
                <form action="{{ route('upgClientPass', ['id' => $infoCliente->id_persona]) }}" method="POST">
                    @csrf
                    <div class="form-group text-center">
                        <button type="submit" class="btn botonAzul text-white">Convertir en usuario</button>
                    </div>
                </form>
            @endif


        </div>


        <div class='w-50 d-flex flex-column flex-wrap m-auto'>
            <div class="d-flex flex-row justify-content-between">
                <h1>Citas</h1>

                <div class="d-flex flex-row">
                    <a class="botonCitaNueva botonAzul btn bg-success text-white"
                        href="{{ route('citasPacientePdf', ['id' => $infoCliente->id_persona]) }}" target="_blank">
                        Ver en pdf
                    </a>

                    <a class="botonCitaNueva botonAzul btn bg-success text-white"
                        href="{{ route('formCita', ['id' => $infoCliente->id_persona]) }}">
                        Crear nueva
                    </a>
                </div>

            </div>

            @foreach ($citasCliente as $cita)
                <div class="detalleCita botonAzul d-flex flex-row text-white row rounded">
                    <div class="col-auto d-flex flex-column ">
                        <p class="m-auto mb-0">
                            {{ date('d/m/Y', strtotime($cita->date_ini)) }}
                        </p>
                        <p class="m-auto mt-0">
                            {{ date('H:i', strtotime($cita->date_ini)) }} - {{ date('H:i', strtotime($cita->date_fin)) }}
                        </p>

                    </div>
                    <div class="col d-flex flex-column text-truncate overflow-hidden justify-content-between ms-3 ps-3">
                        <strong class="mt-3 ">
                            {{ $cita->descri }}
                        </strong>
                        <div class="d-flex flex-row gap-3">
                            @php
                                $nombreDent = null;
                                foreach ($fullDent as $denti) {
                                    if ($denti[0] == $cita->id_dent) {
                                        $nombreDent = $denti[1];
                                    }
                                }
                            @endphp
                            @if ($nombreDent)
                                <p class="mt-0">Dentista: {{ $nombreDent }}</p>
                            @else
                                <p class="mt-0">Dentista eliminado</p>
                            @endif
                            <p class="mt-0 mb-2">{{ $cita->precio }}€</p>
                        </div>
                    </div>
                    <div class="col-auto d-flex flex-row gap-3">
                        <a class="btn bg-success text-white m-auto"
                            href="{{ route('formCitaEdit', ['id' => $cita->id_cita]) }}">
                            Editar
                        </a>
                        <a class="btn bg-danger text-white m-auto"
                            onclick="eliminarCita({{ $cita->id_cita }}, '{{ $infoCliente->nombre }}', '{{ $cita->date_ini }}')">
                            borrar
                        </a>
                    </div>

                    <form id="deleteForm" action="" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            @endforeach
        </div>

        @auth

            @if (auth()->user()->esDentista() || auth()->user()->esAdmin())
                <div class="odontoCont mt-4 mb-3">
                    @include('partials.odonto')
                </div>

                <div class="w-100 text-center mt-3">
                    <a href="{{ route('formEditaOdonto', ['id' => $infoCliente->id_persona]) }}"
                        class="btn botonAzul text-white">
                        Editar odontograma
                    </a>
                </div>
            @endif

        @endauth
    </div>
    <script>
        function eliminarCita(idCita, nombre, date_ini) {
            fechaAux = new Date(date_ini);
            $textoConfirm = "¿Estás seguro de que quieres eliminar la cita de " + nombre + " para el " + fechaAux
                .getDate() + "/" + (fechaAux.getMonth() + 1) + " a las " + String(fechaAux.getHours()).padStart(2, '0') +
                ":" + String(fechaAux.getMinutes()).padStart(2, '0') + " ?";
            if (confirm($textoConfirm)) {
                let form = document.getElementById("deleteForm");
                form.action = `/borraCita/${idCita}`;
                form.submit();
            }
        }
    </script>
@endsection

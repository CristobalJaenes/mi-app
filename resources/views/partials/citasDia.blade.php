<div class="contCitasDia">
    <div class="d-flex flex-row justify-content-between">
        <h1>Citas del {{ \Carbon\Carbon::parse($dia)->format('d/m/Y') }}</h1>

        <a class="botonCitaNueva botonAzul btn bg-success text-white" href="{{ route('citasDiaPdf', ['dia' => $dia]) }}"
            target="_blank">
            Ver en pdf {{ $dia }}
        </a>
    </div>

    <div class="d-flex flex-column gap-2">

        @foreach ($citasHoy as $cita)
            @foreach ($nombresClientes as $nombreClie)
                @if ($cita->id_client == $nombreClie[0])
                    @php
                        $nameAux = $nombreClie[1];
                    @endphp
                @endif
            @endforeach

            @foreach ($nombresDent as $nombreDent)
                @if ($cita->id_dent == $nombreDent[0])
                    @php
                        $nameAux2 = $nombreDent[1];
                    @endphp
                @endif
            @endforeach

            <div class="detalleCita2 botonAzul d-flex flex-row rounded text-white">
                <div class="col-auto d-flex flex-column py-3 ms-2 h-100">
                    <p class="row ps-3">{{ date('d/m/Y', strtotime($cita->date_ini)) }}</p>
                    <div class="row d-flex flex-row">
                        <p class="ps-3">
                            {{ date('H:i', strtotime($cita->date_ini)) }} -
                            {{ date('H:i', strtotime($cita->date_fin)) }}
                        </p>
                    </div>
                </div>
                <div class="desc btn col d-flex flex-column text-white"
                    onclick="window.location.href='{{ route('panelCliente', ['id' => $cita->id_client]) }}'">
                    <p class="m-1">
                        {{ $cita->descri }}
                    </p>
                    <p class="m-1">Cliente: {{ $nameAux }}</p>
                    <p class="m-1">Dentista: {{ $nameAux2 }}</p>
                    <p class="m-1 mb-1">{{ $cita->precio }}€</p>
                </div>
                <div class="col-auto d-flex flex-row pe-3 gap-3">
                    <a class="botonAA btn bg-success text-white m-auto"
                        href="{{ route('formCitaEdit', ['id' => $cita->id_cita]) }}">
                        Editar
                    </a>
                    <a class="botonAA btn bg-danger text-white m-auto"
                        onclick="eliminarCita2({{ $cita->id_cita }}, '{{ $nameAux }}', '{{ $cita->date_ini }}')">
                        borrar
                    </a>
                </div>

                <form id="deleteForm2" action="" method="POST" style="display: none;">
                    @csrf
                    @method('DELETE')
                </form>
            </div>
        @endforeach

    </div>
</div>
<script>
    function eliminarCita2(idCita, nombre, date_ini) {
        fechaAux = new Date(date_ini);
        $textoConfirm = idCita + "¿Estás seguro de que quieres eliminar la cita de " + nombre + " para el " + fechaAux
            .getDate() + "/" + (fechaAux.getMonth() + 1) + " a las " + String(fechaAux.getHours()).padStart(2, '0') +
            ":" + String(fechaAux.getMinutes()).padStart(2, '0') + " ?";
        if (confirm($textoConfirm)) {
            let form = document.getElementById("deleteForm2");
            form.action = `/borraCita/${idCita}`;
            form.submit();
        }
    }
</script>

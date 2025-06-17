
<div class="horarioTodo m-auto" id="horarioTodo">
    @php
        $horas = [];
        $horaInicio = 540;
        $horaFin = 1260;
        for ($minutos = $horaInicio; $minutos < $horaFin; $minutos += 30) {
            $horas[] = sprintf('%02d:%02d', intdiv($minutos, 60), $minutos % 60);
        }
    @endphp

    <div class="d-flex flex-row justify-content-between">
        <div class="buscaSemana">
            <input class="bg-dark text-white" type="week" id="selectorSemana">
            <button id="busca" class="btn botonAzul text-white">Busca</button>
        </div>
    </div>

    <div class="horario m-2 bg-dark text-white" id="horario">
        <div class="bg-dark text-white" style="grid-column: 1; grid-row: 1"></div>
        <div class="dia bg-dark text-white" style="grid-column: 2 / span 2; grid-row: 1">Lunes<br></div>
        <div class="dia bg-dark text-white" style="grid-column: 4 / span 2; grid-row: 1">Martes<br></div>
        <div class="dia bg-dark text-white" style="grid-column: 6 / span 2; grid-row: 1">Miércoles<br></div>
        <div class="dia bg-dark text-white" style="grid-column: 8 / span 2; grid-row: 1">Jueves<br></div>
        <div class="dia bg-dark text-white" style="grid-column: 10 / span 2; grid-row: 1">Viernes<br></div>
        <div class="dia bg-dark text-white" style="grid-column: 12 / span 2; grid-row: 1">Sábado<br></div>



        @foreach ($horas as $hora)
            <div class="hora bg-dark text-white" style="grid-column: 1; grid-row: {{ $loop->index + 2 }};">
                {{ $hora }}
            </div>
        @endforeach

        @foreach ($citasSemana as $cita)
            @php
                $duracion = ceil((strtotime($cita[2]) - strtotime($cita[1])) / 1800);
            @endphp

            <button class="cita fondoAux text-center text-white btn gab{{ $cita[5] }} d-flex flex-column p-0"
                onclick="window.location.href='{{ route('panelCliente', ['id' => $cita[6]]) }}'"
                style="
                grid-column: {{ date('N', strtotime($cita[1])) * 2 + $cita[5] - 1 }};
                grid-row: {{ (date('H', strtotime($cita[1])) - 9) * 2 + floor(date('i', strtotime($cita[1])) / 30) + 2 }} / span {{ $duracion }};">
                <strong class="mb-0 mt-1 nombreAux">{{ $cita[3] }}</strong>
                <p class="mb-0 mx-2 descAux">{{ $cita[4] }}</p>
                <p class="mb-1 horaAux text-center">{{ date('H:i', strtotime($cita[1])) }} -
                    {{ date('H:i', strtotime($cita[2])) }}</p>
            </button>
        @endforeach

    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function() {

        let semana = new Date("{{ $semana }}");
        añadeHorario(semana);

        function añadeHorario(fecha) {
            let diaAux = new Date(fecha);
            let day = diaAux.getDay();
            let diff = day === 0 ? -6 : 1 - day;
            diaAux.setDate(diaAux.getDate() + diff);
            const meses = ["enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto",
                "septiembre", "octubre", "noviembre", "diciembre"
            ];
            let dias = document.querySelectorAll(".dia");
            dias.forEach(diaSem => {
                diaSem.innerText = diaSem.innerText + "" + diaAux.getDate() + " de " + meses[diaAux
                    .getMonth()];
                diaAux.setDate(diaAux.getDate() + 1);
            });

        }

        function actualizarHorario(fecha) {
            fetch(`/horario/ajax/${fecha}`)
                .then(response => response.json())
                .then(data => {
                    let hijoViejo = document.getElementById("horarioTodo");
                    let hijoNuevo = document.createElement('div');
                    hijoNuevo.id = "horarioTodo";
                    hijoNuevo.innerHTML = data.html
                    hijoViejo.replaceWith(hijoNuevo.firstElementChild);

                    let fechaSucia = fecha.split("-W");
                    let año = parseInt(fechaSucia[0]);
                    let sem = parseInt(fechaSucia[1]);
                    let dia1 = new Date(año, 0, 1);
                    let sumaDias = (sem - 1) * 7;
                    semana = new Date(dia1.setDate(dia1.getDate() + sumaDias));
                    añadeHorario(semana);
                    actualizarEventos();

                })
                .catch(error => console.error('Error cargando la semana:', error));
        }

        function actualizarEventos() {
            document.getElementById("busca").addEventListener("click", function() {

                let fecha = document.getElementById("selectorSemana").value;
                if (fecha) {
                    actualizarHorario(fecha);
                } else {
                    alert("Selecciona una fecha");
                }
            });
        }
        actualizarEventos();
    });
</script>

@extends('layouts.app')

@section('content')
    <div class="">
        <div class="d-flex flex-column gap-2 m-auto align-items-center">

            <h1>Selecciona el dia</h1>
            <input type="date" id="dia" class="bg-dark text-white">

            <button class="botonAzul btn text-white" id="botonDia">Buscar</button>

            <div class="d-flex flex-column gap-2 m-auto" id="huecoDia"></div>
        </div>
    </div>

    <script>
        function buscaCitasDia(dia) {
            fetch(`/buscaCitasDia/${dia}`)
                .then(response => response.json())
                .then(data => {
                    let divResul = document.getElementById("huecoDia");
                    divResul.innerHTML = data.html;
                })
                .catch(error => console.error('Error cargando la semana:', error));

        }
        document.addEventListener("DOMContentLoaded", function() {
            let dia = "{{ $dia }}";
            buscaCitasDia(dia);
            document.getElementById("botonDia").addEventListener("click", function() {
                let dia = document.getElementById("dia").value;
                if (dia) {
                    buscaCitasDia(dia);
                } else {
                    alert("Selecciona un dia");
                }
            });
        });
    </script>
@endsection

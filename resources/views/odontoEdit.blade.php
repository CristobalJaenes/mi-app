@extends('layouts.app')
@section('content')
    <div class="editOdont">

        <div class="d-flex flex-row justify-content-between mb-2">
            <h1>Editando odontograma de {{ $nombre }}</h1>
            <div>
                <a href="{{ route('panelCliente', ['id' => $id]) }}"
                    class="btn botonAzul text-white justify-content-center m-auto">Volver al perfil</a>
            </div>
        </div>

        <div class="odontoCont mb-3">
            @include('partials.odonto')
        </div>

        <form method="GET" action="{{ route('editaOdonto', ['id' => $id]) }}" class="d-flex flex-wrap">
            @csrf
            <div class="form-group w-100">
                <label for="selecciona" class="my-3">
                    <h2> Selecciona que quieres editar </h2>
                </label>
                <select name="objet" id="objet" class="form-control bg-dark text-white"></select>
            </div>
            <div class="form-group w-50 text-center mt-3" id="estadoN"></div>
            <div class="form-group w-50 text-center mt-3" id="desc"></div>
            <div class="form-group w-100 text-center mt-3" id="desc2"></div>

            <div class="form-group text-center w-100 mt-3">
                <button type="submit" class="btn text-white botonAzul">Editar</button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            let todoBoca2 = @json($bocaCliente);
            let sele = document.getElementById("objet");
            sele.addEventListener("change", cambiaDiente);

            let dientes = [];
            if (todoBoca2 != null) {
                let dientesAux = todoBoca2.estado;
                if (dientesAux == null) {
                    dientesAux = "";
                }
                Object.entries(dientesAux).forEach(([key, diente]) => {
                    dientes.push([
                        key,
                        diente["estado"],
                        diente["desc"],
                    ]);
                });
            }

            function cambiaDiente() {
                let desc = document.getElementById("desc");
                let estado = document.getElementById("estadoN");
                let desc2 = document.getElementById("desc2");
                estado.innerHTML = "";
                desc.innerHTML = "";
                desc2.innerHTML = "";
                if (sele.value == "obser") {
                    let descAux2 = document.createElement("textArea");
                    descAux2.setAttribute("id", "obser");
                    descAux2.setAttribute("name", "obser");
                    descAux2.classList.add("bg-dark", "text-white");
                    if (todoBoca2 == null) {
                        descAux2.innerText = "";
                    } else {
                        descAux2.innerText = todoBoca2.obser;
                    }

                    desc2.appendChild(descAux2);
                } else {
                    let estadoAux = document.createElement("select");
                    estadoAux.setAttribute("id", "estadoObj");
                    estadoAux.setAttribute("name", "estadoObj");
                    estadoAux.classList.add("bg-dark", "text-white");
                    let estados = ["Normal", "En tratamiento", "Grave", "Ausente"];
                    let estadoAux2;
                    dientes.forEach(diente => {
                        if (sele.value == diente[0]) {
                            estadoAux2 = diente[1];
                        }
                    });
                    for (let a = 0; a < 4; a++) {
                        let opti = document.createElement("option");
                        opti.setAttribute("value", (a + 1));
                        opti.innerText = estados[a];

                        if (a + 1 == estadoAux2) {
                            opti.selected = true;
                        }

                        estadoAux.appendChild(opti);
                    }
                    let textEst = document.createElement("h2");
                    textEst.innerText = "Estado";
                    let textDesc = document.createElement("h2");
                    textDesc.innerText = "Descripción"
                    let descAux = document.createElement("textArea");
                    descAux.classList.add("bg-dark", "text-white");
                    descAux.setAttribute("id", "descObj");
                    descAux.setAttribute("name", "descObj");
                    dientes.forEach(diente => {
                        if (sele.value == diente[0]) {
                            descAux.innerText = diente[2];
                        }
                    });

                    estado.appendChild(textEst);
                    estado.appendChild(estadoAux);
                    desc.appendChild(textDesc);
                    desc.appendChild(descAux);
                }
            }

            function rellenaSelect() {
                let opti = document.createElement("option");
                opti.setAttribute("value", "obser");
                opti.innerText = "Observaciones";
                sele.appendChild(opti);

                creaOption(18, 11, -1);
                creaOption(21, 28, 1);
                creaOption(48, 41, -1);
                creaOption(31, 38, 1);
            }

            function creaOption(inicio, fin, aux) {
                let sele = document.getElementById("objet");
                for (let aa = inicio; aux > 0 ? aa <= fin : aa >= fin; aa += aux) {
                    let opt = document.createElement("option");
                    opt.setAttribute("value", aa);
                    opt.innerText = aa;
                    sele.appendChild(opt);
                }
            }
            rellenaSelect();
            cambiaDiente();
        });
    </script>
@endsection

    <div>
        <div class="todoBoca d-flex flex-row ">
            <div class="odontograma bg-dark text-white m-auto" id="odonto">
            </div>
            <div class="descBoca" id="descBoca">
                <div class="obser" id="obser"></div>
                <div class="estado" id="estado"></div>
            </div>
        </div>
    </div>
    <script>
        function rellenaHueco(inicio, fin, fila, aux, dientes) {
            let odonto = document.getElementById("odonto");
            let col;
            if ((inicio == 21) || (inicio == 31)) {
                col = 9;
            } else {
                col = 1;
            }
            let relle = false;
            for (let aa = inicio; aux > 0 ? aa <= fin : aa >= fin; aa += aux) {
                relle = false;
                let hueco = document.createElement("div");
                hueco.setAttribute("class", "huecoDiente");
                let num = document.createElement("p");
                num.innerText = aa;
                let imag = document.createElement("img");
                imag.setAttribute("class", "imgDiente");
                hueco.appendChild(num);
                let enlaceAux = "";
                dientes.forEach(diente => {
                    if (diente[0] == aa) {
                        relle = true;
                        enlaceAux += devuelveDiente1(diente);
                    }
                });
                if (relle == false) {
                    enlaceAux = devuelveDiente2(aa);
                }

                imag.src = `{{ asset('images/${enlaceAux}.png') }}`;
                if ((enlaceAux.charAt(enlaceAux.length - 1)) === "4") {
                    imag.setAttribute("style", "visibility: hidden");
                }
                hueco.setAttribute("style", `grid-row: ${fila}; grid-column: ${col};`);
                col++;
                hueco.appendChild(imag);
                odonto.appendChild(hueco);
            }
        }

        function rellenaBoca() {
            let todoBoca = @json($bocaCliente);
            let dientes = [];
            let estado = document.getElementById("estado");
            let observ = document.getElementById("obser");
            if (todoBoca != null) {
                let dientesAux = todoBoca.estado;
                if (dientesAux == "null") {
                    dientesAux = null;
                }
                if (dientesAux != null) {
                    Object.entries(dientesAux).forEach(([key, diente]) => {
                        dientes.push([
                            key,
                            diente["estado"],
                            diente["desc"],
                        ]);
                    });
                }

                
                let tituObser = document.createElement("h1");
                tituObser.innerText = "Observaciones";
                observ.appendChild(tituObser);
                
                if (todoBoca.obser) {
                    let textoObser = document.createElement("p");
                    textoObser.innerText = todoBoca.obser;
                    observ.appendChild(textoObser);
                }

                
                dientes.forEach(diente => {
                    if (diente != null) {
                        if (diente[2] != null) {
                            let contDiente = document.createElement("div");
                            let tituDiente = document.createElement("h3");
                            tituDiente.innerText = diente[0]
                            let textoDiente = document.createElement("p");
                            textoDiente.innerText = diente[2];

                            contDiente.appendChild(tituDiente);
                            contDiente.appendChild(textoDiente);
                            contDiente.setAttribute("class", "contDiente");

                            estado.appendChild(contDiente);
                        }

                    }

                });
            }
            rellenaHueco(18, 11, 1, -1, dientes);
            rellenaHueco(21, 28, 1, 1, dientes);
            rellenaHueco(48, 41, 2, -1, dientes);
            rellenaHueco(31, 38, 2, 1, dientes);

            let descBoca = document.getElementById('descBoca');
            if ((observ.children.length > 2) && (!estado.hasChildNodes())) {
                descBoca.style.display = 'none';
            }

        }

        function devuelveDiente1(diente) {
            let tipo = diente[0] % 10;
            let nombre = "";
            if ((8 >= tipo) && (tipo >= 6)) {
                nombre += "molar";
            }
            if ((5 >= tipo) && (tipo >= 4)) {
                nombre += "premolar";
            }
            if (tipo == 3) {
                nombre += "canino";
            }
            if ((2 >= tipo) && (tipo >= 1)) {
                nombre += "incisivo";
            }

            if (diente[1] != 1) {
                nombre += diente[1];
            }

            return nombre;
        }

        function devuelveDiente2(diente) {
            let tipo = diente % 10;
            let nombre = "";
            if ((8 >= tipo) && (tipo >= 6)) {
                nombre += "molar";
            }
            if ((5 >= tipo) && (tipo >= 4)) {
                nombre += "premolar";
            }
            if (tipo == 3) {
                nombre += "canino";
            }
            if ((2 >= tipo) && (tipo >= 1)) {
                nombre += "incisivo";
            }
            return nombre;
        }
        rellenaBoca();
    </script>

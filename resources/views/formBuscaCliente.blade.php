@extends('layouts.app')

@section('content')
    <div class="fullBuscaCliente d-flex flex-column ">
        <div class="formBuscaCliente">
            <h1 class="mb-3">Buscando cliente</h1>
            <h2 class="mb-3">Introduce nombre, telefono, email o DNI</h2>
            <div class="subBusca">
                <input class="bg-dark text-white" type="text" id="textoBusca" placeholder="Buscar cliente...">
            </div>
        </div>

        <div class="resultadoBusca d-flex flex-column gap-2 mt-3" id="resultadoBusca">
            @foreach ($clientes as $cliente)
                <a class="btn botonAzul text-white p-3 d-flex flex-row"
                    href="{{ route('panelCliente', ['id' => $cliente->id_persona]) }}">
                    <p class="col fs-4 my-2">{{ $cliente->nombre }}</p>
                    <p class="col my-2">{{ $cliente->tlf }}</p>
                    <p class="col my-2">{{ $cliente->email }}</p>
                    <p class="col my-2">{{ $cliente->DNI }}</p>
                </a>
            @endforeach
        </div>

    </div>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('textoBusca').addEventListener('input', function() {
                let texto = document.getElementById("textoBusca").value;

                fetch(`/buscaCliente/${texto}`)
                    .then(response => response.json())
                    .then(data => {
                        let lista = document.getElementById("resultadoBusca");
                        lista.innerHTML = "";
                        data.forEach(cliente => {
                            let contCliente = document.createElement("a");
                            contCliente.innerHTML =
                                `<p class="col fs-4 my-2">${cliente.nombre}</p>
                        <p class="col my-2">${cliente.tlf}</p>
                        <p class="col my-2">${cliente.email}</p>
                        <p class="col my-2">${cliente.DNI}</p>`;
                            contCliente.classList.add("btn", "botonAzul", "p-3", "d-flex",
                                "flex-row", "text-white");
                            const rutaCliente = "{{ url('/client') }}";
                            contCliente.setAttribute("href",
                                `${rutaCliente}/${cliente.id_persona}`);
                            lista.appendChild(contCliente);
                        });
                    });
            });
        });
    </script>
@endsection

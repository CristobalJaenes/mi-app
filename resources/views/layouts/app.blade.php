<!DOCTYPE html>
<html lang="es">

<head>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SmileTrack</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">

</head>

<body class="d-flex flex-column bg-dark text-white">
    <div class="top w-100">

        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mb-2 logo">
        </a>

        <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
            <h3 class="text-lg font-semibold text-gray-700">
                Clinica dental La Muelita
            </h3>
            <div x-data="{ hora: new Date().toLocaleTimeString() }" x-init="setInterval(() => hora = new Date().toLocaleTimeString(), 1000)"
                class="bg-gray-100 p-4 rounded-lg shadow-md text-center text-lg font-semibold text-gray-700">
                <span x-text="hora"></span>
            </div>
        </div>

        <div class="usuario d-flex flex-column gap-2">
            <div class="d-flex flex-row gap-2">
                @isset($nombreUsuario)
                    <p class="me-2">Sesión: {{ $nombreUsuario }}</p>
                @endisset

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">
                        Cerrar Sesión
                    </button>
                </form>
            </div>

            <div class="d-flex flex-row ">
                <div class="col mx-3 ">
                    @if (auth()->user()->esAdmin())
                        <a class="btn  botonAzul justify-content-center text-white d-flex flex-column"
                            {{-- href="{{ route('gestUsuPass',['id'=>Auth::id()]) }}"> --}}
                            href="{{ route('gestUsuPass',['id'=>Auth::user()->userInfo->id_persona]) }}">
                            <img src="{{ asset('images/crown.png') }}" alt="corona" class="imgTop">
                            Gestionar usuarios
                        </a>
                    @endif
                </div>

                <div class="ms-3 me-0 col">
                    <a class="botonAzul btn justify-content-center text-white d-flex flex-column h-100"
                        style="padding: 10px; border: 0;" href="{{ route('ajustes') }}">
                        <img src="{{ asset('images/tuerca.png') }}" alt="tuerca" class="imgTop">
                        Ajustes de cuenta
                    </a>
                </div>
            </div>
        </div>
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto text-white">
        <p>Esta es una versión de &copy;Smiletrack para la clinica dental "La Muelita".</p>
        <a href="{{route('ayuda')}}">
            Ayuda
        </a>
    </footer>


</body>

</html>

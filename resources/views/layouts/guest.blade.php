<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SmileTrack</title>
    <link rel="stylesheet" href="{{ asset('css/todo.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="d-flex flex-column min-vh-100 bg-dark">

    <div class="bg-gray-100 p-4 rounded-lg shadow-md text-center">
        <p class="text-lg font-semibold text-gray-700 text-white">
            Clinica dental La Muelita
        </p>
    </div>

    <main class="py-4">
        @yield('content')
    </main>

    <footer class="text-center py-4 mt-auto text-white">
        <p>Esta es una versión de &copy;Smiletrack para la clinica dental "La Muelita".</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.11.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.min.js"></script>


</body>

</html>

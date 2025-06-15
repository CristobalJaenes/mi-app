@extends('layouts.app')

@section('content')

    <div class="editProf">
        <form method="GET" action="{{ route('editaCliente', ['id' => $infoUser->id_persona]) }}">
            @csrf
            <h1>Editando tu perfil</h1>
            @if (session('status'))
                <div class="alert estadoAlert text-center m-auto mb-5">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alerta text-center m-auto mb-5">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="nombre">Nombre</label>
                <input type="text" class="form-control bg-dark text-white" id="nombre" name="nombre"
                    value="{{ $infoUser->nombre }}">
            </div>

            <div class="form-group mb-3">
                <label for="DNI">DNI</label>
                <input type="text" class="form-control bg-dark text-white" id="DNI" name="DNI"
                    value="{{ $infoUser->DNI }}">
            </div>

            <div class="form-group mb-3">
                <label for="tlf">Telefono</label>
                <input type="number" class="form-control bg-dark text-white" id="tlf" name="tlf"
                    value="{{ $infoUser->tlf }}">
            </div>

            <div class="form-group mb-3">
                <label for="fecha_nac">Fecha de nacimiento</label>
                <input type="date" class="form-control bg-dark text-white" id="fecha_nac" name="fecha_nac"
                    value="{{ $infoUser->fecha_nac }}">
            </div>

            <div class="form-group mb-3">
                <label for="direcc">Dirección</label>
                <input type="text" class="form-control  bg-dark text-white" id="direcc" name="direcc"
                    value="{{ $infoUser->direccion }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email</label>
                <input type="text" class="form-control  bg-dark text-white" id="email" name="email"
                    value="{{ $infoUser->email }}">
            </div>

            <div class="form-group text-center mb-3">
                <button type="submit" class="btn botonAzul text-white">Editar</button>
            </div>
        </form>

        {{-- <form method="POST" action="{{ route('cambiaEmail') }}" class="mt-2">
            @csrf
            <h2>Cambiar email</h2>

            <div class="form-group mb-3">
                <label for="nuevo_email">Nuevo email</label>
                <input type="email" class="form-control email  bg-dark text-white" name="email" required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Contraseña</label>
                <input type="password" class="form-control  bg-dark text-white" name="password" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn btn-primary bg-danger">Cambiar email</button>
            </div>
        </form> --}}

        <form method="POST" action="{{ route('password.update') }}" class="mt-2">
            @csrf
            @method('PUT')
            <h2>Cambiar contraseña</h2>
            <div class="form-group mb-3">
                <label for="current_password">Contraseña actual</label>
                <input type="password" class="form-control bg-dark text-white" name="current_password" id="current_password"
                    required>
            </div>

            <div class="form-group mb-3">
                <label for="password">Contraseña nueva</label>
                <input type="password" class="form-control bg-dark text-white" name="password" id="password" required>
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation">Contraseña nueva otra vez</label>
                <input type="password" class="form-control bg-dark text-white" name="password_confirmation"
                    id="password_confirmation" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn bg-danger text-white">Cambiar contraseña</button>
            </div>
        </form>

        <div class="mt-2">
            <h2>Eliminar mi cuenta</h2>
            <div class="text-center">
                
                <a class="botonAA btn bg-danger text-white m-auto "
                    onclick="eliminarUsu( {{ $infoUser->id_persona }}, '{{ $infoUser->nombre }}')">
                    Eliminar
                </a>
            </div>

            <form id="deleteForm" action="" method="POST" style="display: none;">
                @csrf
                @method('DELETE')
            </form>
        </div>
    </div>

    <script>
        function eliminarUsu(id, nombre) {
            $textoConfirm = "¿Estás seguro de que quieres eliminar tu cuenta?";
            if (confirm($textoConfirm)) {
                let form = document.getElementById("deleteForm");
                form.action = `/borraUsu/${id}`;
                form.submit();
            }
        }
    </script>
@endsection

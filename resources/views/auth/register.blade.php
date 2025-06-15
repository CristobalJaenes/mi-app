@extends('layouts.guest')

@section('content')

    <div class="text-center">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logoLog mb-2" >
        </a>
        <h3 class="text-white">Registrarse</h3>
    </div>
    <div>
        @if ($errors->any())
        <div class="w-100">
            <div class="alert alerta text-center m-auto">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
            
        @endif

        <form method="POST" action="{{ route('crea') }}" class="registerForm m-auto">
            @csrf

            <div class="form-group mb-3">
                <label for="nombre" class="text-white">Nombre </label>
                <input type="text" class="form-control bg-dark text-white" id="nombre" name="nombre">
            </div>

            <div class="form-group  mb-3">
                <label for="DNI" class="text-white">DNI </label>
                <input type="text" class="form-control bg-dark text-white" id="DNI" name="DNI">
            </div>

            <div class="form-group  mb-3">
                <label for="tlf" class="text-white">Telefono de contacto</label>
                <input type="number" class="form-control bg-dark text-white" id="tlf" name="tlf">
            </div>

            <div class="form-group  mb-3">
                <label for="fecha_nac" class="text-white">Fecha de nacimiento</label>
                <input type="date" class="form-control bg-dark text-white" id="fecha_nac" name="fecha_nac">
            </div>

            <div class="form-group  mb-3">
                <label for="direcc" class="text-white">Dirección </label>
                <input type="text" class="form-control bg-dark text-white" id="direcc" name="direcc">
            </div>

            <div class="form-group mb-3">
                <label for="email" class="text-white">Email</label>
                <input type="email" class="form-control bg-dark text-white" id="email" name="email"
                    placeholder="Correo electrónico" required>
            </div>

            <div class="form-group mb-3">
                <label for="password" class="text-white">Contraseña</label>
                <input type="password" class="form-control bg-dark text-white" id="password" name="password"
                    placeholder="Contraseña" required>
            </div>

            <div class="form-group mb-3">
                <label for="password_confirmation" class="text-white">Contraseña otra vez</label>
                <input type="password" class="form-control bg-dark text-white" id="password_confirmation"
                    name="password_confirmation" placeholder="Contraseña" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn botonAzul text-white">Registrarse</button>
            </div>
        </form>
    </div>
@endsection

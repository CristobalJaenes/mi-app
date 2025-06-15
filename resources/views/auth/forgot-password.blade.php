@extends('layouts.guest')

@section('content')

    <div class="text-center login-header">
        <a href="{{ route('inicio') }}">
            <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mb-2 logoLog">
        </a>
        <h3 class="text-white">Recuperar contraseña</h3>
    </div>

    <div class="">
        @if (session('status'))
            <div class="alert estadoAlert text-center m-auto mb-5">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alerta text-center m-auto mb-5">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('password.request') }}" class="forgPassForm mx-auto mt-3">
            @csrf

            <div class="form-group mb-3">
                <label for="email" class="text-white">Introduce tu email para recibir un email y poder cambiar la
                    contraseña:</label>
                <input type="email" class="form-control bg-dark text-white" id="email" name="email"
                    placeholder="Correo electrónico" required>
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn botonAzul text-white">Enviar</button>
            </div>
        </form>
    </div>
@endsection

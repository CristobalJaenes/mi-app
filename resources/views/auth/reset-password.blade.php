@extends('layouts.guest')

@section('content')

    <div class="justify-content-center align-items-center">
        <div class="text-center">
            <a href="{{ route('inicio') }}">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="mb-2 logoLog">
            </a>
            <h3>Cambiar contraseña</h3>
        </div>
        <div class="card-body login-body">
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

            <form method="POST" action="{{ route('password.store') }}" class="formResetPass m-auto">
                @csrf
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <div class="form-group mb-3">
                    <label for="email">Introduce tu email</label>
                    <input type="email" class="form-control" id="email" name="email"
                        placeholder="Correo electrónico" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password">Contraseña</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña"
                        required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirmation">Contraseña otra vez</label>
                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                        placeholder="Contraseña" required>
                </div>

                <div class="form-group text-center">
                    <button type="submit" class="btn botonAzul text-white">Entrar</button>
                </div>
            </form>
        </div>
    </div>
@endsection

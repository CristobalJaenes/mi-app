@extends('layouts.app')

@section('content')

    @if (session('status'))
        <div class="alert estado text-center m-auto mb-5">
            {{ session('status') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alerta text-center m-auto mb-5">
            <ul class="mb-0 w-100">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="formPass m-auto">
        <h1>Debes confirmar tu identidad para continuar</h1>
            <form action="{{ route($ruta, ['id' => $id]) }}" method="POST">
            @csrf

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

            <div class="form-group text-center">
                <button type="submit" class="botonAzul btn  text-white">Entrar</button>
            </div>
        </form>
    </div>

@endsection

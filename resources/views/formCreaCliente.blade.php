@extends('layouts.app')
@section('content')
    <div class="creaCliente">
        <form method="GET" action="{{ route('creaCliente') }}">
            <h1>Creando cliente</h1>
            @csrf
            @if ($errors->any())
                <div class="alert alerta text-center m-auto mb-5">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="form-group mb-3">
                <label for="nombre">Nombre </label>
                <input type="text" class="form-control bg-dark text-white" id="nombre" name="nombre">
            </div>

            <div class="form-group mb-3">
                <label for="DNI">DNI </label>
                <input type="text" class="form-control bg-dark text-white" id="DNI" name="DNI">
            </div>

            <div class="form-group mb-3">
                <label for="tlf">Telefono de contacto</label>
                <input type="number" class="form-control bg-dark text-white" id="tlf" name="tlf">
            </div>

            <div class="form-group mb-3">
                <label for="fecha_nac">Fecha de nacimiento</label>
                <input type="date" class="form-control bg-dark text-white" id="fecha_nac" name="fecha_nac">
            </div>

            <div class="form-group mb-3">
                <label for="direcc">Dirección </label>
                <input type="text" class="form-control bg-dark text-white" id="direcc" name="direcc">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email </label>
                <input type="text" class="form-control bg-dark text-white" id="email" name="email">
            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn botonAzul text-white">Crear</button>
            </div>
        </form>
    </div>
@endsection

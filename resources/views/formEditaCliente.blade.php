@extends('layouts.app')
@section('content')

    <div class="creaCliente">
        <form method="GET" action="{{ route('editaCliente', ['id' => $info->id_persona]) }}">
            <div class="d-flex flex-row justify-content-between">
                <h1>Editando a {{ $info->nombre }}</h1>
                <a class="btn m-auto botonAzul text-white justify-content-center me-0"
                    href="{{ route('panelCliente', ['id' => $info->id_persona]) }}">
                    Ir al perfil
                </a>
            </div>

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
                <input type="text" class="form-control bg-dark text-white" id="nombre" name="nombre"
                    value="{{ $info->nombre }}">
            </div>

            <div class="form-group mb-3">
                <label for="DNI">DNI </label>
                <input type="text" class="form-control bg-dark text-white" id="DNI" name="DNI"
                    value="{{ $info->DNI }}">
            </div>

            <div class="form-group mb-3">
                <label for="tlf">Telefono de contacto</label>
                <input type="number" class="form-control bg-dark text-white" id="tlf" name="tlf"
                    value="{{ $info->tlf }}">
            </div>

            <div class="form-group mb-3">
                <label for="fecha_nac">Fecha de nacimiento</label>
                <input type="date" class="form-control bg-dark text-white" id="fecha_nac" name="fecha_nac"
                    value="{{ $info->fecha_nac }}">
            </div>

            <div class="form-group mb-3">
                <label for="direcc">Dirección </label>
                <input type="text" class="form-control bg-dark text-white" id="direcc" name="direcc"
                    value="{{ $info->direccion }}">
            </div>

            <div class="form-group mb-3">
                <label for="email">Email </label>

                @if ($clienAdmin && !auth()->user()->esAdmin())
                    <p>No puedes modificar el email de un admin</p>
                    <input type="text" class="form-control bg-dark text-white" id="email" name="email"
                        value="{{ $info->email }}" readonly>
                @else
                    <input type="text" class="form-control bg-dark text-white" id="email" name="email"
                        value="{{ $info->email }}">
                @endif

            </div>

            <div class="form-group text-center">
                <button type="submit" class="btn botonAzul text-white">Editar</button>
            </div>
        </form>
    </div>
@endsection

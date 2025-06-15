@extends('layouts.guest')

@section('content')

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

    @csrf
    <div class="d-flex flex-column text-center w-50 m-auto">
        <p class="text-center">Demasiados intentos, inténtalo de nuevo en unos minutos.</p>
        <a href="{{ route('inicio') }}" class="btn botonAzul mt-3 text-white w-25 m-auto">
            Volver a Inicio
        </a>
    </div>
    
@endsection
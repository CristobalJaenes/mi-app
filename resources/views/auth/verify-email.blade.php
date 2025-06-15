@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column justify-content-center align-items-center mb-5">
        <div class="bg-dark text-white text-center login-header">
            <h2>Verifica email</h2>
        </div>
        <div class="bg-dark text-white login-body text-center">
            @csrf
            <p>Parece que aún no has verificado tu email,<br>acabamos de enviarte un correo para que puedas verificarlo.</p>
            <a href="{{ route('inicio') }}" class="btn botonAzul text-white">
                Ir a Inicio
            </a>
        </div>
    </div>
@endsection

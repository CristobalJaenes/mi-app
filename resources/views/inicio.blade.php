@extends('layouts.app')

@section('content')

    @php
        $idPersona = optional(auth()->user()->userInfo)->id_persona;
    @endphp

    <div class="d-flex flex-column justify-content-center align-items-center">

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

        @csrf
        <div class="iniAux d-flex flex-row">

            <div class="horarioAux">
                @include('partials.horario')
            </div>

            <div>
                <div class="clientMenu d-flex flex-column align-items-center gap-3">

                    <a class="btn botonAzul w-75 justify-content-center text-white d-flex flex-column"
                        href="{{ route('formCreaCliente') }}">
                        <img src="{{ asset('images/user-add-icon.png') }}" alt="addUser" class="mb-2">
                        Crear cliente
                    </a>

                    <a class="btn botonAzul w-75 justify-content-center text-white d-flex flex-column"
                        href="{{ route('formBuscaCliente') }}">
                        <img src="{{ asset('images/lupa.png') }}" alt="Lupa" class="mb-2">
                        Buscar cliente
                    </a>

                    @if (auth()->user()->esDentista())
                        <a class="btn botonAzul w-75 justify-content-center text-white d-flex flex-column"
                            href="{{ route('listaDent', ['id' => $idPersona]) }}">
                            <img src="{{ asset('images/citaUser.png') }}" alt="citas" class="mb-2">

                            Ver mis citas
                        </a>
                    @endif

                    <a class="btn botonAzul w-75 justify-content-center text-white d-flex flex-column"
                        href="{{ route('listaDent') }}">
                        <img src="{{ asset('images/dent.png') }}" alt="citas por dentista" class="mb-2">
                        Buscar citas por dentista
                    </a>

                    <a class="btn botonAzul w-75 justify-content-center text-white d-flex flex-column"
                        href="{{ route('formCitasDia') }}">
                        <img src="{{ asset('images/cita.png') }}" alt="citas" class="mb-2">
                        Buscar citas por dia
                    </a>
                </div>
            </div>

        </div>
    </div>
@endsection

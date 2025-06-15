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
        <p class="text-center text-white">Servidor en mantenimiento.</p>
    </div>

@endsection

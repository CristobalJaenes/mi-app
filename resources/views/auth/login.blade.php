 @extends('layouts.guest')

 @section('content')

     <div class="">
         <div class="text-center m-auto">
             <a href="{{ route('inicio') }}">
                 <img src="{{ asset('images/logo.jpg') }}" alt="Logo" class="logoLog mb-2" >
             </a>

             <h3 class=" text-white">LOGIN</h3>
         </div>
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
         <form method="POST" action="{{ route('login') }}"  class="formLogin m-auto">
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

         <div class="text-center mt-3">
             <a href="{{ route('password.request') }}" class="botonAzul btn text-white">He olvidado mi contraseña</a>

             <a href="{{ route('register') }}" class="botonAzul btn text-white">Registrarse</a>
         </div>
     </div>
 @endsection

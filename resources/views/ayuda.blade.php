@extends('layouts.guest')

@section('content')
    <div class="editProf text-white">
        <h1>Ayuda de la aplicación</h1>
        <p>Bienvenido a la ayuda online de Smiletrack</p>

        <h2>Buscar cliente</h2>
        <p>Para buscar un cliente tenemos un boton en la página de inicio.</p>

        <h2>Usuario nuevo</h2>
        <p>Los usuarios nuevos, tanto si se han registrado en la pantalla de login como si es un cliente convertido en
            usuario, al iniciar sesión no podrá acceder a ninguna página hasta que un administrador le otorgue permisos.</p>

        <h2>Crear / editar una cita</h2>
        <p>Para crear una cita debemos hacerlo desde el perfil del cliente y para editar una cita solo debemos pulsar el
            botón "editar" en cualquier página en la que aparezca esa cita. Si no hay ningun dentista activo no podremos dar
            citas.</p>

        <h2>Crea / edita cliente</h2>
        <p>Para crear un cliente tenemos un boton en la página de inicio y para editarlo solo debemos ir a su perfil.</p>

        <h2>Editar odontograma de paciente</h2>
        <p>Para esto necesitamos permiso de dentista o admin. En el perfil de cliente en la parte inferior veremos el
            odontograma del paciente con su respectivo botón para editar.</p>

        <h2>Convertir cliente en usuario</h2>
        <p>Si somos admin podemos convertir un cliente en usuario y sus credenciales de acceso serán su email y DNI se su
            ficha paciente.</p>

        <div class="text-center">
            <a href="{{ asset('manual/Smiletrack_manual.pdf') }}" target="_blank" class="btn botonAzul text-white m-auto">
                Ver manual completo
            </a>
        </div>
    </div>
@endsection

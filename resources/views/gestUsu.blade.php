@extends('layouts.app')

@section('content')
    <div class="gestUsuCont d-flex flex-column">

        <div class="row">
            <form method="GET" action="" id="gestUsuBusca">
                @csrf
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
                <h1>Selecciona un usuario para modificar sus permisos</h1>
                <select name="id_per" id="id_per" class="form-control bg-dark text-white mt-3"
                    onchange="buscaUser()">

                    @foreach ($todoUsu as $usu)
                        <option value="{{ $usu[0] }}" {{ $infoCliente->id_persona == $usu[0] ? 'selected' : '' }}>
                            {{ $usu[1]['nombre'] }} - {{ $usu[1]['email'] }}
                        </option>
                    @endforeach

                </select>
            </form>
        </div>
        <div class="row d-flex flex-row">

            <div class="col mt-4 me-1 p-0">
                @include('partials.infoCliente')
                <div class="text-center">
                    <a class="btn botonAzul text-white m-auto"
                        href="{{ route('panelCliente', ['id' => $infoCliente->id_persona]) }}">
                        Ver perfil
                    </a>
                </div>

            </div>

            <div class="col mt-4 mx-5">
                <form action="{{ route('modPerm', ['id' => $infoCliente->id_persona]) }}">
                    <h2>Permisos</h2>

                    <div class="form-check ms-3">
                        <label for="recep">Recepcionista</label>
                        <input type="checkbox" name="recep" id="recep" class="form-check-input"
                            {{ $perm['recepcionista'] == 1 ? 'checked' : '' }}>
                    </div>

                    <div class="form-check ms-3">
                        <label for="denti">Dentista</label>
                        <input type="checkbox" name="denti" id="denti" class="form-check-input"
                            {{ $perm['dentista'] == 1 ? 'checked' : '' }}>
                    </div>

                    <div class="form-check ms-3">
                        <label for="admin">Admin</label>
                        <input type="checkbox" name="admin" id="admin" class="form-check-input"
                            {{ $perm['admin'] == 1 ? 'checked' : '' }}>
                    </div>

                    <div class="form-group mt-3 ms-5">
                        <button type="submit" class="btn botonAzul text-white">Aplicar</button>
                    </div>


                </form>

                <div class="mt-3">
                    <h2>Eliminar como usuario</h2>
                    <a class="botonAA btn bg-danger text-white ms-5"
                        onclick="eliminarUsu( {{ $infoCliente->id_persona }}, '{{ $infoCliente->nombre }}')">
                        Eliminar usuario
                    </a>
                    <form id="deleteForm" action="" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>

                <div class="mt-3">
                    <h2>Eliminar como usuario y cliente</h2>
                    <a class="botonAA btn bg-danger text-white ms-5"
                        onclick="eliminarUsu2( {{ $infoCliente->id_persona }}, '{{ $infoCliente->nombre }}')">
                        Eliminar como usuario y cliente
                    </a>
                    <form id="deleteForm2" action="" method="POST" style="display: none;">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>


        </div>
    </div>
    <script>
        function buscaUser() {
            $idPerUser = document.getElementById('id_per').value;
            $form = document.getElementById('gestUsuBusca');
            $form.action = '/gestUsu/' + $idPerUser;
            $form.submit();
        }

        function eliminarUsu(id, nombre) {
            $textoConfirm = "¿Estás seguro de que quieres eliminar a " + nombre +
                " como usuario y mantenerlo como cliente?";
            if (confirm($textoConfirm)) {
                let form = document.getElementById("deleteForm");
                form.action = `/borraUsu/${id}`;
                form.submit();
            }
        }

        function eliminarUsu2(id, nombre) {
            $textoConfirm = "¿Estás seguro de que quieres eliminar a " + nombre + " como usuario y cliente?";
            if (confirm($textoConfirm)) {
                let form = document.getElementById("deleteForm2");
                form.action = `/borraUsu2/${id}`;
                form.submit();
            }
        }
    </script>
@endsection

<div class="info d-flex flex-wrap">
    <h1 class="w-50">Información del cliente</h1>
    <a class="botonEditarCliente btn botonAzul w-50 justify-content-center text-white m-auto me-3 be-2"
        href="{{ route('formEditaCliente', ['id' => $infoCliente->id_persona]) }}">
        Editar informacion
    </a>
    <h2 class="w-50 ms-2">{{ $infoCliente->nombre }}</h2>

    @if (!$esUser)
        <a class="botonDele btn bg-danger text-white m-auto me-4 w-25"
            onclick="eliminarCliente({{ $infoCliente->id_persona }}, '{{ $infoCliente->nombre }}')">
            Eliminar cliente
        </a>
    @endif

    <form id="deleteForm" action="" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <p class="w-100 ms-4">{{ $infoCliente->email }}</p>
    <p class="w-100 ms-4">{{ $infoCliente->DNI }}</p>
    <p class="w-100 ms-4">{{ $infoCliente->tlf }}</p>
    <p class="w-100 ms-4">{{ $infoCliente->direccion }}</p>
    <p class="w-100 ms-4">{{ \Carbon\Carbon::parse($infoCliente->fecha_nac)->format('d/m/Y') }}</p>
    {{-- {{ \Carbon\Carbon::parse($dia)->format('d/m/Y') }} --}}
</div>

<script>
    function eliminarCliente(idPer, nombre) {
        $textoConfirm = "¿Estás seguro de que quieres eliminar a " + nombre + " y todas sus citas?";
        if (confirm($textoConfirm)) {
            let form = document.getElementById("deleteForm");
            form.action = `/borraCliente/${idPer}`;
            form.submit();
        }
    }
</script>

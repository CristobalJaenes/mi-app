<!DOCTYPE html>
<html lang="es">
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<style>
    #logo {
        width: 100px;
        height: auto;
        margin: 30px;
        border-radius: 10px;
    }

    th,
    td {
        text-align: center
    }

    table {
        width: 100%;
        border-spacing: 5px;
    }

    #header {
        text-align: center;
    }
</style>

<head>
    <title>Citas de {{ $infoCliente->nombre }}</title>
</head>

<body>
    <div id="header">
        <img src="{{ public_path('images/logo.jpg') }}" alt="Logo" id="logo">
        <h2>Listado de citas de cliente</h2>
    </div>

    <h1>Citas de {{ $infoCliente->nombre }}</h1>

    <table>
        <thead>
            <th>Fecha</th>
            <th>Dentista</th>
            <th>Descripcion</th>
            <th>Precio</th>
        </thead>

        <tbody>
            @foreach ($citasCliente as $cita)
                <tr>
                    <td>
                        {{ date('d/m/Y', strtotime($cita->date_ini)) }}
                        {{ date('H:i', strtotime($cita->date_ini)) }} - {{ date('H:i', strtotime($cita->date_fin)) }}
                    </td>
                    <td>
                        @php
                            $nombreDent = null;
                            foreach ($fullDent as $denti) {
                                if ($denti[0] == $cita->id_dent) {
                                    $nombreDent = $denti[1];
                                }
                            }
                        @endphp
                        @if ($nombreDent)
                            <p>{{ $nombreDent }}</p>
                        @else
                            <p>Dentista eliminado</p>
                        @endif
                    </td>
                    <td>
                        {{ $cita->descri }}
                    </td>
                    <td>{{ $cita->precio }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>


</html>

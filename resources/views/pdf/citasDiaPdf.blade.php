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
    <title>Citas del {{ date('d/m/Y', strtotime($dia)) }}</title>
</head>

<body>
    <div id="header">
        <img src="{{ asset('images/logo.jpg') }}" alt="Logo" id="logo">
        <h2>Listado de citas del dia</h2>
    </div>

    <h1>Citas del {{ date('d/m/Y', strtotime($dia)) }}</h1>

    <table>
        <thead>
            <th>Fecha</th>
            <th>Descripcion</th>
            <th>Cliente</th>
            <th>Dentista</th>
            <th>Precio</th>
        </thead>

        <tbody>

            @foreach ($citasHoy as $cita)
                @foreach ($nombresClientes as $nombreClie)
                    @if ($cita->id_client == $nombreClie[0])
                        @php
                            $nameAux = $nombreClie[1];
                        @endphp
                    @endif
                @endforeach

                @foreach ($nombresDent as $nombreDent)
                    @if ($cita->id_dent == $nombreDent[0])
                        @php
                            $nameAux2 = $nombreDent[1];
                        @endphp
                    @endif
                @endforeach
                <tr>
                    <td>
                        {{ date('d/m/Y', strtotime($cita->date_ini)) }}
                        {{ date('H:i', strtotime($cita->date_ini)) }} - {{ date('H:i', strtotime($cita->date_fin)) }}
                    </td>
                    <td>
                        {{ $cita->descri }}
                    </td>
                    <td>
                        {{ $nameAux }}
                    </td>
                    <td>
                        {{ $nameAux2 }}
                    </td>
                    <td>
                        {{ $cita->precio }}€
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>


</html>

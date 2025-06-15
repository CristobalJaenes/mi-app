@extends('layouts.app')

@section('content')
    <div class="listaDent">

        <form method="GET" id="formDent">
            @csrf
            <h1>Selecciona un dentista para ver sus citas</h1>
            <select id="dent" name="dent" class="form-control bg-dark text-white mb-3">
                @foreach ($fullDent as $dent)
                    <option value="{{ $dent[0] }}">{{ $dent[1] }}</option>
                @endforeach
            </select>
        </form>

        <div id="listaCitas" >
        </div>

    </div>

    <script>
        function buscaCitas() {
            let idDent = document.getElementById("dent").value;
            fetch(`/citasIdDent/${idDent}`)
                .then(response => response.json())
                .then(data => {
                    let lista = document.getElementById("listaCitas");
                    lista.innerHTML = data.html;
                })
                .catch(error => {
                    console.error('Error cargando citas:', error);
                    let lista = document.getElementById("listaCitas");
                    lista.innerHTML = "<p class='text-danger'>Error cargando citas</p>";
                });
        }
        document.addEventListener('DOMContentLoaded', function() {
            buscaCitas();

            document.getElementById('dent').addEventListener('change', function() {
                buscaCitas();
            });
        });
    </script>
@endsection

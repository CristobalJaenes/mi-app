<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Cita;
use Carbon\Carbon;
use App\Models\Informacion;
use App\Models\Dentista;

class CitasController extends Controller
{
    public function getHorarioAjax($fecha)
    {
        $citasSemana = $this->getCitasSemana($fecha);
        $semana = Carbon::parse($fecha)->format('Y-m-d H:i:s');
        return response()->json([
            'html' => view('partials.horario', compact('citasSemana', 'semana'))->render(),
        ]);
    }

    public static function getCitasSemana($fecha = null)
    {
        $inicioSemana = $fecha ? Carbon::parse($fecha)->startOfWeek() : now()->startOfWeek();
        $finSemana = $inicioSemana->copy()->addDays(5)->endOfDay();
        $citas = Cita::whereBetween('date_ini', [$inicioSemana, $finSemana])
            ->orderBy('date_ini')
            ->get();
        $nombres = Informacion::whereIn('id_persona', $citas->pluck('id_client'))->pluck('nombre', 'id_persona')->toArray();
        $citasComp = [];
        foreach ($citas as $cita) {
            $citasComp[] = [$cita->id_cita, $cita->date_ini, $cita->date_fin, $nombres[$cita->id_client] ?? "error", $cita->descri, $cita->gab, $cita->id_client];
        }
        return $citasComp;
    }

    public function CitasIdDent($id)
    {
        $auxaa = Informacion::findOrFail($id);
        $nombreDent = Informacion::where('id_persona', $id)->value('nombre');
        $fechaHoy = Carbon::today();
        $fechaMañana = Carbon::tomorrow();

        $citasHoy = Cita::where('id_dent', $id)->whereDate('date_ini', $fechaHoy)->orderBy('date_ini')->get();
        $citasFuturas = Cita::where('id_dent', $id)->whereDate('date_ini', '>=', $fechaMañana)->orderBy('date_ini')->get();
        $citasPasadas = Cita::where('id_dent', $id)->whereDate('date_ini', '<', $fechaHoy)->orderBy('date_ini')->get();
        $nombresClientes = [];
        foreach ($citasHoy as $cita) {
            $idAux = $cita->id_client;
            $esta = false;
            foreach ($nombresClientes as $nombre) {
                if ($nombre[0] == $idAux) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
                $nombresClientes[] = [$idAux, $nombreAux];
            }
        }

        foreach ($citasFuturas as $cita) {
            $idAux = $cita->id_client;
            $esta = false;
            foreach ($nombresClientes as $nombre) {
                if ($nombre[0] == $idAux) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
                $nombresClientes[] = [$idAux, $nombreAux];
            }
        }

        foreach ($citasPasadas as $cita) {
            $idAux = $cita->id_client;
            $esta = false;
            foreach ($nombresClientes as $nombre) {
                if ($nombre[0] == $idAux) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
                $nombresClientes[] = [$idAux, $nombreAux];
            }
        }
        return response()->json([
            'html' => view('partials.citasId', compact('citasHoy', 'citasFuturas', 'citasPasadas', 'nombreDent', 'nombresClientes','id'))->render(),
        ]);
    }

    public function formCita($id)
    {
        $nombreClient = Informacion::obtenerPorId($id)?->nombre;
        $fullDent = Dentista::obtenerTodosConNombre();
        $semana = Carbon::now()->format('Y-m-d H:i:s');
        $citasSemana = $this->getCitasSemana();
        if ($fullDent == []) {
            return redirect()->back()->withErrors(['Dentista' => 'No hay dentistas activos.']);;
        }
        return view("formCita", compact("nombreClient", 'id', "fullDent", "citasSemana", 'semana'));
    }

    public function checkSolapa($inicioFix, $finFix, $gab, $dia, $idCita)
    {
        $citasDelDia = Cita::whereBetween('date_ini', [Carbon::parse("$dia 9:00:00"), Carbon::parse("$dia 21:00:00")])
            ->orderBy('date_ini')
            ->get();
        $solapa = false;
        foreach ($citasDelDia as $cita1) {
            if ($cita1["date_ini"] < $finFix) {
                if ($inicioFix < $cita1["date_fin"]) {
                    if ($cita1["gab"] == $gab) {
                        if (($idCita == false) || ($cita1["id_cita"] != $idCita)) {
                            if ($solapa == false) {
                                $solapa = true;
                            }
                        }
                    }
                }
            }
        }
        return $solapa;
    }

    public function creaCita(Request $request, $id)
    {
        $persona = Informacion::obtenerPorId($id);
        $request->validate([
            'inicio' => 'required|date_format:H:i',
            'fin' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) <= strtotime(request('inicio'))) {
                        $fail('La hora de fin debe ser mayor que la hora de inicio.');
                    }
                },
            ],
            'dia' => ['required', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->dayOfWeek === 0) {
                    $fail('No se pueden seleccionar domingos.');
                }
            }]
        ], [
            'dia.required' => 'Debes escoger el dia de la cita'
        ]);

        $dia = $request->input('dia');
        $inicio = $request->input('inicio') . ":00";
        $fin = $request->input('fin') . ":00";
        $gab = $request->input('gab');

        $inicioFix = Carbon::parse("$dia $inicio");
        $finFix = Carbon::parse("$dia $fin");

        $solapa = $this->checkSolapa($inicioFix, $finFix, $gab, $dia, false);

        if ($solapa) {
            return redirect()->back()->withInput()->withErrors(['Hueco' => 'Ese hueco está ocupado']);
        } else {
            Cita::crearCita([
                'dent' => $request->dent,
                'id_client' => $id,
                'desc' => $request->desc,
                'precio' => $request->precio,
                'gab' => $request->gab,
                'inicio' => $inicioFix,
                'fin' => $finFix,
            ]);

            $nombre = Informacion::where('id_persona', $id)->value('nombre');

            $fecha2 = explode('-', $dia);
            $fechaInversa = array_reverse($fecha2);
            $fechaString = implode('/', $fechaInversa);

            session()->flash('status', 'Cita para ' . $nombre . ' fechada el ' . $fechaString . ' a las ' . $inicioFix->format('H:i'));
            return redirect()->route('panelCliente', ['id' => $id]);
        }
        // session()->flash('status', 'Error');
        // return redirect()->route('panelCliente', ['id' => $id]);
    }

    public function borraCita($idCita)
    {
        if (!Cita::eliminarPorId($idCita)) {
            return redirect()->back()->withErrors(['Error' => 'Error, intentalo otra vez.']);
        } else {
            return redirect()->back()->with('status', 'Cita eliminada');
        }
    }

    public function formCitaEdit($idCita)
    {
        $cita = Cita::findOrFail($idCita);
        $nombreDent = Informacion::where('id_persona', $cita->id_dent)->value('nombre');
        $nombreClient = Informacion::where('id_persona', $cita->id_client)->value('nombre');
        $citasSemana = $this->getCitasSemana();
        $semana = Carbon::now()->format('Y-m-d H:i:s');
        $fullDent = Dentista::obtenerTodosConNombre();
        if ($fullDent == []) {
            return redirect()->back()->withErrors(['Dentista' => 'No hay dentistas activos.']);
        }
        return view("formCitaEdit", compact("nombreClient", "fullDent", "citasSemana", 'semana', 'cita', 'nombreDent'));
    }

    public function formCitasDia()
    {
        $dia = Carbon::today()->format('Y-m-d');
        return view("formCitasDia", compact('dia'));
    }

    public function buscaCitasDia($dia)
    {
        $citasHoy = Cita::whereDate('date_ini', $dia)->orderBy('date_ini')->get();
        $nombresClientes = [];
        $nombresDent = [];
        foreach ($citasHoy as $cita) {
            $idAux = $cita->id_client;
            $esta = false;
            foreach ($nombresClientes as $nombre) {
                if ($nombre[0] == $idAux) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
                $nombresClientes[] = [$idAux, $nombreAux];
            }

            $idAux2 = $cita->id_dent;
            $esta2 = false;
            foreach ($nombresDent as $nombre2) {
                if ($nombre2[0] == $idAux2) {
                    $esta2 = true;
                }
            }
            if (!$esta2) {
                $nombreAux2 = Informacion::where('id_persona', $idAux2)->value('nombre');
                $nombresDent[] = [$idAux2, $nombreAux2];
            }
        }
        return response()->json([
            'html' => view('partials.citasDia', compact('citasHoy', 'dia', 'nombresClientes', 'nombresDent'))->render(),
        ]);
    }

    public function editaCita(Request $request, $id)
    {
        $request->validate([
            'inicio' => 'required|date_format:H:i',
            'fin' => [
                'required',
                'date_format:H:i',
                function ($attribute, $value, $fail) {
                    if (strtotime($value) <= strtotime(request('inicio'))) {
                        $fail('La hora de fin debe ser mayor que la hora de inicio.');
                    }
                },
            ],
            'dia' => ['required', function ($attribute, $value, $fail) {
                if (Carbon::parse($value)->dayOfWeek === 0) {
                    $fail('No se pueden seleccionar domingos.');
                }
            }]
        ], [
            'dia.required' => 'Debes escoger el dia de la cita'
        ]);
        $cita = Cita::findOrFail($id);

        if (!$cita) {
            return redirect()->back()->withInput()->withErrors('status', 'Cita no encontrada');
        }

        $dia = $request->input('dia');
        $inicio = $request->input('inicio') . ":00";
        $fin = $request->input('fin') . ":00";

        $inicioFix = Carbon::parse("$dia $inicio");
        $finFix = Carbon::parse("$dia $fin");
        $gab = $request->input('gab');
        $solapa = $this->checkSolapa($inicioFix, $finFix, $gab, $dia, $id);


        if ($solapa) {
            return redirect()->back()->withInput()->withErrors(['Hueco' => 'Ese hueco está ocupado']);
        } else {
            $cita->descri = $request->desc ?? "";
            $cita->precio = $request->precio ?? 0;
            $cita->date_ini = $request->dia . ' ' . $request->inicio;
            $cita->date_fin = $request->dia . ' ' . $request->fin;
            $cita->id_dent = $request->dent;
            $cita->gab = $request->gab;
            $cita->save();

            $nombre = Informacion::where('id_persona', $id)->value('nombre');

            $fecha2 = explode('-', $dia);
            $fechaInversa = array_reverse($fecha2);
            $fechaString = implode('/', $fechaInversa);

            session()->flash('status', 'Cita para ' . $nombre . ' editada para el ' . $fechaString . ' a las ' . $inicioFix->format('H:i'));
            return redirect()->route('panelCliente', ['id' => $cita->id_client])->with('status', 'Cita actualizada');

            // session()->flash('status', 'Cita para ' . $nombre . ' editada para el ' . $fechaString . ' a las ' . $inicioFix->format('H:i'));
            // return redirect()->back()->with('status', 'Cita actualizada');
        }
    }

    public function listaDent()
    {
        $fullDent = Dentista::obtenerTodosConNombre();
        return view('listaDent', compact('fullDent'));
    }
}

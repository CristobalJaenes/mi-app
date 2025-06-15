<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Informacion;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class pdfController extends Controller
{
    public function citasPacientePdf($id)
    {
        $infoCliente = Informacion::findOrFail($id);
        $citasCliente  = Cita::obtenerCitasDeCliente($id);

        $fullDent = [];
        foreach ($citasCliente as $cita) {
            $idDent = $cita->id_dent;
            $nombreDent = Informacion::where('id_persona', $idDent)->value('nombre');

            $esta = false;
            foreach ($fullDent as $dent) {
                if ($dent[0] == $idDent) {
                    $esta = true;
                }
            }
            if (!$esta) {
                $idNombre = [$idDent, $nombreDent];
                $fullDent[] = $idNombre;
            }
        }

        $pdf = Pdf::loadView('pdf.CitasClientePdf', compact('infoCliente', 'citasCliente', 'fullDent'));
        return $pdf->stream('citas_de_' . $infoCliente->nombre . '.pdf');
    }

    public function citasDiaPdf($dia)
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
            foreach ($nombresDent as $nombre) {
                if ($nombre[0] == $idAux2) {
                    $esta2 = true;
                }
            }
            if (!$esta2) {
                $nombreAux2 = Informacion::where('id_persona', $idAux2)->value('nombre');
                $nombresDent[] = [$idAux2, $nombreAux2];
            }
        }

        $pdf = Pdf::loadView('pdf.CitasdiaPdf', compact('citasHoy', 'dia', 'nombresClientes', 'nombresDent'));
        return $pdf->stream('citas_del_' . $dia . '.pdf');
    }

    public function citasDentPdf($id)
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

        $todoCitas= $citasHoy->merge($citasFuturas)->merge($citasPasadas)->values();

        $pdf = Pdf::loadView('pdf.CitasDentPdf', compact('todoCitas', 'nombreDent', 'nombresClientes'));
        return $pdf->stream('citas_de_' . $nombreDent . '.pdf');
    }

    // public function CitasIdDent($id)
    // {
    // $auxaa = Informacion::findOrFail($id);
    // $nombreDent = Informacion::where('id_persona', $id)->value('nombre');
    // $fechaHoy = Carbon::today();
    // $fechaMañana = Carbon::tomorrow();

    // $citasHoy = Cita::where('id_dent', $id)->whereDate('date_ini', $fechaHoy)->orderBy('date_ini')->get();
    // $citasFuturas = Cita::where('id_dent', $id)->whereDate('date_ini', '>=', $fechaMañana)->orderBy('date_ini')->get();
    // $citasPasadas = Cita::where('id_dent', $id)->whereDate('date_ini', '<', $fechaHoy)->orderBy('date_ini')->get();
    // $nombresClientes = [];
    // foreach ($citasHoy as $cita) {
    //     $idAux = $cita->id_client;
    //     $esta = false;
    //     foreach ($nombresClientes as $nombre) {
    //         if ($nombre[0] == $idAux) {
    //             $esta = true;
    //         }
    //     }
    //     if (!$esta) {
    //         $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
    //         $nombresClientes[] = [$idAux, $nombreAux];
    //     }
    // }

    // foreach ($citasFuturas as $cita) {
    //     $idAux = $cita->id_client;
    //     $esta = false;
    //     foreach ($nombresClientes as $nombre) {
    //         if ($nombre[0] == $idAux) {
    //             $esta = true;
    //         }
    //     }
    //     if (!$esta) {
    //         $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
    //         $nombresClientes[] = [$idAux, $nombreAux];
    //     }
    // }

    // foreach ($citasPasadas as $cita) {
    //     $idAux = $cita->id_client;
    //     $esta = false;
    //     foreach ($nombresClientes as $nombre) {
    //         if ($nombre[0] == $idAux) {
    //             $esta = true;
    //         }
    //     }
    //     if (!$esta) {
    //         $nombreAux = Informacion::where('id_persona', $idAux)->value('nombre');
    //         $nombresClientes[] = [$idAux, $nombreAux];
    //     }
    // }
    //     return response()->json([
    //         'html' => view('partials.citasId', compact('citasHoy', 'citasFuturas', 'citasPasadas', 'nombreDent', 'nombresClientes'))->render(),
    //     ]);
    // }
}

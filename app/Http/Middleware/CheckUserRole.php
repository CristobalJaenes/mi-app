<?php

namespace App\Http\Middleware;

use App\Models\Dentista;
use App\Models\Permisos;
use App\Models\Recepcionista;
use App\Models\userInfo;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $permisos = [
            'inicio' => ['recepcionista', 'dentista', 'admin'],
            'horario.ajax' => ['recepcionista', 'dentista', 'admin'],
            'panelCliente' => ['recepcionista', 'dentista', 'admin'],
            'formCita' => ['recepcionista', 'dentista', 'admin'],
            'creaCita' => ['recepcionista', 'dentista', 'admin'],
            'editCita' => ['recepcionista', 'dentista', 'admin'],
            'formCitaEdit' => ['recepcionista', 'dentista', 'admin'],
            'editaCita' => ['recepcionista', 'dentista', 'admin'],
            'borraCita' => ['recepcionista', 'dentista', 'admin'],
            'citasId' => ['recepcionista', 'dentista', 'admin'],
            'listaDent' => ['recepcionista', 'dentista', 'admin'],
            'formCreaCliente' => ['recepcionista', 'dentista', 'admin'],
            'creaCliente' => ['recepcionista', 'dentista', 'admin'],
            'formEditaCliente' => ['recepcionista', 'dentista', 'admin'],
            'editaCliente' => ['recepcionista', 'dentista', 'admin'],
            'formBuscaCliente' => ['recepcionista', 'dentista', 'admin'],
            'CitasIdDent' => ['recepcionista', 'dentista', 'admin'],
            'buscaCliente' => ['recepcionista', 'dentista', 'admin'],
            'formEditaOdonto' => ['dentista', 'admin'],
            'editaOdonto' => ['dentista', 'admin'],
            'gestUsu' => ['admin'],
            'modPerm' => ['admin'],
            'borraCliente' => ['recepcionista', 'dentista', 'admin'],
            'borraUsu' => ['admin'],
            'borraUsu2' => ['admin'],
            'upgClient' => ['admin'],
            'gestUsuPass' => ['admin'],
            'gestUsuPassCheck' => ['admin'],
            'upgClientPass' => ['admin'],
            'upgClientPassCheck' => ['admin'],
            'formCitasDia' => ['recepcionista', 'dentista', 'admin'],
            'buscaCitasDia' => ['recepcionista', 'dentista', 'admin'],
            'ajustes' => ['recepcionista', 'dentista', 'admin'],
            'citasPacientePdf' => ['recepcionista', 'dentista', 'admin'],
            'citasDiaPdf' => ['recepcionista', 'dentista', 'admin'],
            'citasDentPdf' => ['recepcionista', 'dentista', 'admin'],
            
        ];

        /** @var User $usuario */
        $usuario = Auth::user();
        if (!$usuario) {
            return redirect()->route('login');
        }

        $idUser = $usuario->id;
        $idPersona = userInfo::where('id_user', $idUser)->value('id_persona');
        if (!$idPersona) {
            return redirect()->route('error');
        }

        $permUsu = [
            'recepcionista' => $usuario->esRecepcionista(),
            'dentista' => $usuario->esDentista(),
            'admin' => $usuario->esAdmin()
        ];

        $rutaActual = $request->route()->getName();
        $necesario = $permisos[$rutaActual];

        foreach ($necesario as $nec) {
            if ($permUsu[$nec]) {
                return $next($request);
            }
        }
        abort(403);
        // return redirect()->route('sinPerm');
    }
}

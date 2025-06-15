<?php

namespace App\Http\Controllers\Auth;

use App\Models\Cita;
use App\Models\Boca;
use App\Http\Controllers\Controller;
use App\Models\Dentista;
use App\Models\Informacion;
use App\Models\User;
use App\Models\Permisos;
use App\Models\Recepcionista;
use App\Models\userInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class adminController extends Controller
{
    public function gestUsu(Request $request, $id)
    {
        // if(isset($request->id_per)){
        //     Log::info($request->id_per." aaaa ");
        // }
        $todoUsuSucio = User::with('userInfo')->get();
        $todoUsu = [];
        foreach ($todoUsuSucio as $usu) {
            $idPer = userInfo::where('id_user', $usu['id'])->value('id_persona');
            $datos = [
                'nombre' => Informacion::where('id_persona', $idPer)->value('nombre'),
                'email' => Informacion::where('id_persona', $idPer)->value('email'),
            ];
            $todoUsu[] = [$idPer, $datos];
        }

        $idAux = $id;
        $infoCliente = Informacion::obtenerPorId($idAux);
        $perm = [
            'admin' => Permisos::where('id_persona', $idAux)->exists() ? 1 : 0,
            'dentista' => Dentista::where('id_persona', $idAux)->exists() ? 1 : 0,
            'recepcionista' => Recepcionista::where('id_persona', $idAux)->exists() ? 1 : 0,
        ];
        $esUser = userInfo::where('id_persona', $idAux)->exists();
        return view('gestUsu', compact('todoUsu', 'infoCliente', 'perm', 'esUser'));
    }

    public function modPerm($idPer, Request $request)
    {
        $persona = Informacion::findOrFail($idPer);

        $admin = $request->admin;
        $denti = $request->denti;
        $recep = $request->recep;

        $esAdmin = Permisos::where('id_persona', $idPer)->exists();
        $esRecep = Recepcionista::where('id_persona', $idPer)->exists();
        $esDenti = Dentista::where('id_persona', $idPer)->exists();

        if ($admin) {
            if (!$esAdmin) {
                Permisos::create(['id_persona' => $idPer]);
            }
        } else {
            if ($esAdmin) {
                $total = Permisos::count();
                if ($total == 1) {
                    return redirect()->back()->withInput()->withErrors(['Admin' => 'Debe haber al menos 1 administrador']);
                }
                Permisos::where('id_persona', $idPer)->delete();
            }
        }

        if ($denti) {
            if (!$esDenti) {
                Dentista::create(['id_persona' => $idPer]);
            }
        } else {
            if ($esDenti) {
                Dentista::where('id_persona', $idPer)->delete();
            }
        }

        if ($recep) {
            if (!$esRecep) {
                Recepcionista::create(['id_persona' => $idPer]);
            }
        } else {
            if ($esRecep) {
                Recepcionista::where('id_persona', $idPer)->delete();
            }
        }

        return redirect()->route('gestUsu', ['id' => $idPer])->with('status', 'Permisos actualizados');
    }

    public function borraUsu($idPer)
    {
        $persona = Informacion::findOrFail($idPer);
        $idUsu = userInfo::where('id_persona', $idPer)->value('id_user');
        $usuario = User::findOrFail($idUsu);
        $usuario->delete();

        userInfo::where('id_persona', $idPer)->delete();
        Dentista::where('id_persona', $idPer)->delete();
        Permisos::where('id_persona', $idPer)->delete();
        Recepcionista::where('id_persona', $idPer)->delete();

        session()->flash('status', 'Usuario eliminado');
        return redirect()->route('inicio');
    }
    public function borraUsu2($idPer)
    {
        $persona = Informacion::findOrFail($idPer);
        Informacion::borraPorId($idPer);

        $citas = Cita::obtenerCitasDeCliente($idPer);
        foreach ($citas as $cita) {
            Cita::eliminarPorId($cita->id_cita);
        }
        Boca::eliminarBocaPorId($idPer);

        return $this->borraUsu($idPer);
    }

    public function gestUsuPass($id)
    {
        // return view('gestUsuPass', compact('id'));
        $ruta = "gestUsuPassCheck";
        return view('gestUsuPass', ['ruta' => $ruta, 'id' => $id]);
    }

    public function upgClientPass($id)
    {
        // return view('upgClientPass', compact('id'));
        $ruta = "upgClientPassCheck";
        return view('gestUsuPass', ['ruta' => $ruta, 'id' => $id]);
    }

    public function passCheck(Request $request, $id)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Debes introducir tu email.',
            'email.email' => 'Debes introducir tu email',
            'password.required' => 'Debes introducir tu contraseña'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('gestUsu', ['id' => $id]);
        } else {
            return back()->withErrors(['credenciales' => 'Email o contraseña incorrectos'])->withInput();
        }
    }

    public function upgPassCheck(Request $request, $id)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Debes introducir tu email.',
            'email.email' => 'Debes introducir tu email',
            'password.required' => 'Debes introducir tu contraseña'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return $this->upgClient($id);
        } else {
            return back()->withErrors(['credenciales' => 'Email o contraseña incorrectos'])->withInput();
        }
    }

    public function upgClient($idPer)
    {
        $persona = Informacion::findOrFail($idPer);
        $existe = userInfo::where('id_persona', $idPer)->exists();

        if (!$existe) {
            $infoCliente = Informacion::obtenerPorId($idPer);
            if (!$infoCliente->email) {
                return redirect()->route('panelCliente', ['id' => $idPer])->withInput()->withErrors(['Usu' => 'Necesita un email valido']);
            }
            $emailRep = User::where('email', $infoCliente->email)->exists();
            if ($emailRep) {
                return redirect()->route('panelCliente', ['id' => $idPer])->withInput()->withErrors(['Usu' => 'Ese email ya está en uso como usuario']);
            } else {
                $user = User::create([
                    'email' => $infoCliente->email,
                    'password' => bcrypt($infoCliente->DNI)
                ]);

                userInfo::create([
                    'id_persona' => $infoCliente->id_persona,
                    'id_user' => $user->id
                ]);

                // return redirect()->route('panelCliente', ['id' => $idPer])->with('status', 'Ahora es usuario');
                return redirect()->route('gestUsu', ['id' => $idPer])->with('status', $persona->nombre . ' ahora es usuario');
            }
        } else {
            return redirect()->back()->withInput()->withErrors(['Usu' => 'Ese cliente ya es usuario']);
        }
    }
}

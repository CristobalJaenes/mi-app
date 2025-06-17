<?php

namespace App\Http\Controllers;

use App\Models\Cita;
use App\Models\Boca;
use App\Http\Controllers\Controller;
use App\Models\Informacion;
use App\Models\Permisos;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\userInfo;
use Illuminate\Support\Facades\Log;

class clienteController extends Controller
{
    public function formCreaCliente()
    {
        return view('formCreaCliente');
    }

    public function creaCliente(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'DNI' => 'required|string|unique:informacion,DNI',
            'tlf' => 'required|integer|min:0',
            'fecha_nac' => 'required',
            'direcc' => 'required|string',
            'email' => 'nullable|email'
        ], [
            'nombre.required' => 'Debes introducir el nombre del cliente',
            'DNI.required' => 'Debes introducir el DNI del cliente',
            'DNI.unique' => 'Ya hay alguien con ese DNI',
            'tlf.required' => 'Debes introducir un telefono de contacto del cliente',
            'fecha_nac.required' => 'Debes introducir la fecha de nacimiento del cliente',
            'direcc.required' => 'Debes introducir la direccion del cliente',
        ]);

        $cliente = Informacion::crearClienteDesdeRequest($request);

        session()->flash('status', 'Cliente creado con exito');
        return redirect()->route('panelCliente', ['id' => $cliente->id_persona]);
    }

    public function panelCliente($id)
    {
        $infoCliente = Informacion::obtenerPorId($id);
        $citasCliente  = Cita::obtenerCitasDeCliente($id)->orderBy('date_ini');
        $bocaCliente = Boca::obtenerBocaCliente($id);

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
        $esUser = userInfo::where('id_persona', $id)->exists();

        return view('client', compact('infoCliente', 'citasCliente', 'bocaCliente', 'fullDent', 'esUser'));
    }

    public function formEditaCliente($id)
    {
        $info = Informacion::obtenerPorId($id);
        $clienAdmin = Permisos::where('id_persona', $info->id_persona)->exists();

        return view('formEditaCliente', compact('info', 'clienAdmin'));
    }

    public function editaCliente(Request $request, $id)
    {
        $idUser2 = userInfo::where('id_persona', $id)->first();
        if ($idUser2) {
            $idUser = $idUser2->id_user;
            $usu = User::findOrFail($idUser);
        } else {
            $usu = null;
        }

        $condAux = '';
        $textAux = '';
        if ($usu) {
            $emailAux = 'email|required';
            $condAux = 'email.required';
            $textAux = 'No puedes eliminar el email de un usuario';
        } else {
            $emailAux = 'nullable|email';
        }

        $reglas = [
            'nombre' => 'required|string',
            'DNI' => [
                'required',
                'string',
                "unique:informacion,DNI,{$id},id_persona",
            ],
            'tlf' => 'required|integer|min:0',
            'fecha_nac' => 'required',
            'direcc' => 'required|string',
            'email' => $emailAux
        ];
        $mensajes = [
            'nombre.required' => 'Debes introducir el nombre del cliente',
            'DNI.required' => 'Debes introducir el DNI del cliente',
            'DNI.unique' => 'Ya hay alguien con ese DNI',
            'tlf.required' => 'Debes introducir el telefono del cliente',
            'fecha_nac.required' => 'Debes introducir la fecha de nacimiento del cliente',
            'direcc.required' => 'Debes introducir la direccion del cliente',
            'email.email' => 'El email introducido no es un modelo valido',
        ];
        if ($usu) {
            $mensajes[$condAux] = $textAux;
        }
        $request->validate($reglas, $mensajes);
        if ($request->email) {
            $idUserRepe = User::where('email', $request->email)->first();
            if ($idUserRepe) {
                $idPerRepe = userInfo::where('id_user', $idUserRepe->id)->value('id_persona');
                if (($idPerRepe != $id) && ($usu)) {
                    return redirect()->back()->withInput()->withErrors(['Email' => 'Ese email ya está en uso por otro usuario']);
                }
            }
        }

        Informacion::editarClienteDesdeRequest($request, $id);
        if ($usu) {
            $usu->email = $request->email;
            $usu->save();
        }
        // return redirect()->route('panelCliente', ['id' => $id]);
        return redirect()->back()->with('status','Los cambios se aplicaron con exito');
    }

    public function borraCliente($id)
    {
        $persona = Informacion::findOrFail($id);
        Informacion::borraPorId($id);
        $citas = Cita::obtenerCitasDeCliente($id);
        foreach ($citas as $cita) {
            Cita::eliminarPorId($cita->id_cita);
        }
        Boca::eliminarBocaPorId($id);

        session()->flash('status', 'Cliente eliminado');
        return redirect()->route('inicio');
    }

    public function formBuscaCliente()
    {
        $clientes = Informacion::orderByDesc('id_persona')->get();

        return view('formBuscaCliente', compact('clientes'));
    }

    public function buscaCliente($texto)
    {
        $clientes = Informacion::buscarPorTexto($texto);

        return response()->json($clientes);
    }

    public function formEditaOdonto($id)
    {
        $persona = Informacion::findOrFail($id);
        $bocaCliente = Boca::obtenerBocaCliente($id);
        $nombre = Informacion::obtenerPorId($id)?->nombre;

        return view('odontoEdit', compact('bocaCliente', 'nombre', 'id'));
    }

    public function editaOdonto(Request $request, $id)
    {
        $persona = Informacion::findOrFail($id);
        $obj = $request->objet;
        $desc = $request->descObj;
        $estado = $request->estadoObj;
        $obser = $request->obser;

        $bocaCliente = Boca::obtenerBocaCliente($id);

        if ($bocaCliente == null) {
            $bocaCliente = Boca::creaOdon($id, $obj, $estado, $desc, $obser);
        } else {
            if ($obj == "obser") {
                $bocaCliente->obser = $obser;
            } else {
                $estadoAux = $bocaCliente->estado ?? [];
                $estadoAux[$obj] = ["estado" => $estado, "desc" => $desc];
                $bocaCliente->estado = $estadoAux;
            }
            $bocaCliente->save();
        }
        $nombre = Informacion::obtenerPorId($id)?->nombre;

        return view('odontoEdit', compact('bocaCliente', 'nombre', 'id'));
    }
}

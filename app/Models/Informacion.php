<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Informacion extends Model
{
    use HasFactory;

    protected $table = 'informacion';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['nombre', 'dni', 'tlf', 'fecha_nac', 'direccion', 'email'];
    public $timestamps = false;
    public function boca()
    {
        return $this->hasOne(Boca::class, 'id_persona');
    }

    public function dentista()
    {
        return $this->hasOne(Dentista::class, 'id_persona');
    }

    public static function crearClienteDesdeRequest(Request $request): self
    {
        return self::create([
            'nombre'      => $request->input('nombre'),
            'dni'         => $request->input('DNI'),
            'tlf'         => $request->input('tlf'),
            'fecha_nac'   => $request->input('fecha_nac'),
            'direccion'   => $request->input('direcc'),
            'email' => $request->input('email') ? $request->input('email') : null,
        ]);
    }

    public static function editarClienteDesdeRequest(Request $request, $id)
    {
        $info = Informacion::obtenerPorId($id);
        $info->nombre = $request->nombre;
        $info->DNI = $request->DNI;
        $info->tlf = $request->tlf;
        $info->fecha_nac = $request->fecha_nac;
        $info->direccion = $request->direcc;
        $info->email = $request->email ? $request->email : null;
        $info->save();
    }

    public static function obtenerPorId($id)
    {
        return self::findOrFail($id);
    }

    public static function buscarPorTexto($texto)
    {
        return self::where('nombre', 'LIKE', "%{$texto}%")
            ->orWhere('tlf', 'LIKE', "%{$texto}%")
            ->orWhere('email', 'LIKE', "%{$texto}%")
            ->orWhere('DNI', 'LIKE', "%{$texto}%")
            ->get();
    }

    public static function borraPorId($id)
    {
        $info = self::where('id_persona', $id)->first();
        if (!$info) {
            return false;
        } else {
            return $info->delete();
        }
    }

    public function esUser(): bool
    {
        return userInfo::where('id_persona', $this->id_persona)->exists();
    }
}

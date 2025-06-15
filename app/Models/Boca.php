<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boca extends Model
{
    use HasFactory;

    protected $table = 'boca';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['id_persona', 'estado', 'obser'];
    public $timestamps = false;

    protected $casts = [
        'estado' => 'array',
    ];

    public function informacion()
    {
        return $this->belongsTo(Informacion::class, 'id_persona');
    }

    public static function obtenerBocaCliente($id)
    {
        return self::where('id_persona', $id)->first();
    }

    public static function creaOdon($id, $obj, $estado = null, $desc = null, $obser = null)
    {
        return self::create([
            'id_persona' => $id,
            'obser' => $obj === "obser" ? $obser : null,
            'estado' => $obj !== "obser" ? [
                $obj => ["estado" => $estado, "desc" => $desc]
            ] : null
        ]);
    }

    public static function eliminarBocaPorId($idPersona): bool
    {
        $boca = self::where('id_persona', $idPersona)->first();
        if (!$boca) {
            return false;
        }
        return $boca->delete();
    }
}

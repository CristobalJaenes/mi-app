<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class Cita extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'cita';
    protected $primaryKey = 'id_cita';
    protected $fillable = ['id_cita', 'id_dent', 'id_client', 'descri', 'precio', 'gab', 'date_ini', 'date_fin'];

    public function dentista()
    {
        return $this->belongsTo(Dentista::class, 'id_dent', 'id_persona');
    }

    public function cliente()
    {
        return $this->belongsTo(Boca::class, 'id_client', 'id_persona');
    }

    public static function obtenerCitasDeCliente($idCliente)
    {
        return self::where('id_client', $idCliente)->get();
    }

    public static function crearCita(array $data): self
    {
        return self::create([
            'id_dent' => $data['dent'],
            'id_client' => $data['id_client'],
            'descri' => $data['desc'] ?? '',
            'precio' => $data['precio'] ?? 0,
            'gab' => $data['gab'],
            'date_ini' => $data['inicio'],
            'date_fin' => $data['fin'],
        ]);
    }

    public static function eliminarPorId($idCita): bool
    {
        $cita = self::where('id_cita', $idCita)->first();
        if (!$cita) {
            return false;
        }
        return $cita->delete();
    }
}

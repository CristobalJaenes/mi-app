<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dentista extends Model
{
    use HasFactory;

    protected $table = 'dentista';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['id_persona'];
    public $timestamps = false;

    public function informacion()
    {
        return $this->belongsTo(Informacion::class, 'id_persona');
    }

    public static function obtenerTodosConNombre()
    {
        $ids = self::pluck('id_persona');
        $resultado = [];

        foreach ($ids as $id) {
            $nombre = Informacion::where('id_persona', $id)->value('nombre');
            $resultado[] = [$id, $nombre];
        }

        return $resultado;
    }
}

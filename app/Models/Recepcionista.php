<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recepcionista extends Model
{
    use HasFactory;

    protected $table = 'recepcionista';
    protected $primaryKey = 'id_persona';
    protected $fillable = ['id_persona'];
    public $timestamps = false;

    public function informacion()
    {
        return $this->hasOne(Informacion::class, 'id_persona', 'id_persona');
    }
}
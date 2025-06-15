<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInformacionTable extends Migration
{
    public function up()
    {
        Schema::create('informacion', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('nombre');
            $table->string('dni');
            $table->string('tlfn');
            $table->date('fecha_nac');
            $table->string('direccion');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('informacion');
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('informacion', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('informacion');
//     }
// };

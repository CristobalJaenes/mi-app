<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitaTable extends Migration
{
    public function up()
    {
        Schema::create('cita', function (Blueprint $table) {
            $table->id('id_cita');
            $table->unsignedBigInteger('id_dent');
            $table->unsignedBigInteger('id_client');
            $table->string('descripcion');
            $table->decimal('precio', 8, 2);
            $table->integer('gab');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->timestamps();

            $table->foreign('id_dent')->references('id_persona')->on('informacion');
            $table->foreign('id_client')->references('id_persona')->on('informacion');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cita');
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('cita', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('cita');
//     }
// };

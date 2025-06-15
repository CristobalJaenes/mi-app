<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNecesitaTable extends Migration
{
    public function up()
    {
        Schema::create('necesita', function (Blueprint $table) {
            $table->unsignedBigInteger('id_cita');
            $table->unsignedBigInteger('id_material');
            $table->timestamps();

            $table->foreign('id_cita')->references('id_cita')->on('cita');
            $table->foreign('id_material')->references('id_material')->on('material');
        });
    }

    public function down()
    {
        Schema::dropIfExists('necesita');
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('necesita', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('necesita');
//     }
// };

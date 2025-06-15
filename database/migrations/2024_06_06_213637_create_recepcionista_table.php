<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecepcionistaTable extends Migration
{
    public function up()
    {
        Schema::create('recepcionista', function (Blueprint $table) {
            $table->id('id_persona');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('recepcionista');
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('recepcionista', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('recepcionista');
//     }
// };

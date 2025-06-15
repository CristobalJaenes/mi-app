<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDentistaTable extends Migration
{
    public function up()
    {
        Schema::create('dentista', function (Blueprint $table) {
            $table->id('id_persona');
            $table->string('especialidad');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dentista');
    }
}
// return new class extends Migration
// {
//     /**
//      * Run the migrations.
//      */
//     public function up(): void
//     {
//         Schema::create('dentista', function (Blueprint $table) {
//             $table->id();
//             $table->timestamps();
//         });
//     }

//     /**
//      * Reverse the migrations.
//      */
//     public function down(): void
//     {
//         Schema::dropIfExists('dentista');
//     }
// };

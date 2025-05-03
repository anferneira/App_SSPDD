<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('dependencias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_d')->unique();
            $table->string('estado_d');
            $table->timestamps();
        });

        $dateTime = new DateTime();

        DB::table('dependencias')->insert([
            "nombre_d" => "Administrador del Sistema",
            "estado_d" => "Activo",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencias');
    }
};

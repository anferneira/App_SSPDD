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
        Schema::create('orientacions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_o')->unique();
            $table->string('estado_o');
            $table->timestamps();
        });

        $dateTime = new DateTime();

        DB::table('orientacions')->insert([
            "nombre_o" => "Incremento",
            "estado_o" => "Activo",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('orientacions')->insert([
            "nombre_o" => "Mantenimiento_1",
            "estado_o" => "Activo",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('orientacions')->insert([
            "nombre_o" => "Mantenimiento_2",
            "estado_o" => "Activo",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orientacions');
    }
};

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
        Schema::create('proyecto_convergencias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_pc')->unique();
            $table->string('proyecto_pc');
            $table->timestamps();
        });

        $dateTime = new DateTime();

        DB::table('proyecto_convergencias')->insert([
            "codigo_pc" => "PIRES",
            "proyecto_pc" => "Proyectos de Interés del Corredor Regional Estratégicos",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('proyecto_convergencias')->insert([
            "codigo_pc" => "PILES",
            "proyecto_pc" => "Proyectos de Interés Local Estratégicos",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('proyecto_convergencias')->insert([
            "codigo_pc" => "PICES",
            "proyecto_pc" => "Proyectos de Interés del Corredor Central Estratégicos",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('proyecto_convergencias')->insert([
            "codigo_pc" => "N/A",
            "proyecto_pc" => "Ninguno",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_convergencias');
    }
};

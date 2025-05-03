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
        Schema::create('rols', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_r')->unique();
            $table->timestamps();
        });

        $dateTime = new DateTime();

        DB::table('rols')->insert([
            "nombre_r" => "Administrador",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('rols')->insert([
            "nombre_r" => "Facilitador",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('rols')->insert([
            "nombre_r" => "Verificador",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('rols')->insert([
            "nombre_r" => "Revisor",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('rols')->insert([
            "nombre_r" => "Visualizador",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rols');
    }
};

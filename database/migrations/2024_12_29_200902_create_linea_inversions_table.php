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
        Schema::create('linea_inversions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('proyecto_li');
            $table->timestamps();
        });

        $dateTime = new DateTime();

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "VÍAS Y TRANSPORTE",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "EDUCACIÓN E INNOVACIÓN",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "AGUA Y MEDIO AMBIENTE",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "TURISMO Y CULTURA",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "COMPETITIVIDAD Y PRODUCTIVIDAD",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "VIDA Y DEPORTE",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);

        DB::table('linea_inversions')->insert([
            "proyecto_li" => "SALUD Y BIENESTAR",
            "created_at"=> $dateTime->format('y-m-d H:i:s'),
            "updated_at"=> $dateTime->format('y-m-d H:i:s'),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('linea_inversions');
    }
};

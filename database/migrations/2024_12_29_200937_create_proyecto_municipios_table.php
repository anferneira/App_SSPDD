<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('proyecto_municipios', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->longText('proyecto_pm');
            $table->string('estado_pm');
            $table->integer('id_li')->unsigned();
            $table->integer('id_pc')->unsigned();
            $table->integer('id_m')->unsigned();
            $table->timestamps();
            $table->foreign('id_li')->references('id')->on('linea_inversions')->onDelete('cascade');
            $table->foreign('id_pc')->references('id')->on('proyecto_convergencias')->onDelete('cascade');
            $table->foreign('id_m')->references('id')->on('municipios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('proyecto_municipios');
    }
};

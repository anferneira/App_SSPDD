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
        Schema::create('programar_estrategicos', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('p2024_3');
            $table->string('p2024_4');
            $table->string('p2025_1');
            $table->string('p2025_2');
            $table->string('p2025_3');
            $table->string('p2025_4');
            $table->string('p2026_1');
            $table->string('p2026_2');
            $table->string('p2026_3');
            $table->string('p2026_4');
            $table->string('p2027_1');
            $table->string('p2027_2');
            $table->string('p2027_3');
            $table->string('p2027_4');
            $table->string('calculo');
            $table->integer('id_ip')->unsigned();
            $table->timestamps();
            $table->string('estado_pe');
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programar_estrategicos');
    }
};

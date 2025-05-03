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
        Schema::create('dependencia_apuestas', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('id_dep')->unsigned();
            $table->integer('id_apu')->unsigned();
            $table->string('estado_da');
            $table->timestamps();
            $table->foreign('id_apu')->references('id')->on('apuestas')->onDelete('cascade');
            $table->foreign('id_dep')->references('id')->on('dependencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencia_dimensions');
    }
};

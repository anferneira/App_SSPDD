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
        Schema::create('dependencia_estrategias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('id_d')->unsigned();
            $table->integer('id_e')->unsigned();
            $table->string('estado_de');
            $table->timestamps();
            $table->foreign('id_e')->references('id')->on('estrategias')->onDelete('cascade');
            $table->foreign('id_d')->references('id')->on('dependencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencia_estrategias');
    }
};

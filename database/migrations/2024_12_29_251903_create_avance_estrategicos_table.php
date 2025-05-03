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
        Schema::create('avance_estrategicos', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('avance_ae');
            $table->string('anio_ae');
            $table->string('trimestre_ae');
            $table->integer('id_ip')->unsigned();
            $table->timestamps();
            $table->string('estado_ae');
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avance_estrategicos');
    }
};

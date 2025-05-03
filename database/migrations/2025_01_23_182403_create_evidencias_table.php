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
        Schema::create('evidencias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->longText('evidencia');
            $table->string('anio_eip');
            $table->string('trimestre_eip');
            $table->string('estado_e');
            $table->integer('id_ip')->unsigned();
            $table->timestamps();
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evidencias');
    }
};

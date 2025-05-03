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
        Schema::create('actividads', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_a')->nullable();
            $table->longText('nombre_a');
            $table->string('anio_a');
            $table->string('trimestre_a');
            $table->string('meta_a');
            $table->string('aporte_a');
            $table->string('estado_a');
            $table->integer('id_ip')->unsigned();
            $table->integer('id_dep')->unsigned();
            $table->timestamps();
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
            $table->foreign('id_dep')->references('id')->on('dependencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividads');
    }
};

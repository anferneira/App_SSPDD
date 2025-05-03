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
        Schema::create('municipios', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('codigo_m')->unique();
            $table->string('nombre_m');
            $table->string('latitud_m');
            $table->string('longitud_m');
            $table->integer('id_p')->unsigned();
            $table->string('estado_m');
            $table->timestamps();
            $table->foreign('id_p')->references('id')->on('provincias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('municipios');
    }
};

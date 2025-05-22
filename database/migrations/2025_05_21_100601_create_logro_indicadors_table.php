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
        Schema::create('logro_indicadors', function (Blueprint $table) {
            $table->id();
            $table->text('logro');
            $table->string('anio_lip');
            $table->string('trimestre_lip');
            $table->integer('id_ip')->unsigned();
            $table->timestamps();
            $table->string('estado_lip');
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logro_indicadors');
    }
};

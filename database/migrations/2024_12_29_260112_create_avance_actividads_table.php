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
        Schema::create('avance_actividads', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('avance_aa');
            $table->string('anio_aa');
            $table->string('trimestre_aa');
            $table->integer('id_a')->unsigned();
            $table->timestamps();
            $table->text('descripcion_aa')->nullable();
            $table->string('estado_aa');
            $table->foreign('id_a')->references('id')->on('actividads')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avance_actividads');
    }
};

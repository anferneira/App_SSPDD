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
        Schema::create('grupo_poblacions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('codigo_gp')->unique();
            $table->string('nombre_gp')->unique();
            $table->string('estado_gp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_poblacions');
    }
};

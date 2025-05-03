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
        Schema::create('edpms', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_edpm')->unique();
            $table->string('programa_edpm')->unique();
            $table->string('estado_edpm');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edpms');
    }
};

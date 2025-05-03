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
        Schema::create('dimension_pobrezas', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('codigo_dp')->unique();
            $table->longText('nombre_dp');
            $table->string('estado_dp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimension_pobrezas');
    }
};

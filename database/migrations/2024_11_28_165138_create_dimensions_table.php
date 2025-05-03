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
        Schema::create('dimensions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_d')->unique();
            $table->string('nombre_d')->unique();
            $table->string('estado_d');
            $table->integer('id_e')->unsigned();
            $table->timestamps();
            $table->foreign('id_e')->references('id')->on('estrategias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dimensions');
    }
};

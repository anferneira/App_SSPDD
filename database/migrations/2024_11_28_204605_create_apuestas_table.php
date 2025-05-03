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
        Schema::create('apuestas', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_a')->unique();
            $table->string('nombre_a')->unique();
            $table->longText('objetivo_a');
            $table->string('estado_a');
            $table->integer('id_d')->unsigned();
            $table->timestamps();
            $table->foreign('id_d')->references('id')->on('dimensions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuestas');
    }
};

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
        Schema::create('dependencia_dimensions', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('id_dep')->unsigned();
            $table->integer('id_dim')->unsigned();
            $table->string('estado_dd');
            $table->timestamps();
            $table->foreign('id_dim')->references('id')->on('dimensions')->onDelete('cascade');
            $table->foreign('id_dep')->references('id')->on('dependencias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dependencia_dimensions');
    }
};

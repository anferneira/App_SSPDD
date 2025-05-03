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
        Schema::create('variable_pobrezas', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_vp')->unique();
            $table->string('estado_vp');
            $table->integer('id_dp')->unsigned();
            $table->timestamps();
            $table->foreign('id_dp')->references('id')->on('dimension_pobrezas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('variable_pobrezas');
    }
};

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
        Schema::create('indicador_producto_meta_ods', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->integer('id_ip')->unsigned();
            $table->integer('id_mo')->unsigned();
            $table->timestamps();
            $table->string('estado_imo');
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
            $table->foreign('id_mo')->references('id')->on('meta_ods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_producto_meta_ods');
    }
};

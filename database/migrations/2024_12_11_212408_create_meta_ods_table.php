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
        Schema::create('meta_ods', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_mo');
            $table->longText('nombre_mo');
            $table->integer('id_ods')->unsigned();
            $table->string('estado_mo');
            $table->timestamps();
            $table->foreign('id_ods')->references('id')->on('ods')->onDelete('cascade');
        });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meta_ods');
    }
};

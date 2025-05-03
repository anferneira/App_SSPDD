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
        Schema::create('indicador_resultados', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_ir');
            $table->longText('nombre_ir');
            $table->string('linea_ir');
            $table->string('fuente_ir');
            $table->string('meta_ir');
            $table->string('transformacion_ir');
            $table->integer('id_mr')->unsigned();
            $table->integer('id_mo')->unsigned();
            $table->timestamps();
            $table->string('estado_ir');
            $table->foreign('id_mr')->references('id')->on('medida_resultados')->onDelete('cascade');
            $table->foreign('id_mo')->references('id')->on('meta_ods')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_resultados');
    }
};

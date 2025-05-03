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
        Schema::create('indicador_productos', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('codigo_ip');
            $table->longText('nombre_ip');
            $table->longText('descripcion_ip');
            $table->integer('id_ir')->unsigned();
            $table->integer('id_d')->unsigned();
            $table->integer('id_a')->unsigned();
            $table->string('id_s');
            $table->integer('id_p')->unsigned();
            $table->integer('id_mga')->unsigned();
            $table->string('linea_ip');
            $table->integer('id_mp')->unsigned();
            $table->string('fuente_ip');
            $table->string('frecuencia_ip');
            $table->string('meta_ip');
            $table->string('abrigo_ip');
            $table->integer('id_o')->unsigned();
            $table->integer('id_vp')->unsigned();
            $table->integer('id_lu')->unsigned();
            $table->integer('id_edpm')->unsigned();
            $table->timestamps();
            $table->string('meta_ip_real');
            $table->string('estado_ip');
            $table->foreign('id_d')->references('id')->on('dependencias')->onDelete('cascade');
            $table->foreign('id_a')->references('id')->on('apuestas')->onDelete('cascade');
            $table->foreign('id_p')->references('id')->on('programas')->onDelete('cascade');
            $table->foreign('id_mga')->references('id')->on('indicador_mgas')->onDelete('cascade');
            $table->foreign('id_mp')->references('id')->on('medida_productos')->onDelete('cascade');
            $table->foreign('id_o')->references('id')->on('orientacions')->onDelete('cascade');
            $table->foreign('id_vp')->references('id')->on('variable_pobrezas')->onDelete('cascade');
            $table->foreign('id_lu')->references('id')->on('logros')->onDelete('cascade');
            $table->foreign('id_edpm')->references('id')->on('edpms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indicador_productos');
    }
};

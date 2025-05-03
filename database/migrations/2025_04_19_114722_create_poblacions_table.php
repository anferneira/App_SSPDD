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
        Schema::create('poblacions', function (Blueprint $table) {
            $table->id();
            $table->string('m_0_5');
            $table->string('m_6_12');
            $table->string('m_13_17');
            $table->string('m_18_29');
            $table->string('m_30_59');
            $table->string('m_60');
            $table->string('h_0_5');
            $table->string('h_6_12');
            $table->string('h_13_17');
            $table->string('h_18_29');
            $table->string('h_30_59');
            $table->string('h_60');
            $table->longText('beneficio');
            $table->string('cantidad');
            $table->string('anio_ap');
            $table->string('trimestre_ap');
            $table->integer('id_af')->unsigned();
            $table->integer('id_mun')->unsigned();
            $table->integer('id_gp')->unsigned();
            $table->string('estado_ap');
            $table->timestamps();
            $table->foreign('id_mun')->references('id')->on('municipios')->onDelete('cascade');
            $table->foreign('id_gp')->references('id')->on('grupo_poblacions')->onDelete('cascade');
            $table->foreign('id_af')->references('id')->on('avance_financieros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('poblacions');
    }
};

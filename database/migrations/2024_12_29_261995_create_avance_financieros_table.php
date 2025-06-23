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
        Schema::create('avance_financieros', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('bpin_af');
            $table->string('ICLD', 50);
            $table->string('ICDE', 50);
            $table->string('SGPE', 50);
            $table->string('SGPS', 50);
            $table->string('SGPAPSB', 50);
            $table->string('RPED', 50);
            $table->string('SGR', 50);
            $table->string('CR', 50);
            $table->string('G', 50);
            $table->string('CO', 50);
            $table->string('OR', 50);
            $table->string('anio_af');
            $table->string('trimestre_af');
            $table->string('logro_af');
            $table->integer('id_pf')->unsigned();
            $table->timestamps();
            $table->string('estado_af');
            $table->foreign('id_pf')->references('id')->on('programar_financieros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avance_financieros', 50);
    }
};

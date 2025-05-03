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
        Schema::create('programar_financieros', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('ICLD_2024_3', 50);
            $table->string('ICDE_2024_3', 50);
            $table->string('SGPE_2024_3', 50);
            $table->string('SGPS_2024_3', 50);
            $table->string('SGPAPSB_2024_3', 50);
            $table->string('RPED_2024_3', 50);
            $table->string('SGR_2024_3', 50);
            $table->string('CR_2024_3', 50);
            $table->string('G_2024_3', 50);
            $table->string('CO_2024_3', 50);
            $table->string('OR_2024_3', 50);
            $table->string('ICLD_2024_4', 50);
            $table->string('ICDE_2024_4', 50);
            $table->string('SGPE_2024_4', 50);
            $table->string('SGPS_2024_4', 50);
            $table->string('SGPAPSB_2024_4', 50);
            $table->string('RPED_2024_4', 50);
            $table->string('SGR_2024_4', 50);
            $table->string('CR_2024_4', 50);
            $table->string('G_2024_4', 50);
            $table->string('CO_2024_4', 50);
            $table->string('OR_2024_4', 50);
            $table->string('ICLD_2025_1', 50);
            $table->string('ICDE_2025_1', 50);
            $table->string('SGPE_2025_1', 50);
            $table->string('SGPS_2025_1', 50);
            $table->string('SGPAPSB_2025_1', 50);
            $table->string('RPED_2025_1', 50);
            $table->string('SGR_2025_1', 50);
            $table->string('CR_2025_1', 50);
            $table->string('G_2025_1', 50);
            $table->string('CO_2025_1', 50);
            $table->string('OR_2025_1', 50);
            $table->string('ICLD_2025_2', 50);
            $table->string('ICDE_2025_2', 50);
            $table->string('SGPE_2025_2', 50);
            $table->string('SGPS_2025_2', 50);
            $table->string('SGPAPSB_2025_2', 50);
            $table->string('RPED_2025_2', 50);
            $table->string('SGR_2025_2', 50);
            $table->string('CR_2025_2', 50);
            $table->string('G_2025_2', 50);
            $table->string('CO_2025_2', 50);
            $table->string('OR_2025_2', 50);
            $table->string('ICLD_2025_3', 50);
            $table->string('ICDE_2025_3', 50);
            $table->string('SGPE_2025_3', 50);
            $table->string('SGPS_2025_3', 50);
            $table->string('SGPAPSB_2025_3', 50);
            $table->string('RPED_2025_3', 50);
            $table->string('SGR_2025_3', 50);
            $table->string('CR_2025_3', 50);
            $table->string('G_2025_3', 50);
            $table->string('CO_2025_3', 50);
            $table->string('OR_2025_3', 50);
            $table->string('ICLD_2025_4', 50);
            $table->string('ICDE_2025_4', 50);
            $table->string('SGPE_2025_4', 50);
            $table->string('SGPS_2025_4', 50);
            $table->string('SGPAPSB_2025_4', 50);
            $table->string('RPED_2025_4', 50);
            $table->string('SGR_2025_4', 50);
            $table->string('CR_2025_4', 50);
            $table->string('G_2025_4', 50);
            $table->string('CO_2025_4', 50);
            $table->string('OR_2025_4', 50);
            $table->string('ICLD_2026_1', 50);
            $table->string('ICDE_2026_1', 50);
            $table->string('SGPE_2026_1', 50);
            $table->string('SGPS_2026_1', 50);
            $table->string('SGPAPSB_2026_1', 50);
            $table->string('RPED_2026_1', 50);
            $table->string('SGR_2026_1', 50);
            $table->string('CR_2026_1', 50);
            $table->string('G_2026_1', 50);
            $table->string('CO_2026_1', 50);
            $table->string('OR_2026_1', 50);
            $table->string('ICLD_2026_2', 50);
            $table->string('ICDE_2026_2', 50);
            $table->string('SGPE_2026_2', 50);
            $table->string('SGPS_2026_2', 50);
            $table->string('SGPAPSB_2026_2', 50);
            $table->string('RPED_2026_2', 50);
            $table->string('SGR_2026_2', 50);
            $table->string('CR_2026_2', 50);
            $table->string('G_2026_2', 50);
            $table->string('CO_2026_2', 50);
            $table->string('OR_2026_2', 50);
            $table->string('ICLD_2026_3', 50);
            $table->string('ICDE_2026_3', 50);
            $table->string('SGPE_2026_3', 50);
            $table->string('SGPS_2026_3', 50);
            $table->string('SGPAPSB_2026_3', 50);
            $table->string('RPED_2026_3', 50);
            $table->string('SGR_2026_3', 50);
            $table->string('CR_2026_3', 50);
            $table->string('G_2026_3', 50);
            $table->string('CO_2026_3', 50);
            $table->string('OR_2026_3', 50);
            $table->string('ICLD_2026_4', 50);
            $table->string('ICDE_2026_4', 50);
            $table->string('SGPE_2026_4', 50);
            $table->string('SGPS_2026_4', 50);
            $table->string('SGPAPSB_2026_4', 50);
            $table->string('RPED_2026_4', 50);
            $table->string('SGR_2026_4', 50);
            $table->string('CR_2026_4', 50);
            $table->string('G_2026_4', 50);
            $table->string('CO_2026_4', 50);
            $table->string('OR_2026_4', 50);
            $table->string('ICLD_2027_1', 50);
            $table->string('ICDE_2027_1', 50);
            $table->string('SGPE_2027_1', 50);
            $table->string('SGPS_2027_1', 50);
            $table->string('SGPAPSB_2027_1', 50);
            $table->string('RPED_2027_1', 50);
            $table->string('SGR_2027_1', 50);
            $table->string('CR_2027_1', 50);
            $table->string('G_2027_1', 50);
            $table->string('CO_2027_1', 50);
            $table->string('OR_2027_1', 50);
            $table->string('ICLD_2027_2', 50);
            $table->string('ICDE_2027_2', 50);
            $table->string('SGPE_2027_2', 50);
            $table->string('SGPS_2027_2', 50);
            $table->string('SGPAPSB_2027_2', 50);
            $table->string('RPED_2027_2', 50);
            $table->string('SGR_2027_2', 50);
            $table->string('CR_2027_2', 50);
            $table->string('G_2027_2', 50);
            $table->string('CO_2027_2', 50);
            $table->string('OR_2027_2', 50);
            $table->string('ICLD_2027_3', 50);
            $table->string('ICDE_2027_3', 50);
            $table->string('SGPE_2027_3', 50);
            $table->string('SGPS_2027_3', 50);
            $table->string('SGPAPSB_2027_3', 50);
            $table->string('RPED_2027_3', 50);
            $table->string('SGR_2027_3', 50);
            $table->string('CR_2027_3', 50);
            $table->string('G_2027_3', 50);
            $table->string('CO_2027_3', 50);
            $table->string('OR_2027_3', 50);
            $table->string('ICLD_2027_4', 50);
            $table->string('ICDE_2027_4', 50);
            $table->string('SGPE_2027_4', 50);
            $table->string('SGPS_2027_4', 50);
            $table->string('SGPAPSB_2027_4', 50);
            $table->string('RPED_2027_4', 50);
            $table->string('SGR_2027_4', 50);
            $table->string('CR_2027_4', 50);
            $table->string('G_2027_4', 50);
            $table->string('CO_2027_4', 50);
            $table->string('OR_2027_4', 50);
            $table->integer('id_ip')->unsigned();
            $table->timestamps();
            $table->string('estado_pf');
            $table->foreign('id_ip')->references('id')->on('indicador_productos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programar_financieros', 50);
    }
};

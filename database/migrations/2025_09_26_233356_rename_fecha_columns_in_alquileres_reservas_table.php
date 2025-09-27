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
        Schema::table('alquileres_reservas', function (Blueprint $table) {
            $table->renameColumn('fecha_entrada', 'fecha_inicio');
            $table->renameColumn('fecha_salida', 'fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alquileres_reservas', function (Blueprint $table) {
            $table->renameColumn('fecha_inicio', 'fecha_entrada');
            $table->renameColumn('fecha_fin', 'fecha_salida');
        });
    }
};

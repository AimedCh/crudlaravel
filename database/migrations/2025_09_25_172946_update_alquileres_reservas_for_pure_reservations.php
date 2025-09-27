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
            // Agregar campo numero_huespedes
            $table->integer('numero_huespedes')->nullable()->after('telefono_cliente');
            
            // Renombrar campos de fecha para que coincidan con los requeridos
            $table->renameColumn('fecha_inicio', 'fecha_entrada');
            $table->renameColumn('fecha_fin', 'fecha_salida');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('alquileres_reservas', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn('numero_huespedes');
            $table->renameColumn('fecha_entrada', 'fecha_inicio');
            $table->renameColumn('fecha_salida', 'fecha_fin');
        });
    }
};

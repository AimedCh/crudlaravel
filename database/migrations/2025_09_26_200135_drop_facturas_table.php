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
        Schema::dropIfExists('facturas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear tabla facturas si es necesario
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('numero_factura')->unique();
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->date('fecha_emision');
            $table->date('fecha_vencimiento');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('impuestos', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'pagada', 'vencida', 'cancelada'])->default('pendiente');
            $table->text('concepto')->nullable();
            $table->timestamps();
        });
    }
};

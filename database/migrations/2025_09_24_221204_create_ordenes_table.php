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
        Schema::create('ordenes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('producto_tipo'); // 'airpods', 'alquiler', etc.
            $table->foreignId('producto_id'); // ID del producto específico
            $table->integer('cantidad')->default(1);
            $table->decimal('precio_unitario', 10, 2);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'procesando', 'completado', 'cancelado'])->default('pendiente');
            $table->json('detalles_producto')->nullable(); // Información adicional del producto
            $table->string('metodo_pago')->nullable();
            $table->timestamp('fecha_orden');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ordenes');
    }
};

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
        Schema::dropIfExists('recibos');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear tabla recibos si es necesario
        Schema::create('recibos', function (Blueprint $table) {
            $table->id();
            $table->string('numero_recibo')->unique();
            $table->foreignId('factura_id')->constrained()->onDelete('cascade');
            $table->foreignId('cliente_id')->constrained('users')->onDelete('cascade');
            $table->date('fecha_pago');
            $table->decimal('monto', 10, 2);
            $table->string('metodo_pago');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }
};

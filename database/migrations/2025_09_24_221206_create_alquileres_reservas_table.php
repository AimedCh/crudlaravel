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
        Schema::create('alquileres_reservas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('nombre_cliente');
            $table->string('email_cliente');
            $table->string('telefono_cliente');
            $table->string('tipo_equipo'); // 'receptor', 'microfono', etc.
            $table->text('descripcion_equipo');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->decimal('precio_dia', 8, 2);
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'confirmado', 'en_uso', 'devuelto', 'cancelado'])->default('pendiente');
            $table->text('notas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres_reservas');
    }
};

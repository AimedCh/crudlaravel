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
        Schema::table('airpods_purchases', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea
            $table->dropForeign(['user_id']);
            
            // Hacer user_id nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Agregar la restricción de clave foránea nuevamente pero nullable
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('airpods_purchases', function (Blueprint $table) {
            // Eliminar la restricción de clave foránea
            $table->dropForeign(['user_id']);
            
            // Hacer user_id no nullable
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            
            // Agregar la restricción de clave foránea original
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};

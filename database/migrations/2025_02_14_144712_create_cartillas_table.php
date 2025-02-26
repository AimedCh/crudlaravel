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
        Schema::create('cartillas', function (Blueprint $table) {
            $table->id();
            $table->string('titular',45);
            $table->string('iban',100);
            $table->string('direccion', 64);
            $table->date('fecha');
            $table->decimal('saldo',19,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartillas');
        //$table->dropColumn(['iban', 'saldo']);
        
    }
    //ahora creame otra migracion que es
};

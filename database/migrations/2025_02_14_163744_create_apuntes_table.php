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
        Schema::create('apuntes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cartilla_id')->constrained('cartillas')->onDelete('cascade');
            $table->date('fecha');
            $table->string('concepto', 255);
            $table->decimal('importe', 19, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apuntes');
    }
};

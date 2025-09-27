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
        Schema::dropIfExists('airpods');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear tabla airpods si es necesario
        Schema::create('airpods', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('category', 50);
            $table->integer('stock')->default(0);
            $table->string('image', 255)->nullable();
            $table->boolean('is_active')->default(true);
            $table->json('features')->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->integer('reviews_count')->default(0);
            $table->timestamps();
        });
    }
};

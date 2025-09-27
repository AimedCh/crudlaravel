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
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->string('address', 255);
            $table->string('city', 100);
            $table->decimal('price_per_night', 10, 2);
            $table->integer('max_guests');
            $table->integer('bedrooms');
            $table->integer('bathrooms');
            $table->json('amenities')->nullable();
            $table->string('image', 255)->nullable();
            $table->decimal('rating', 3, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->boolean('available')->default(true);
            $table->decimal('distance_to_beach', 8, 2)->nullable();
            $table->decimal('latitude', 10, 8)->nullable();
            $table->decimal('longitude', 11, 8)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};
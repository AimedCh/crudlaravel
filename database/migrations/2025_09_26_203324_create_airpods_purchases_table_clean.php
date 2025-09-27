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
        Schema::create('airpods_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('airpods_id')->nullable();
            $table->string('purchase_number')->unique();
            $table->integer('quantity')->default(1);
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_amount', 10, 2);
            $table->string('payment_method')->default('paypal');
            $table->string('payment_status')->default('pending'); // pending, completed, failed, refunded
            $table->string('order_status')->default('pending'); // pending, processing, shipped, delivered, cancelled
            $table->string('shipping_address')->nullable();
            $table->string('billing_address')->nullable();
            $table->string('tracking_number')->nullable();
            $table->text('notes')->nullable();
            $table->string('product_name')->nullable();
            $table->text('product_description')->nullable();
            $table->string('product_category')->nullable();
            $table->timestamp('shipped_at')->nullable();
            $table->timestamp('delivered_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('airpods_purchases');
    }
};
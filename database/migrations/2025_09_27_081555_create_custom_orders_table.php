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
        Schema::create('custom_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('customer_name');
            $table->string('customer_surname');
            $table->string('customer_phone', 20);
            $table->string('customer_email');

            $table->string('product_name');
            $table->integer('quantity');
            $table->text('product_description')->nullable();
            $table->string('product_image')->nullable();
            $table->string('product_url')->nullable();

            $table->string('destination_country')->default('Algeria');
            $table->string('delivery_city');
            $table->text('delivery_address');

            $table->enum('shipping_method', ['DDP', 'Normal'])->default('Normal');
            $table->enum('payment_method', ['CCP', 'Baridimob', 'Cash', 'Bank Transfer', 'Binance', 'PayPal', 'EU Bank', 'Office'])->default('Cash');
            $table->enum('payment_currency', ['DZD', 'USD', 'EUR'])->default('DZD');

            $table->enum('status', ['pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled'])->default('pending');
            $table->decimal('estimated_price', 10, 2)->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_orders');
    }
};

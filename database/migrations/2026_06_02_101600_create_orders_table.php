<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_code')->unique();
            $table->foreignId('customer_id')->nullable()->constrained()->nullOnDelete();
            $table->string('customer_name');
            $table->string('phone', 30);
            $table->string('address')->nullable();
            $table->string('item_type');
            $table->string('color')->nullable();
            $table->string('condition')->nullable();
            $table->string('service_choice');
            $table->string('brand')->nullable();
            $table->string('service');
            $table->string('photo_path');
            $table->string('photo_name');
            $table->text('notes')->nullable();
            $table->string('payment_method');
            $table->string('status')->default('Baru');
            $table->timestamps();

            $table->index(['status', 'created_at']);
            $table->index(['customer_name', 'phone']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

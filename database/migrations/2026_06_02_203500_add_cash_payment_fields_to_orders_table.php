<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedInteger('service_price')->default(0)->after('service');
            $table->unsignedInteger('cash_paid')->nullable()->after('service_price');
            $table->integer('cash_change')->nullable()->after('cash_paid');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['service_price', 'cash_paid', 'cash_change']);
        });
    }
};

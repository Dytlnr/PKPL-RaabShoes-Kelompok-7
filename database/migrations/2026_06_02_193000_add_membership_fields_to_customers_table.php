<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->string('member_code')->nullable()->unique()->after('customer_code');
            $table->unsignedInteger('reward_redemptions')->default(0)->after('address');
        });
    }

    public function down(): void
    {
        Schema::table('customers', function (Blueprint $table) {
            $table->dropUnique(['member_code']);
            $table->dropColumn(['member_code', 'reward_redemptions']);
        });
    }
};

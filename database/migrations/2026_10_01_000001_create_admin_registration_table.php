<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin_registration', function (Blueprint $table) {
            $table->unsignedTinyInteger('id')->primary();
            $table->boolean('completed')->default(false);
        });
        DB::table('admin_registration')->insert([
            'id' => 1,
            'completed' => DB::table('users')->where('role', 'admin')->exists(),
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('admin_registration');
    }
};

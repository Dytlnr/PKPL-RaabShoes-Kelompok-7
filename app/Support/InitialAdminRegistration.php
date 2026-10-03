<?php

namespace App\Support;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class InitialAdminRegistration
{
    public static function isOpen(): bool
    {
        return DB::table('admin_registration')->where('id', 1)->where('completed', false)->exists()
            && ! User::where('role', 'admin')->exists();
    }

    public static function register(array $data): bool
    {
        return DB::transaction(function () use ($data) {
            // Claim the single setup row atomically, including concurrent submissions.
            $claimed = DB::table('admin_registration')->where('id', 1)
                ->where('completed', false)->update(['completed' => true]);

            if (! $claimed || User::where('role', 'admin')->exists()) {
                return false;
            }

            User::create([
                'name' => $data['name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => $data['password'],
                'role' => 'admin',
            ]);

            return true;
        }, 3);
    }
}

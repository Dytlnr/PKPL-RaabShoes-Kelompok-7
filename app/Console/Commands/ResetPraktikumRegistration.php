<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class ResetPraktikumRegistration extends Command
{
    protected $signature = 'praktikum:reset-registration';

    protected $description = 'Reset akun dan sesi demo pada database praktikum yang terisolasi';

    public function handle(): int
    {
        try {
            $this->assertIsolatedDatabase();
        } catch (RuntimeException $error) {
            $this->error($error->getMessage());
            return self::FAILURE;
        }

        DB::transaction(function () {
            // Acquire the same setup row used by registration before deleting demo accounts.
            if (DB::table('admin_registration')->where('id', 1)->lockForUpdate()->first() === null) {
                throw new RuntimeException('Setup belum tersedia. Jalankan php praktikum.php prepare.');
            }
            DB::table('admin_registration')->where('id', 1)->update(['completed' => false]);
            DB::table('sessions')->delete();
            DB::table('password_reset_tokens')->delete();
            DB::table('users')->delete();
        });

        $this->info('Akun Admin/Pegawai demo dan sesi login praktikum sudah dihapus. Data order/pelanggan tetap ada.');
        $this->info('Buka ulang http://127.0.0.1:8010/register untuk mengulang registrasi.');
        return self::SUCCESS;
    }

    private function assertIsolatedDatabase(): void
    {
        $expected = storage_path('praktikum/database.sqlite');
        $config = config('database.connections.sqlite');
        if (
            ! app()->environment('praktikum')
            || config('database.default') !== 'sqlite'
            || ($config['database'] ?? null) !== $expected
            || ! empty($config['url'])
            || is_link(dirname($expected)) || is_link($expected)
            || ! is_file($expected) || stat($expected)['nlink'] !== 1
            || config('session.driver') !== 'database'
            || config('session.connection') !== 'sqlite'
            || config('session.table') !== 'sessions'
            || config('session.cookie') !== 'raabshoes_praktikum_session'
        ) {
            throw new RuntimeException('Reset ditolak: gunakan php praktikum.php reset pada profil praktikum terpisah.');
        }

        // Verify the actual open database, not just the configured connection name.
        $database = collect(DB::select('PRAGMA database_list'))->firstWhere('name', 'main');
        if (! $database || realpath($database->file) !== realpath($expected)) {
            throw new RuntimeException('Reset ditolak: koneksi aktif bukan database praktikum.');
        }
    }
}

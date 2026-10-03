<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\InitialAdminRegistration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PraktikumResetTest extends TestCase
{
    private string $temporaryStorage;

    protected function setUp(): void
    {
        parent::setUp();
        $this->temporaryStorage = sys_get_temp_dir().'/raab-praktikum-'.bin2hex(random_bytes(8));
        mkdir($this->temporaryStorage.'/praktikum', 0700, true);
        touch($this->temporaryStorage.'/praktikum/database.sqlite');
        $this->app->useStoragePath($this->temporaryStorage);
        $this->app->instance('env', 'praktikum');
        config([
            'database.default' => 'sqlite',
            'database.connections.sqlite.database' => $this->temporaryStorage.'/praktikum/database.sqlite',
            'database.connections.sqlite.url' => null,
            'session.driver' => 'database', 'session.connection' => 'sqlite',
            'session.table' => 'sessions', 'session.cookie' => 'raabshoes_praktikum_session',
        ]);
        DB::purge('sqlite');
        $this->artisan('migrate', ['--force' => true])->assertExitCode(0);
    }

    protected function tearDown(): void
    {
        DB::purge('sqlite');
        File::deleteDirectory($this->temporaryStorage);
        parent::tearDown();
    }

    public function test_reset_reopens_registration_clears_accounts_and_sessions_and_preserves_customers(): void
    {
        InitialAdminRegistration::register(['name' => 'Demo', 'username' => 'demo',
            'email' => 'demo@example.com', 'phone' => '08123', 'password' => 'password123']);
        User::factory()->create(['role' => 'pegawai']);
        DB::table('sessions')->insert(['id' => 'old-demo-session', 'payload' => 'old', 'last_activity' => time()]);
        DB::table('customers')->insert(['customer_code' => 'CUS-DEMO', 'name' => 'Demo', 'phone' => '08123']);
        $this->assertFalse(InitialAdminRegistration::isOpen());
        $this->artisan('praktikum:reset-registration')->assertExitCode(0);
        $this->assertDatabaseCount('users', 0);
        $this->assertDatabaseCount('sessions', 0);
        $this->assertDatabaseCount('customers', 1);
        $this->assertTrue(InitialAdminRegistration::isOpen());
        $this->artisan('praktikum:reset-registration')->assertExitCode(0);
    }

    public function test_reset_refuses_main_environment_without_deleting_accounts(): void
    {
        User::factory()->create(['role' => 'admin']);
        $this->app->instance('env', 'local');
        $this->artisan('praktikum:reset-registration')->assertExitCode(1);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_reset_refuses_different_database_and_shared_session_cookie(): void
    {
        User::factory()->create(['role' => 'admin']);
        config(['session.cookie' => 'main_session']);
        $this->artisan('praktikum:reset-registration')->assertExitCode(1);
        config(['session.cookie' => 'raabshoes_praktikum_session', 'database.connections.sqlite.database' => ':memory:']);
        $this->artisan('praktikum:reset-registration')->assertExitCode(1);
        $this->assertDatabaseCount('users', 1);
    }
}

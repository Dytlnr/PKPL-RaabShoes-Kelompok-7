<?php

namespace Tests\Feature;

use App\Models\User;
use App\Support\InitialAdminRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class InitialAdminRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private function data(): array
    {
        return ['name' => 'Admin Toko', 'username' => 'owner', 'email' => 'owner@example.com',
            'phone' => '08123456789', 'password' => 'password123', 'password_confirmation' => 'password123'];
    }

    public function test_first_admin_can_register_then_login_and_registration_closes(): void
    {
        $this->get('/login')->assertOk()->assertSee('Daftar Admin pertama');
        $this->get('/register')->assertOk()->assertSee('Buat akun Admin');
        $this->post('/register', $this->data() + ['role' => 'pegawai'])->assertRedirect('/login');
        $admin = User::sole();
        $this->assertSame('admin', $admin->role);
        $this->assertTrue(Hash::check('password123', $admin->password));
        $this->post('/login', ['email' => 'owner', 'password' => 'password123'])
            ->assertRedirect('/dashboard')->assertSessionHas('social_auth.user_id', $admin->id);
        $this->get('/register')->assertSee('Registrasi Admin pertama sudah ditutup')->assertDontSee('name="password_confirmation"', false);
        $this->post('/register', $this->data())->assertRedirect('/register')->assertSessionHas('error');
        $this->assertDatabaseCount('users', 1);
    }

    public function test_existing_admin_blocks_registration_without_creating_default_account(): void
    {
        User::factory()->create(['role' => 'admin']);
        $this->post('/register', $this->data())->assertRedirect('/register');
        $this->assertDatabaseCount('users', 1);
        $this->assertFalse(InitialAdminRegistration::isOpen());
    }

    public function test_invalid_inputs_leave_setup_available_and_do_not_flash_passwords(): void
    {
        $cases = [
            ['name' => ''], ['username' => 'bad user'], ['email' => 'invalid'], ['phone' => ''],
            ['password' => '1234567'], ['password' => str_repeat('a', 17)],
            ['password_confirmation' => 'different'],
        ];
        foreach ($cases as $changes) {
            $this->from('/register')->post('/register', array_replace($this->data(), $changes))
                ->assertRedirect('/register')->assertSessionHasErrors()
                ->assertSessionMissing('_old_input.password')->assertSessionMissing('_old_input.password_confirmation');
            $this->assertDatabaseCount('users', 0);
            $this->assertTrue(InitialAdminRegistration::isOpen());
        }
    }

    public function test_duplicate_staff_identity_is_rejected(): void
    {
        User::factory()->create(['role' => 'pegawai', 'email' => 'owner@example.com', 'username' => 'owner']);
        $this->post('/register', $this->data())->assertSessionHasErrors(['email', 'username']);
        $this->assertDatabaseCount('users', 1);
    }

    public function test_password_boundaries_and_identity_normalization(): void
    {
        foreach ([8, 16] as $length) {
            $password = str_repeat('a', $length);
            $this->post('/register', array_replace($this->data(), [
                'username' => ' OWNER ', 'email' => ' OWNER@EXAMPLE.COM ',
                'password' => $password, 'password_confirmation' => $password,
            ]))->assertRedirect('/login');
            $admin = User::sole();
            $this->assertSame('owner', $admin->username);
            $this->assertSame('owner@example.com', $admin->email);
            $this->assertTrue(Hash::check($password, $admin->password));
            // Reset only the isolated in-memory test database for the second boundary.
            User::query()->delete();
            DB::table('admin_registration')->update(['completed' => false]);
        }
    }

    public function test_setup_claim_cannot_be_reused_even_if_admin_is_removed(): void
    {
        $this->assertTrue(InitialAdminRegistration::register($this->data()));
        User::query()->delete();
        $this->assertFalse(InitialAdminRegistration::register($this->data()));
        $this->assertFalse(InitialAdminRegistration::isOpen());
        $this->assertDatabaseCount('users', 0);
    }

    public function test_login_and_forgot_password_do_not_bootstrap_an_admin(): void
    {
        $this->post('/login', ['email' => 'admin', 'password' => 'admin12345'])->assertSessionHas('error');
        $this->post('/forgot-password', ['identity' => 'admin'])->assertSessionHas('error');
        $this->assertDatabaseCount('users', 0);
        $this->assertTrue(InitialAdminRegistration::isOpen());
    }
}

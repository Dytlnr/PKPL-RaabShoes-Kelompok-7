<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AccountManagementAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_staff_cannot_view_create_or_delete_accounts_despite_admin_session_claims(): void
    {
        $staff = User::factory()->create(['role' => 'pegawai', 'username' => 'admin']);
        $target = User::factory()->create(['role' => 'admin']);
        $this->withSession(['social_auth' => [
            'user_id' => $staff->id, 'role' => 'admin', 'provider' => 'google',
            'username' => 'admin', 'email' => 'admin@raabshoes.com',
        ]]);
        $this->get(route('settings.index'))->assertForbidden();
        $this->post(route('settings.users.store'), $this->newAccount())->assertForbidden();
        $this->delete(route('settings.users.destroy', $target))->assertForbidden();
        $this->assertDatabaseCount('users', 2);
        $this->get(route('dashboard'))->assertOk()->assertSee('Pengaturan')->assertSee('href="'.route('settings.password').'"', false)->assertDontSee('href="'.route('settings.index').'"', false);
        $this->get(route('settings.password'))->assertOk()->assertDontSee('Akun Tim');
    }

    public function test_guest_cannot_view_or_create_accounts(): void
    {
        $this->get(route('settings.index'))->assertForbidden();
        $this->post(route('settings.users.store'), $this->newAccount())->assertForbidden();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_google_session_without_registered_admin_cannot_manage_accounts(): void
    {
        $this->withSession(['social_auth' => ['provider' => 'google', 'role' => 'admin', 'email' => 'unknown@example.com']]);
        $this->get(route('settings.index'))->assertForbidden();
        $this->post(route('settings.users.store'), $this->newAccount())->assertForbidden();
        $this->assertDatabaseCount('users', 0);
    }

    public function test_admin_can_view_and_create_staff_accounts(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->withSession(['social_auth' => ['user_id' => $admin->id]]);
        $this->get(route('settings.index'))->assertOk()->assertSee('Tambah Akun');
        $this->post(route('settings.users.store'), $this->newAccount())->assertRedirect(route('settings.index'));
        $this->assertDatabaseHas('users', ['email' => 'newstaff@example.com', 'role' => 'pegawai']);
    }

    public function test_staff_can_change_only_their_own_password(): void
    {
        $staff = User::factory()->create(['role' => 'pegawai', 'password' => 'old-password']);
        $admin = User::factory()->create(['role' => 'admin', 'password' => 'admin-password']);
        $this->withSession(['social_auth' => ['user_id' => $staff->id]])
            ->post(route('settings.password.update'), [
                'user_id' => $admin->id,
                'current_password' => 'old-password',
                'password' => 'new-password',
                'password_confirmation' => 'new-password',
            ])->assertRedirect(route('settings.password'))->assertSessionHas('success');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('new-password', $staff->fresh()->password));
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('admin-password', $admin->fresh()->password));
    }

    public function test_password_change_requires_correct_current_password_and_confirmation(): void
    {
        $staff = User::factory()->create(['role' => 'pegawai', 'password' => 'old-password']);
        $this->withSession(['social_auth' => ['user_id' => $staff->id]]);
        $this->post(route('settings.password.update'), [
            'current_password' => 'wrong-password', 'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])->assertSessionHasErrors('current_password');
        $this->post(route('settings.password.update'), [
            'current_password' => 'old-password', 'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ])->assertSessionHasErrors('password');
        $this->assertTrue(\Illuminate\Support\Facades\Hash::check('old-password', $staff->fresh()->password));
    }

    public function test_guest_cannot_change_password_from_settings(): void
    {
        $this->get(route('settings.password'))->assertForbidden();
        $this->post(route('settings.password.update'), [])->assertForbidden();
    }

    public function test_password_length_limits_without_character_composition_requirements(): void
    {
        $staff = User::factory()->create(['role' => 'pegawai', 'password' => 'old-password']);
        $this->withSession(['social_auth' => ['user_id' => $staff->id]]);

        foreach ([7, 17] as $length) {
            $password = str_repeat('a', $length);
            $this->post(route('settings.password.update'), [
                'current_password' => 'old-password', 'password' => $password,
                'password_confirmation' => $password,
            ])->assertSessionHasErrors('password');
        }

        $current = 'old-password';
        foreach ([8, 16] as $length) {
            $password = str_repeat('a', $length);
            $this->post(route('settings.password.update'), [
                'current_password' => $current, 'password' => $password,
                'password_confirmation' => $password,
            ])->assertRedirect(route('settings.password'))->assertSessionHas('success');
            $this->assertTrue(\Illuminate\Support\Facades\Hash::check($password, $staff->fresh()->password));
            $current = $password;
        }
    }

    private function newAccount(): array
    {
        return ['name' => 'New Staff', 'username' => 'newstaff', 'email' => 'newstaff@example.com',
            'phone' => '0812345678', 'password' => 'password123', 'password_confirmation' => 'password123'];
    }
}

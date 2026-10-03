<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DeleteAccountTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_delete_another_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $staff = User::factory()->create(['role' => 'pegawai']);
        $this->withSession(['social_auth' => ['user_id' => $admin->id]])
            ->delete(route('settings.users.destroy', $staff))->assertRedirect(route('settings.index'));
        $this->assertDatabaseMissing('users', ['id' => $staff->id]);
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_admin_cannot_delete_own_account(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->withSession(['social_auth' => ['user_id' => $admin->id]])
            ->from('/settings')->delete(route('settings.users.destroy', $admin))
            ->assertRedirect('/settings')->assertSessionHas('error');
        $this->assertDatabaseHas('users', ['id' => $admin->id]);
    }

    public function test_staff_cannot_delete_even_with_stale_admin_role_in_session(): void
    {
        $staff = User::factory()->create(['role' => 'pegawai']);
        $target = User::factory()->create(['role' => 'admin']);
        $this->withSession(['social_auth' => ['user_id' => $staff->id, 'role' => 'admin']])
            ->delete(route('settings.users.destroy', $target))->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $target->id]);
    }

    public function test_guest_cannot_delete_an_account(): void
    {
        $target = User::factory()->create(['role' => 'pegawai']);
        $this->delete(route('settings.users.destroy', $target))->assertForbidden();
        $this->assertDatabaseHas('users', ['id' => $target->id]);
    }
}

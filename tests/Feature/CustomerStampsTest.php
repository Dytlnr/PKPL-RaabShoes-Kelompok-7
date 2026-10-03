<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CustomerStampsTest extends TestCase
{
    use RefreshDatabase;

    private function customer(string $code = 'CUS-TEST'): Customer
    {
        return Customer::create(['customer_code' => $code, 'member_code' => 'MEM-'.$code,
            'name' => 'Pelanggan Uji', 'phone' => $code, 'reward_redemptions' => 0]);
    }

    private function order(Customer $customer, string $date, string $status = 'Diambil'): Order
    {
        $order = $customer->orders()->create(['order_code' => 'ORD-'.Order::count(),
            'customer_name' => $customer->name, 'phone' => $customer->phone,
            'item_type' => 'Sepatu', 'service_choice' => 'Sepatu', 'service' => 'Deep Clean - Reguler',
            'photo_path' => '', 'photo_name' => '', 'payment_method' => 'Cash (Tunai)',
            'status' => $status]);
        $order->forceFill(['created_at' => $date, 'updated_at' => $date])->save();
        return $order;
    }

    public function test_multiple_items_on_same_intake_date_only_earn_one_stamp(): void
    {
        $customer = $this->customer();
        for ($i = 0; $i < 10; $i++) {
            $this->order($customer, '2026-09-01 '.(10 + $i).':00:00');
        }
        $this->order($customer, '2026-09-02 10:00:00', 'Diproses');
        $this->order($customer, '2026-09-03 10:00:00', 'Baru');
        $customer->refresh();
        $this->assertSame(10, $customer->completed_wash_orders_count);
        $this->assertSame(1, $customer->earned_stamps_count);
        $this->assertSame(1, $customer->current_stamp_progress);
        $this->assertSame(0, $customer->available_rewards);
        $this->get('/customers')->assertOk()->assertSee('10 order selesai pada tanggal masuk ini');
        $this->post('/customers/'.$customer->customer_code.'/redeem')->assertRedirect();
        $this->assertSame(0, (int) $customer->fresh()->reward_redemptions);
    }

    public function test_separate_dates_and_customers_count_independently_and_reward_uses_eight_stamps(): void
    {
        $customer = $this->customer();
        for ($day = 1; $day <= 9; $day++) {
            $this->order($customer, sprintf('2026-09-%02d 10:00:00', $day));
            $this->order($customer, sprintf('2026-09-%02d 11:00:00', $day), 'Siap Diambil');
        }
        $other = $this->customer('CUS-OTHER');
        $this->order($other, '2026-09-01 10:00:00');
        $this->assertSame(1, $other->earned_stamps_count);
        $this->assertSame(9, $customer->earned_stamps_count);
        $this->assertSame(1, $customer->available_rewards);
        $this->post('/customers/'.$customer->customer_code.'/redeem')->assertRedirect();
        $customer->refresh();
        $this->assertSame(1, (int) $customer->reward_redemptions);
        $this->assertSame(1, $customer->current_stamp_progress);
        $this->assertSame(0, $customer->available_rewards);
    }

    public function test_finishing_another_item_later_does_not_create_an_extra_stamp(): void
    {
        $customer = $this->customer();
        $this->order($customer, '2026-09-01 10:00:00');
        $pending = $this->order($customer, '2026-09-01 11:00:00', 'Diproses');
        $pending->forceFill(['status' => 'Siap Diambil', 'updated_at' => '2026-09-05 12:00:00'])->save();
        $customer->refresh();
        $this->assertSame(1, $customer->earned_stamps_count);
        $customer->update(['reward_redemptions' => 2]);
        $this->assertSame(0, $customer->unused_stamps);
        $this->assertSame(0, $customer->available_rewards);
    }

    public function test_deleting_orders_recounts_stamps_and_preserves_customer_and_other_orders(): void
    {
        $customer = $this->customer();
        $first = $this->order($customer, '2026-09-01 10:00:00');
        $second = $this->order($customer, '2026-09-01 11:00:00');
        $this->withSession(['social_auth' => ['role' => 'admin', 'name' => 'Admin']])
            ->delete(route('orders.destroy', $first->order_code), ['redirect_status' => 'Diambil', 'search' => 'Pelanggan'])
            ->assertRedirect(route('orders.index', ['status' => 'Diambil', 'search' => 'Pelanggan']))
            ->assertSessionHas('success');
        $this->assertDatabaseMissing('orders', ['id' => $first->id]);
        $this->assertDatabaseHas('orders', ['id' => $second->id]);
        $this->assertDatabaseHas('customers', ['id' => $customer->id]);
        $this->assertSame(1, $customer->fresh()->earned_stamps_count);
        $this->delete(route('orders.destroy', $second->order_code))->assertRedirect();
        $this->assertSame(0, $customer->fresh()->earned_stamps_count);
        $this->delete(route('orders.destroy', $second->order_code))->assertNotFound();
    }

    public function test_guests_cannot_delete_orders(): void
    {
        $customer = $this->customer();
        $order = $this->order($customer, '2026-09-01 10:00:00');
        $this->delete(route('orders.destroy', $order->order_code))->assertRedirect(route('login'));
        $this->assertDatabaseHas('orders', ['id' => $order->id]);
    }
}

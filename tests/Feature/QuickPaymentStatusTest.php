<?php
namespace Tests\Feature;

use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuickPaymentStatusTest extends TestCase
{
    use RefreshDatabase;

    public function test_quick_payment_and_work_status_are_reflected_in_fresh_whatsapp_redirect(): void
    {
        $order = Order::create(['order_code' => 'RS0012', 'customer_name' => 'Test', 'phone' => '0812345',
            'item_type' => 'Sepatu', 'service_choice' => 'Sepatu', 'service' => 'Deep Clean - Reguler',
            'service_price' => 30000, 'photo_path' => '', 'photo_name' => '',
            'status' => 'Diproses', 'payment_status' => 'Belum Lunas']);
        $url = route('orders.whatsapp', $order->order_code);
        $this->assertStringContainsString('Belum Lunas', urldecode($this->get($url)->headers->get('Location')));
        $this->withSession(['social_auth' => ['role' => 'pegawai']])
            ->post(route('orders.payment-status', $order->order_code), ['payment_status' => 'Lunas'])
            ->assertSessionHasNoErrors()->assertRedirect();
        $this->post(route('orders.status', $order->order_code), ['status' => 'Siap Diambil'])->assertRedirect();
        $legacy = $this->get($url . '?preview=1');
        $legacy->assertStatus(302);
        $this->assertStringStartsWith('https://web.whatsapp.com/send?', $legacy->headers->get('Location'));
        $this->assertStringContainsString('Status: *Siap Diambil*', urldecode($legacy->headers->get('Location')));
        $response = $this->get($url);
        $this->assertStringStartsWith('https://web.whatsapp.com/send?', $response->headers->get('Location'));
        $mobile = $this->withHeader('User-Agent', 'iPhone Mobile')->get($url);
        $this->assertStringStartsWith('https://wa.me/', $mobile->headers->get('Location'));
        $this->assertStringContainsString('Status Pembayaran: *Lunas*', urldecode($mobile->headers->get('Location')));
        $message = urldecode($response->headers->get('Location'));
        $this->assertStringContainsString('Status Pembayaran: *Lunas*', $message);
        $this->assertStringContainsString('Status: *Siap Diambil*', $message);
        $this->assertStringContainsString('no-store', $response->headers->get('Cache-Control'));
        $this->post(route('orders.payment-status', $order->order_code), ['payment_status' => 'Invalid'])
            ->assertSessionHasErrors('payment_status');
        $this->assertSame('Lunas', $order->fresh()->payment_status);
        $this->post(route('orders.payment-status', $order->order_code), ['payment_status' => 'Belum Lunas'])->assertRedirect();
        $this->assertSame('Belum Lunas', $order->fresh()->payment_status);
        $this->assertNull($order->fresh()->payment_method);
    }

    public function test_guest_cannot_change_payment_status(): void
    {
        $this->post('/orders/RS0012/payment-status', ['payment_status' => 'Lunas'])->assertRedirect(route('login'));
    }
}

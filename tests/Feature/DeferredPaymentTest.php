<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Support\OrderPayment;
use App\Support\WhatsAppReceipt;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DeferredPaymentTest extends TestCase
{
    use RefreshDatabase;

    public function test_unpaid_order_can_be_saved_then_settled_on_pickup(): void
    {
        $order = Order::create(['order_code' => 'RS0001', 'customer_name' => 'Test', 'phone' => '08123',
            'item_type' => 'Sepatu', 'service_choice' => 'Sepatu', 'service' => 'Deep Clean - Reguler',
            'photo_path' => '', 'photo_name' => '', 'status' => 'Baru',
            ...OrderPayment::resolve(['payment_status' => 'Belum Lunas'], 30000)]);
        $this->assertNull($order->fresh()->payment_method);
        $payload = ['customer_name' => 'Test', 'phone' => '08123', 'service_choice' => 'Sepatu',
            'service' => 'Deep Clean - Reguler', 'status' => 'Diambil', 'payment_status' => 'Lunas',
            'payment_method' => 'Cash (Tunai)', 'cash_paid' => '50.000'];
        $this->post(route('orders.update', $order->order_code), $payload)->assertSessionHasNoErrors();
        $order->refresh();
        $this->assertSame('Lunas', $order->payment_status);
        $this->assertSame(20000, $order->cash_change);
        $this->post(route('orders.update', $order->order_code), [...$payload, 'cash_paid' => '10000'])
            ->assertSessionHasErrors('cash_paid');
        $this->assertSame(50000, $order->fresh()->cash_paid);
    }

    public function test_unpaid_receipt_does_not_claim_cash_was_received(): void
    {
        $data = OrderPayment::resolve(['payment_status' => 'Belum Lunas', 'payment_method' => 'Cash (Tunai)', 'cash_paid' => '50000'], 30000);
        $this->assertNull($data['payment_method']);
        $this->assertNull($data['cash_paid']);
        $order = new Order([...$data, 'service_price' => 30000]);
        $order->setRelation('customer', null);
        $message = WhatsAppReceipt::make($order);
        $this->assertStringContainsString('Status Pembayaran: *Belum Lunas*', $message);
        $this->assertStringNotContainsString('Dibayar:', $message);
    }

    public function test_cash_order_can_be_marked_paid_without_recording_cash_amount(): void
    {
        $order = Order::create(['order_code' => 'RS0099', 'customer_name' => 'Test', 'phone' => '08123',
            'item_type' => 'Sepatu', 'service_choice' => 'Sepatu', 'service' => 'Deep Clean - Reguler',
            'photo_path' => '', 'photo_name' => '', 'status' => 'Baru',
            'payment_method' => 'Cash (Tunai)', 'payment_status' => 'Belum Lunas']);
        $this->post(route('orders.update', $order->order_code), [
            'customer_name' => 'Test', 'phone' => '08123', 'service_choice' => 'Sepatu',
            'service' => 'Deep Clean - Reguler', 'status' => 'Baru',
            'payment_method' => 'Cash (Tunai)', 'payment_status' => 'Lunas', 'cash_paid' => '',
        ])->assertSessionHasNoErrors()->assertRedirect();
        $this->assertSame('Lunas', $order->fresh()->payment_status);
        $this->assertNull($order->fresh()->cash_paid);
        $this->get(route('orders.index'))->assertOk()->assertSee('data-payment="Lunas"', false);
        $message = WhatsAppReceipt::make($order->fresh());
        $this->assertStringContainsString('Status Pembayaran: *Lunas*', $message);
        $this->assertStringNotContainsString('Dibayar:', $message);
    }

    public function test_paid_status_allows_optional_payment_method(): void
    {
        $payment = OrderPayment::resolve(['payment_status' => 'Lunas'], 30000);
        $this->assertNull($payment['payment_method']);
        $this->assertNull($payment['cash_paid']);
    }
}

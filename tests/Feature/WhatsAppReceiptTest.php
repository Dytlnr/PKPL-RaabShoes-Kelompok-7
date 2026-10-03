<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Support\WhatsAppReceipt;
use Tests\TestCase;

class WhatsAppReceiptTest extends TestCase
{
    public function test_cash_receipt_contains_totals_and_pickup_message(): void
    {
        $order = new Order([
            'order_code' => 'RS2168', 'customer_name' => 'Dyta',
            'service' => 'Deep Clean', 'service_price' => 25000,
            'payment_method' => 'Cash (Tunai)', 'cash_paid' => 30000,
            'cash_change' => 5000, 'status' => 'Siap Diambil',
        ]);
        $order->setRelation('customer', null);
        $message = WhatsAppReceipt::make($order, ['date' => '04/06/2026', 'label' => '1 hari']);
        foreach (['*RAAB SHOES*', 'No Nota: RS2168', '*Total Tagihan: Rp 25.000*', 'Dibayar: Rp 30.000', 'Kembali: Rp 5.000', 'Silakan datang', '04/06/2026'] as $text) {
            $this->assertStringContainsString($text, $message);
        }
    }

    public function test_qris_does_not_claim_unrecorded_payment(): void
    {
        $order = new Order(['payment_method' => 'QRIS', 'service_price' => 25000, 'cash_paid' => 0]);
        $order->setRelation('customer', null);
        $message = WhatsAppReceipt::make($order);
        $this->assertStringContainsString('Metode Bayar: QRIS', $message);
        $this->assertStringNotContainsString('Dibayar:', $message);
        $this->assertStringNotContainsString('Kembali:', $message);
    }
}

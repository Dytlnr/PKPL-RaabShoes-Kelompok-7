<?php

namespace App\Support;

use App\Models\Customer;
use App\Models\Order;

class WhatsAppReceipt
{
    public static function make(Order $order, ?array $estimate = null): string
    {
        $rupiah = fn ($amount) => 'Rp ' . number_format((int) $amount, 0, ',', '.');
        $price = $order->service_price;
        $lines = [
            '*RAAB SHOES*', '',
            "Halo kak {$order->customer_name},",
            'Berikut detail transaksi Anda:', '',
            "No Nota: {$order->order_code}",
            'Tanggal: ' . ($order->created_at?->format('d/m/Y, H.i') ?? '-'),
            'Layanan:',
            '- ' . ($order->service ?: '-'),
            '- 1 x ' . $rupiah($price) . ' = ' . $rupiah($price),
            '- Barang: ' . ($order->service_choice ?: $order->item_type ?: '-'),
            '- Merek: ' . ($order->brand ?: '-'),
            '', '--------------------',
            '*Total Tagihan: ' . $rupiah($price) . '*',
            'Status Pembayaran: *' . ($order->payment_status ?? 'Belum dikonfirmasi') . '*',
            'Metode Bayar: ' . ($order->payment_method ?: 'Belum ditentukan'),
        ];

        if ($order->payment_status !== 'Belum Lunas' && $order->payment_method === 'Cash (Tunai)' && $order->cash_paid !== null) {
            $lines[] = 'Dibayar: ' . $rupiah($order->cash_paid);
            $lines[] = 'Kembali: ' . $rupiah($order->cash_change ?? 0);
        }

        $lines[] = '--------------------';
        $lines[] = 'Status: *' . ($order->status ?: 'Baru') . '*';
        if ($estimate) {
            $lines[] = "Estimasi Pengambilan: {$estimate['date']} ({$estimate['label']})";
        }
        if ($customer = $order->customer) {
            $lines[] = '';
            $lines[] = 'Stempel Member: ' . $customer->current_stamp_progress . '/' . Customer::MEMBER_STAMP_TARGET;
            $lines[] = 'Reward tersedia: ' . $customer->available_rewards;
        }
        $lines[] = '';
        $lines[] = match ($order->status) {
            'Siap Diambil' => 'Sepatu Anda sudah selesai. Silakan datang untuk pengambilan ya, kak!',
            'Diambil' => 'Pesanan sudah diambil. Semoga nyaman menemani langkah berikutnya!',
            default => 'Pesanan Anda sedang kami tangani. Kami kabari saat siap diambil ya, kak!',
        };
        $lines[] = 'Terima kasih telah menggunakan jasa Raab Shoes!';
        $lines[] = '';
        $lines[] = 'Pertanyaan/aduan: silakan balas chat ini.';

        return implode("\n", $lines);
    }
}

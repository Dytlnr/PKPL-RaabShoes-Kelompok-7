<?php

namespace App\Support;

use Illuminate\Validation\ValidationException;

class OrderPayment
{
    public static function resolve(array $data, int $price): array
    {
        $status = $data['payment_status'] ?? 'Belum Lunas';
        $method = $status === 'Belum Lunas' ? null : ($data['payment_method'] ?? null);
        $paid = null;
        $change = null;
        if ($status === 'Lunas' && $method === 'Cash (Tunai)') {
            $raw = preg_replace('/\D+/', '', (string) ($data['cash_paid'] ?? ''));
            if ($raw === '') {
                return ['payment_status' => $status, 'payment_method' => $method,
                    'cash_paid' => null, 'cash_change' => null];
            }
            if ((int) $raw < $price) {
                throw ValidationException::withMessages([
                   'cash_paid' => 'Nominal yang diisi kurang dari tagihan. ' .
                        'Koreksi nominal atau kosongkan jika tidak dicatat.',
                ]);
            }
            $paid = (int) $raw;
            $change = $paid - $price;
        }

        return ['payment_status' => $status, 'payment_method' => $method,
            'cash_paid' => $paid, 'cash_change' => $change];
    }
}

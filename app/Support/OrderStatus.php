<?php

namespace App\Support;

final class OrderStatus
{
    public const ALL = 'Semua Status';
    public const READY = 'Siap Diambil';
    public const PAYMENT_RULE = 'in:Belum Lunas,Lunas';
}

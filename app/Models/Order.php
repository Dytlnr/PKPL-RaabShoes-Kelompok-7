<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_code',
        'customer_id',
        'customer_name',
        'phone',
        'address',
        'item_type',
        'color',
        'condition',
        'service_choice',
        'brand',
        'service',
        'photo_path',
        'photo_name',
        'notes',
        'service_price',
        'cash_paid',
        'cash_change',
        'payment_method',
        'payment_status',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'service_price' => 'integer',
            'cash_paid' => 'integer',
            'cash_change' => 'integer',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }

    protected $appends = [
        'photo_url',
    ];

    /** @return BelongsTo<Customer, $this> */
    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        if (! $this->photo_path) {
            return null;
        }

        return asset($this->photo_path);
    }
}

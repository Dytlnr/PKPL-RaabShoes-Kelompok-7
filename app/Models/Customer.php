<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Collection;

class Customer extends Model
{
    use HasFactory;

    public const MEMBER_STAMP_TARGET = 8;

    protected $fillable = [
        'customer_code',
        'member_code',
        'name',
        'phone',
        'address',
        'reward_redemptions',
    ];

    /** @return HasMany<Order, $this> */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function getCompletedWashOrdersCountAttribute(): int
    {
        return $this->orders()
            ->whereIn('status', ['Siap Diambil', 'Diambil'])
            ->count();
    }

    /** One stamp per customer and intake date, once any order that day is complete. */
    public function stampVisits(): Collection
    {
        return $this->orders
            ->filter(fn (Order $order) => $order->created_at !== null
                && in_array($order->status, ['Siap Diambil', 'Diambil'], true))
            ->sortBy('created_at')
            ->groupBy(fn (Order $order) => $order->created_at->format('Y-m-d'));
    }

    public function getEarnedStampsCountAttribute(): int
    {
        return $this->stampVisits()->count();
    }

    public function getUnusedStampsAttribute(): int
    {
        return max($this->earned_stamps_count - ($this->reward_redemptions * self::MEMBER_STAMP_TARGET), 0);
    }

    public function getAvailableRewardsAttribute(): int
    {
        return intdiv($this->unused_stamps, self::MEMBER_STAMP_TARGET);
    }

    public function getCurrentStampProgressAttribute(): int
    {
        if ($this->available_rewards > 0) {
            return self::MEMBER_STAMP_TARGET;
        }

        return $this->unused_stamps % self::MEMBER_STAMP_TARGET;
    }
}

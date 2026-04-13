<?php

namespace App\Models;

use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Delivery extends Model
{
    Use UsedFunctions;

    const PICKUP_DELIVERY_ID = 1;
    const DELIVERY_TO_ADDRESS = 2;
    const DELIVERY_TO_CITY = 3;

    protected $guarded = [];

    public $timestamps = false;

    public function priceRanges(): HasMany
    {
        return $this->hasMany(DeliveryPriceRange::class)->orderBy('from_sum');
    }

    public function getActualPrice(float $totalSum): float
    {
        $range = $this->priceRanges()
            ->where('from_sum', '<=', $totalSum)
            ->where(function ($query) use ($totalSum) {
                $query->where('to_sum', '>=', $totalSum)
                    ->orWhereNull('to_sum');
            })
            ->first();

        return $range ? $range->price : 0;
    }

}

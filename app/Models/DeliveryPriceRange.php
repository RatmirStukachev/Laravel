<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryPriceRange extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'delivery_id',
        'from_sum',
        'to_sum',
        'price',
        'pos'
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }
}

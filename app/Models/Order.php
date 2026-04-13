<?php

namespace App\Models;

use App\Models\Product;
use App\Models\Delivery;
use App\Models\Promocode;
use App\Enums\CustomerEnum;
use App\Models\PaymentType;
use App\Models\OrderProduct;
use App\Models\OrderAddress;
use App\Models\Company;
use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use UsedFunctions;

    protected $guarded = [];

    protected $casts = [
        'customer_type' => CustomerEnum::class,
    ];

    public function orderProducts(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    public function products()
    {
        return $this->hasManyThrough(
            Product::class,
            OrderProduct::class,
            'order_id',
            'id', 
            'id',
            'product_id',
        );
    }

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class, 'delivery_id', 'id');
    }

    public function paymentType(): BelongsTo
    {
        return $this->belongsTo(PaymentType::class, 'payment_type_id', 'id');
    }

    public function orderAddress(): BelongsTo
    {
        return $this->belongsTo(OrderAddress::class, 'order_address_id', 'id');
    }

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}

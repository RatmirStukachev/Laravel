<?php

namespace App\Models;

use App\Enums\CustomerEnum;
use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PaymentType extends Model
{
    use UsedFunctions;

    const CASH_PAYMENT_TYPE_ID = 1;
    const BEZNAL_PAYMENT_TYPE_ID = 5;

    protected $guarded = [];

    protected $casts = [
        'customers' => 'array',
    ];

    public static function getByCustomerType(string $customerType)
    {
        return self::where('is_active', true)
            ->where(function ($query) use ($customerType) {
                $query->whereJsonContains('customers', $customerType)
                    ->orWhereNull('customers');
            })
            ->orderBy('pos')
            ->get();
    }

    public function isAvailableForCustomer(string $customerType): bool
    {
        if (!$this->customers) {
            return true; 
        }

        return in_array($customerType, $this->customers);
    }
}

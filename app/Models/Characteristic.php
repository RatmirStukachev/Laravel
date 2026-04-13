<?php

namespace App\Models;

use App\Enums\ChTypeEnum;
use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Characteristic extends Model
{
    Use UsedFunctions;

    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'type' => ChTypeEnum::class,
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_characteristic', 'characteristic_id', 'category_id');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_characteristic', 'characteristic_id', 'product_id')
            ->withPivot('value');
    }
}

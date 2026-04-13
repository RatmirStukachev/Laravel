<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель Setting
 *
 * @property int $id
 * @property string $data_key
 * @property array $data_val
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 */
class Setting extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data_val' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель PageContent
 *
 * @property int $id
 * @property string $key
 * @property array $data
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * 
 */
class PageContent extends Model
{
    protected $guarded = [];

    protected $casts = [
        'data' => 'array',
    ];
}

<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;

/**
 * Модель Brand
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $desc
 * @property string|null $content
 * @property string|null $svg
 * @property string|null $image
 * @property int $pos
 * @property boolean $is_active
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class Brand extends Model
{
    use UsedFunctions;

    protected $guarded = [];
}

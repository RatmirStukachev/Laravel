<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * Модель FeedBack
 *
 * @property int $id
 * @property string $name
 * @property string|null $company
 * @property string|null $email
 * @property string|null $phone
 * @property string|null $message
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 *
 */
class FeedBack extends Model
{
    protected $guarded = [];
}

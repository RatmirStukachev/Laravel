<?php

namespace App\Models;

use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use UsedFunctions;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Получить отформатированную дату для отображения
     */
    public function getFormattedDateAttribute(): string
    {
        return $this->created_at ? $this->created_at->locale('ru')->translatedFormat('j F Y') : '';
    }
}

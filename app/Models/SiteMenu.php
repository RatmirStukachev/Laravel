<?php

namespace App\Models;

use App\Models\Traits\UsedFunctions;
use Illuminate\Database\Eloquent\Model;

class SiteMenu extends Model
{
    use UsedFunctions;

    protected $guarded = [];
    public $timestamps = false;

    protected $casts = [
        'is_active' => 'boolean',
        'master' => 'boolean',
        'slave' => 'boolean',
    ];
}
